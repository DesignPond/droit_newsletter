<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Http\Requests\SendTestRequest;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Worker\CampagneInterface;
use designpond\newsletter\Newsletter\Worker\MailjetInterface;

class SendController extends Controller
{
    protected $campagne;
    protected $worker;
    protected $mailjet;

    public function __construct(NewsletterCampagneInterface $campagne, CampagneInterface $worker, MailjetInterface $mailjet)
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

        //set or update html
        $html = $this->worker->html($campagne->id);

        // Sync html content to api service and send to newsletter list!
        $this->mailjet->setHtml($html,$campagne->api_campagne_id);
        $this->mailjet->setList($campagne->newsletter->list_id); // list id
        $this->mailjet->setSenderEmail($campagne->newsletter->from_email); // from_email

        $result = $this->mailjet->sendCampagne($campagne->api_campagne_id,$campagne->id);

        if(!$result)
        {
            throw new \designpond\newsletter\Exceptions\CampagneSendException('Problème avec l\'envoi');
        }

        // Update campagne status
        $this->campagne->update(['id' => $request->input('id'), 'status' => 'envoyé', 'updated_at' => date('Y-m-d G:i:s')]);

        return redirect('build/newsletter')->with(['status' => 'success' , 'message' => 'Campagne envoyé!']);

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

        $this->mailjet->setSenderEmail($campagne->newsletter->from_email); // from_email
        // Send the email
        $this->mailjet->sendTest($request->input('email'),$html,$sujet);

        // If we want to send via ajax just add a send_type "ajax
        $ajax = $request->input('send_type', 'normal');

        if($ajax == 'ajax'){
            echo 'ok'; exit;
        }

        return redirect('build/campagne/'.$campagne->id)->with( ['status' => 'success' , 'message' => 'Email de test envoyé!'] );
    }
}
