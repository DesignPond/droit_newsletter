<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterUserInterface;
use designpond\newsletter\Newsletter\Worker\MailjetServiceInterface;

use designpond\newsletter\Http\Requests\RemoveNewsletterUserRequest;

class SubscriberController extends Controller
{
    protected $subscriber;
    protected $newsletter;
    protected $worker;

    public function __construct(NewsletterUserInterface $subscriber, NewsletterInterface $newsletter, MailjetServiceInterface $worker)
    {
        $this->subscriber = $subscriber;
        $this->newsletter = $newsletter;
        $this->worker     = $worker;

        view()->share('isNewsletter',true);
    }

    /**
     * Display a listing of the resource.
     * GET /subscriber
     *
     * @return Response
     */
    public function index()
    {
        return view('newsletter::Backend.subscribers.index');
    }

    /**
     * Display a listing of tsubscribers for ajax
     * GET /subscriber/getAllAbos
     *
     * @return Response
     */
    public function subscribers(Request $request)
    {
        $order  = $request->input('order');
        $search = $request->input('search',null);
        $search = ($search ? $search['value'] : null);

        return $this->subscriber->get_ajax(
            $request->input('draw'), $request->input('start'), $request->input('length'), $order[0]['column'], $order[0]['dir'], $search
        );
    }

    /**
     * Show the form for creating a new resource.
     * GET /subscriber/create
     *
     * @return Response
     */
    public function create()
    {
        $newsletter = $this->newsletter->getAll();

        return view('newsletter::Backend.subscribers.create')->with(['newsletter' => $newsletter ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /subscriber
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Subscribe user with activation token to website list and sync newsletter abos
        $subscribe = $this->subscriber->create(
            [
                'email'         => $request->input('email'),
                'activated_at'  => \Carbon\Carbon::now(),
                'newsletter_id' => $request->input('newsletter_id')
            ]
        );

        //Subscribe to mailjet
        $lists = $request->input('newsletter_id');

        if(!empty($lists))
        {
            foreach($lists as $list)
            {
                $newsletter = $this->newsletter->find($list);
                $this->worker->setList($newsletter->list_id);
                $this->worker->subscribeEmailToList($subscribe->email);
            }
        }

        return redirect('build/subscriber')->with(['status' => 'success' , 'message' => 'Abonné ajouté']);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /subscriber/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $subscriber = $this->subscriber->find($id);
        $newsletter = $this->newsletter->getAll();

        return view('newsletter::Backend.subscribers.show')->with(['subscriber' => $subscriber , 'newsletter' => $newsletter]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /subscriber/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(RemoveNewsletterUserRequest $request, $id)
    {
        $activated_at = ($request->input('activation') ? date('Y-m-d G:i:s') : null);
        $subscriber   = $this->subscriber->find($id);

        $hadAbos = $subscriber->subscriptions->pluck('id')->all();

        $subscriber = $this->subscriber->update([
            'id'            => $id,
            'email'         => $request->input('email'),
            'newsletter_id' => $request->input('newsletter_id',[]),
            'activated_at'  => $activated_at
        ]);

        $hasAbos = $subscriber->subscriptions->pluck('id')->all();

        $added   = array_filter(array_diff($hasAbos,$hadAbos));
        $removed = array_filter(array_diff($hadAbos,$hasAbos));

        if(!empty($added) && $activated_at)
        {
            foreach($added as $list)
            {
                $newsletter = $this->newsletter->find($list);

                $this->worker->setList($newsletter->list_id);
                $this->worker->subscribeEmailToList($subscriber->email);
            }
        }

        if(!empty($removed))
        {
            foreach($removed as $list)
            {
                $newsletter = $this->newsletter->find($list);
                
                $this->worker->setList($newsletter->list_id);
                $this->worker->removeContact($subscriber->email);
            }
        }

        return redirect('build/subscriber/'.$id)->with(['status' => 'success' , 'message' => 'Abonné édité']);

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /subscriber/{id}
     *
     * @param  int  $email
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        // Validate the email
        $this->validate($request, array('email' => 'required'));

        // find the abo
        $subscriber = $this->subscriber->findByEmail($request->email);

        // Remove all the abos we have
        $subscriber->subscriptions()->detach();

        // Delete the subscriber from DB
        $this->subscriber->delete($subscriber->email);

        $newsletters = $this->newsletter->getAll();

        foreach($newsletters as $newsletter)
        {
            $this->worker->setList($newsletter->list_id);

            // Remove subscriber from list mailjet
            if(!$this->worker->removeContact($subscriber->email))
            {
                throw new \designpond\newsletter\Exceptions\DeleteUserException('Erreur avec la suppression de l\'abonnés sur mailjet');
            }
        }

        return redirect('build/subscriber')->with(['status' => 'success', 'message' => 'Abonné supprimé']);
    }
}
