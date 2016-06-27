<?php

namespace Designpond\Newsletter\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use designpond\newsletter\Http\Requests\SubscribeRequest;

use designpond\newsletter\Newsletter\Repo\NewsletterUserInterface;
use designpond\newsletter\Newsletter\Worker\MailjetInterface;

class InscriptionController extends Controller
{
    protected $subscription;
    protected $worker;

    public function __construct(MailjetInterface $worker, NewsletterUserInterface $subscription)
    {
        $this->worker        = $worker;
        $this->subscription  = $subscription;
    }

    /**
     * Activate newsletter abo
     * GET //activation
     *
     * @return Response
     */
    public function activation($token)
    {
        // Activate the email on the website
        $user = $this->subscription->activate($token);

        if(!$user)
        {
            return redirect('/')->with(['status' => 'danger', 'jeton' => true ,'message' => 'Le jeton ne correspond pas ou à expiré']);
        }

        //Subscribe to mailjet
        $this->worker->subscribeEmailToList( $user->email );

        return redirect('/')->with(['status' => 'success', 'message' => 'Vous êtes maintenant abonné à la newsletter']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscribeRequest $request)
    {
        $email = $this->subscription->findByEmail($request->input('email'));

        if($email)
        {
            $messages = ['status' => 'warning', 'message' => 'Cet email existe déjà'];

            if($email->activated_at == NULL)
            {
                $messages['resend'] = true;
            }

            return redirect('/')->withInput()->with($messages);
        }

        // Subscribe user with activation token to website list and sync newsletter abos
        $suscribe = $this->subscription->create(['email' => $request->email, 'activation_token' => md5($request->email.\Carbon\Carbon::now()) ]);

        $suscribe->subscriptions()->attach($request->newsletter_id);

        \Mail::send('newsletter::Email.confirmation', array('token' => $suscribe->activation_token), function($message) use ($suscribe)
        {
            $message->to($suscribe->email, $suscribe->email)->subject('Inscription!');
        });

        return redirect('/')
            ->with([
                'status'  => 'success',
                'message' => '<strong>Merci pour votre inscription!</strong><br/>Veuillez confirmer votre adresse email en cliquant le lien qui vous a été envoyé par email'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(SubscribeRequest $request)
    {
        // find the abo
        $abonne = $this->subscription->findByEmail( $request->email );

        // Sync the abos to newsletter we have
        $abonne->subscriptions()->detach($request->newsletter_id);

        if(!$this->worker->removeContact($abonne->email))
        {
            throw new \designpond\newsletter\Exceptions\SubscribeUserException('Erreur synchronisation email vers mailjet');
        }

        // Delete person only if no subscription left
        if($abonne->subscriptions->isEmpty())
        {
            $this->subscription->delete($abonne->email);
        }

        return redirect('/')->with(array('status' => 'success', 'message' => '<strong>Vous avez été désinscrit</strong>'));
    }

    /**
     * Resend activation link email
     * POST /inscription/resend/email
     *
     * @return Response
     */
    public function resend(Request $request)
    {
        $subscribe = $this->subscription->findByEmail($request->input('email'));

        \Mail::send('newsletter::Email.confirmation', array('token' => $subscribe->activation_token), function($message) use ($subscribe)
        {
            $message->to($subscribe->email, $subscribe->email)->subject('Inscription!');
        });

        return redirect('/')->with(['status'  => 'success', 'message' => '<strong>Lien d\'activation envoyé</strong>']);
    }
}
