<?php

namespace designpond\newsletter\Newsletter\Worker;

use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Worker\MailjetInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterUserInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Worker\CampagneInterface;
use designpond\newsletter\Newsletter\Service\UploadInterface;
use Maatwebsite\Excel\Excel;

class ImportWorker implements ImportWorkerInterface
{
    protected $mailjet;
    protected $subscriber;
    protected $newsletter;
    protected $excel;
    protected $campagne;
    protected $worker;
    protected $upload;

    public function __construct(
        MailjetInterface $mailjet ,
        NewsletterUserInterface $subscriber,
        NewsletterInterface $newsletter,
        Excel $excel,
        NewsletterCampagneInterface $campagne,
        CampagneInterface $worker,
        UploadInterface $upload
    )
    {
        $this->mailjet    = $mailjet;
        $this->newsletter = $newsletter;
        $this->subscriber = $subscriber;
        $this->excel      = $excel;
        $this->campagne   = $campagne;
        $this->worker     = $worker;
        $this->mailjet    = $mailjet;
        $this->upload     = $upload;
    }

    public function import($data,$file)
    {
        $file          = $this->upload->upload( $file , 'files' );
        $newsletter_id = isset($data['newsletter_id']) && $data['newsletter_id'] > 0 ? $data['newsletter_id'] : null;

        if(!$file)
        {
            throw new \designpond\newsletter\Exceptions\FileUploadException('Upload failed');
        }

        // path to xls
        $path = public_path('files/'.$file['name']);

        // Read uploaded xls
        $results = $this->read($path);

        // If the upload is not formatted correctly redirect back
        if(isset($results) && $results->isEmpty() || !array_has($results->toArray(), '0.email') )
        {
            throw new \designpond\newsletter\Exceptions\BadFormatException('Le fichier est vide ou mal formaté');
        }

        // we want to import in one of the newsletter subscriber's list
        if($newsletter_id)
        {
            // Subscribe the new emails
            $this->subscribe($results,$newsletter_id);

            // Store imported file as csv for mailjet sync
            $this->store($path);

            // Mailjet sync
            $this->sync($file['name'], $newsletter_id);
        }

        return $results;
    }

    public function subscribe($results,$list = null)
    {
        foreach($results as $email)
        {
            $subscriber = $this->subscriber->findByEmail($email->email);

            if(!$subscriber)
            {
                $subscriber = $this->subscriber->create([
                    'email'         => $email->email,
                    'activated_at'  => \Carbon\Carbon::now(),
                    'newsletter_id' => $list
                ]);
            }

            $this->subscriber->subscribe($subscriber->id,$list);
        }
    }

    public function read($file)
    {
        return $this->excel->load($file, function($reader) {
            $reader->ignoreEmpty();
            $reader->setSeparator('\r\n');
        })->get();
    }

    public function store($file)
    {
        // Convert to csv
        $this->excel->load($file)->store('csv', public_path('files/import'));
    }

    public function sync($file,$list)
    {
        // Import csv to mailjet
        $newsletter = $this->newsletter->find($list);
        $this->mailjet->setList($newsletter->list_id); // testing list

        $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);

        $dataID   = $this->mailjet->uploadCSVContactslistData(file_get_contents(public_path('files/import/'.$filename.'.csv')));
        $response = $this->mailjet->importCSVContactslistData($dataID->ID);
    }

    public function send($campagne_id,$list)
    {
        $campagne = $this->campagne->find($campagne_id);
        $html     = $this->worker->html($campagne_id);

        if(!$list->emails->isEmpty())
        {
            foreach($list->emails as $email)
            {
                \Mail::send([], [], function ($message) use ($campagne,$html,$email)
                {
                    $message->to($email->email, $email->email)->subject($campagne->sujet);
                    $message->setBody($html, 'text/html');
                });
            }
        }
    }
}