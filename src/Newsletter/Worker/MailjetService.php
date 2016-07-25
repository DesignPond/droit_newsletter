<?php 
namespace designpond\newsletter\Newsletter\Worker;

use \Mailjet\Resources as Resources;
use \Mailjet\Client as Client;

class MailjetService {

    protected $mailjet;
    protected $ressource;

    protected $sender = '';
    protected $list   = '';

    public function __construct(Client $mailjet,Resources $ressource)
    {
        $this->mailjet   = $mailjet;
        $this->ressource = $ressource;
    }

    public function setSenderEmail($email)
    {
        $this->sender = $email;
    }

    public function setList($list)
    {
        $this->list = $list;
    }
    
    public function getList()
    {
        return $this->list;
    }

    public function getAllLists()
    {
        $response = $this->mailjet->get(Resources::$Contactslist);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function getSubscribers()
    {
        $response = $this->mailjet->get(Resources::$Contactslist, ["ID" => $this->list]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function getAllSubscribers()
    {
        $response = $this->mailjet->get(Resources::$Contact);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function addContact($email)
    {
        $response = $this->mailjet->post(Resources::$Contact, ['Email'  => $email]);

        if($response->success())
            return $response->getData(); // returns ID directly
        else
            return $this->getContactByEmail($email);
    }

    public function getContactByEmail($contactEmail)
    {
        $response = $this->mailjet->get(Resources::$Contact, ['ID'  => $contactEmail]);

        if($response->success()){
            $contact = $response->getData();
            return $contact[0]['ID']; // returns ID directly
        }

        return false;
    }

    public function addContactToList($contactID)
    {
        $response = $this->mailjet->post(Resources::$Listrecipient, ['body' => ["ContactID" => $contactID, "ListID" => $this->list , "IsActive" => "True"]]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function subscribeEmailToList($email)
    {
        // Add contact to our list and get id back
        $contactID = $this->addContact($email);

        // Attempt tu subscribe if fails we try to re subscribe
        $response = $this->addContactToList($contactID);

        if(!$response)
        {
            throw new \designpond\newsletter\Exceptions\SubscribeUserException('Erreur synchronisation email vers mailjet');
        }

        return $response;

    }
    public function removeContact($email)
    {
        $listRecipientID = $this->getListRecipient($email);

        if(!$listRecipientID)
        {
            return true;
        }

        $response = $this->mailjet->delete(Resources::$Listrecipient, ['ID' => $listRecipientID]);

        if($response->success())
            return true;
        else
            return false;
    }

    /**
     * Lists
     */
    public function getListRecipient($email)
    {
        $ContactID = $this->getContactByEmail($email);

        $response = $this->mailjet->get(Resources::$Listrecipient, ['filters' => ['Contact' => $ContactID, "ContactsList"  => $this->list]]);

        if($response->success()){
            $contact = $response->getData();
            return $contact[0]['ID']; // returns ID directly
        }

        return false;
    }

    /**
     * Campagnes
     */
    public function getCampagne($CampaignID)
    {
        $response = $this->mailjet->get(Resources::$Campaign, ['unique' => 'mj.nl='.$CampaignID]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function createCampagne($campagne){

        # Parameters
        $params = [
            'Title'          => $campagne->newsletter->titre,
            'Subject'        => $campagne->sujet,
            'ContactsListID' => $this->list,
            'Locale'         => 'fr',
            'Callback'       => url('/'),
            'HeaderLink'     => url('/'),
            'SenderEmail'    => $campagne->newsletter->from_email,
            'Sender'         => $campagne->newsletter->from_name
        ];

        # Call
        $response = $this->mailjet->post(Resources::$Newsletter, ['body' => $params]);

        if($response->success())
        {
            $newsletter = $response->getData();

            $campagne->api_campagne_id = $newsletter[0]['ID'];
            $campagne->save();

            return $newsletter[0]['ID']; // returns ID directly
        }

        return false;
    }

    public function setHtml($html,$id)
    {
        $body = [
            'Html-part' => $html,
            'Text-part' => strip_tags($html)
        ];

        $response = $this->mailjet->put(Resources::$NewsletterDetailcontent, ['id' => $id, 'body' => $body]);

        if($response->success())
            return $response->getData();
        else
            return false;

    }
    
    public function sendTest($id,$email,$sujet)
    {
        $body = [
            'Recipients' => [
                ['Email' => $email, 'Name'  => $sujet]
            ]
        ];

        $response = $this->mailjet->post(Resources::$NewsletterTest, ['id' => $id, 'body' => $body]);

        if($response->success())
            return $response->getData();
        else
            return $response->getData();

    }
    
    public function sendCampagne($id,$CampaignID){}

    /**
     * Statistiques
     */
    public function statsCampagne($id){}
    public function statsListe(){}
    public function campagneAggregate($id){}

    /**
     * import listes
     */
    public function uploadCSVContactslistData($data){}
    public function importCSVContactslistData($data){}
}
