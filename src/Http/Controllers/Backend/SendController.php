<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Http\Requests\SendTestRequest;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Worker\CampagneInterface;
use designpond\newsletter\Newsletter\Worker\MailjetServiceInterface;

class SendController extends Controller
{
    protected $campagne;
    protected $worker;
    protected $mailjet;

    public function __construct(NewsletterCampagneInterface $campagne, CampagneInterface $worker, MailjetServiceInterface $mailjet)
    {
        $this->campagne = $campagne;
        $this->worker   = $worker;
        $this->mailjet  = $mailjet;

        setlocale(LC_ALL, 'fr_FR.UTF-8');
        view()->share('isNewsletter',true);
    }
    
    /**
     * Send campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function campagne(Request $request)
    {
        // Get campagne
        $campagne = $this->campagne->find($request->input('id'));
        $date     = $request->input('date',null);

        //set or update html
        $html = $this->worker->html($campagne->id);

        $this->mailjet->setList($campagne->newsletter->list_id); // list id
        $this->mailjet->setSenderEmail($campagne->newsletter->from_email); // list from_email

        // Sync html content to api service and send to newsletter list!
        $response = $this->mailjet->setHtml($html,$campagne->api_campagne_id);

        if(!$response)
        {
            throw new \designpond\newsletter\Exceptions\CampagneUpdateException('Problème avec la préparation du contenu');
        }

        /*
         *  Send at specified date or delay for 15 minutes before sending just in case
         */
        $toSend = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::now()->addMinutes(15);
        
        $result = $this->mailjet->sendCampagne($campagne->api_campagne_id, $toSend->toIso8601String());

        if(!$result['success'])
        {
            throw new \designpond\newsletter\Exceptions\CampagneSendException('Problème avec l\'envoi'.$result['info']['ErrorMessage'].'; Code: '.$result['info']['StatusCode']);
        }

        // Update campagne status
        $this->campagne->update(['id' => $campagne->id, 'status' => 'envoyé', 'updated_at' => date('Y-m-d G:i:s'), 'send_at' => $toSend]);

        alert()->success('Campagne envoyé!');

        return redirect('build/newsletter');
    }
    
    /**
     * Send test campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function test(SendTestRequest $request)
    {
        $campagne = $this->campagne->find($request->input('id'));
        $sujet    = ($campagne->status == 'brouillon' ? 'TEST | '.$campagne->sujet : $campagne->sujet );

        // GET html
        $html = $this->worker->html($campagne->id);

        // Sync html content to api service and send to newsletter list!
        $response = $this->mailjet->setHtml($html,$campagne->api_campagne_id);
        $this->mailjet->setSenderEmail($campagne->newsletter->from_email); // list from_email 

        if(!$response)
        {
            throw new \designpond\newsletter\Exceptions\CampagneUpdateException('Problème avec la préparation du contenu');
        }
        
        // Send the email
        $result = $this->mailjet->sendTest($campagne->api_campagne_id,$request->input('email'),$sujet);

        if(!$result['success'])
        {
            throw new \designpond\newsletter\Exceptions\TestSendException('Problème avec le test: '.$result['info']['ErrorMessage'].'; Code: '.$result['info']['StatusCode']);
        }

        // If we want to send via ajax just add a send_type "ajax
        $ajax = $request->input('send_type', 'normal');

        if($ajax == 'ajax') {
            echo 'ok'; exit;
        }

        alert()->success('Email de test envoyé!');

        return redirect('build/campagne/'.$campagne->id);
    }

    /**
     * Send test campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function forward(SendTestRequest $request)
    {
        $campagne = $this->campagne->find($request->input('id'));
        $sujet    = ($campagne->status == 'brouillon' ? 'TEST | '.$campagne->sujet : $campagne->sujet );

        // GET html
        $html  = $this->worker->html($campagne->id);
        $email = $request->input('email');
        
        \Mail::send([], [], function ($message) use ($html,$email,$sujet) {
            $message->to($email)->subject($sujet)->setBody($html, 'text/html');
        });

        // If we want to send via ajax just add a send_type "ajax
        $ajax = $request->input('send_type', 'normal');

        if($ajax == 'ajax') {
            echo 'ok'; exit;
        }

        alert()->success('Email de test envoyé!');

        return redirect('build/campagne/'.$campagne->id);
    }
}
