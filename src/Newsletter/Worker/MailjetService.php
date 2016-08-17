<?php 
namespace designpond\newsletter\Newsletter\Worker;

use designpond\newsletter\Newsletter\Worker\MailjetServiceInterface;

use \Mailjet\Resources as Resources;
use \Mailjet\Client as Client;

class MailjetService implements MailjetServiceInterface{

    protected $mailjet;
    protected $ressource;

    protected $sender = '';
    protected $list   = null;

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
            return [];
    }

    public function getSubscribers()
    {
        $this->hasList();

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
        $this->hasList();

        $response = $this->mailjet->post(Resources::$Listrecipient, ['body' => ["ContactID" => $contactID, "ListID" => $this->list , "IsActive" => "True"]]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function subscribeEmailToList($email)
    {
        $response = $this->mailjet->post(Resources::$ContactslistManagecontact, [
            "ID"   => $this->list,
            'body' => [
                "Email"   => trim($email),
                "Action"  => "addnoforce"
            ]
        ]);

        if($response->success())
            return $response->getData();
        else
            return false;
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
        $this->hasList();

        $ContactID = $this->getContactByEmail($email);

        $response = $this->mailjet->get(Resources::$Listrecipient, ['filters' => ['Contact' => $ContactID, "ContactsList"  => $this->list]]);

        if($response->success()){
            $contact = $response->getData();
            return isset($contact[0]) ? $contact[0]['ID'] : false; // returns ID directly
        }

        return false;
    }

    /**
     * Campagnes
     */
    public function getCampagne($CampaignID)
    {
        $response = $this->mailjet->get(Resources::$Newsletter, ['ID' => $CampaignID]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function updateCampagne($CampaignID, $status)
    {
        $response = $this->mailjet->put(Resources::$Newsletter, ['ID' => $CampaignID, 'body' => ['Status' => $status]]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function createCampagne($campagne){

        $this->hasList();
        
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

        $response = $this->mailjet->put(Resources::$NewsletterDetailcontent, ['ID' => $id, 'body' => $body]);

        if($response->success())
            return $response->getData();
        else
            return false;
    }

    public function getHtml($id)
    {
        $response = $this->mailjet->get(Resources::$NewsletterDetailcontent, ['ID' => $id]);

        if($response->success())
        {
            $html = $response->getData();
            return !empty($html[0]['Html-part']) ? $html[0]['Html-part'] : null;
        }
        else
        {
            return false;
        }
    }
    
    public function sendTest($id,$email,$sujet)
    {
        $body = [
            'Recipients' => [
                ['Email' => $email, 'Name'  => $sujet]
            ]
        ];

        $response = $this->mailjet->post(Resources::$NewsletterTest, ['id' => $id, 'body' => $body]);

        $success = $response->success() ? true : false;

        return ['success' => $success, 'info' => $response->getData()];
    }
    
    public function sendCampagne($id, $date = null)
    {
        $this->hasList();

        $date = $date ? $date : 'NOW';

        $response = $this->mailjet->post(Resources::$NewsletterSchedule, ['id' => $id, 'body' => ['date' => $date]]);

        $success = $response->success() ? true : false;

        return ['success' => $success, 'info' => $response->getData()];
    }

    public function deleteCampagne($id)
    {
        $response = $this->mailjet->delete(Resources::$NewsletterSchedule, ['id' => $id]);

        $success = $response->success() ? true : false;

        return ['success' => $success, 'info' => $response->getData()];
    }

    /**
     * Statistiques
     */
    public function statsCampagne($id)
    {
        $response = $this->mailjet->get(Resources::$Campaignstatistics, ['ID' => 'mj.nl='.$id]);

        if($response->success()){
            $stats = $response->getData();
            return $stats[0]; // returns ID directly
        }

        return false;
    }
    
    public function clickStatistics($id, $offset = 0)
    {
        $response = $this->mailjet->get(Resources::$Toplinkclicked, ['filters' => ['CampaignID' => ' mj.nl='.$id, 'Limit' => 500, 'Offset' => $offset]]);

        if($response->success()){
            return $response->getData();
        }

        return null;
    }

    /**
     * import listes
     */
    public function uploadCSVContactslistData($CSVContent)
    {
        $this->hasList();

        $response = $this->mailjet->post(Resources::$ContactslistCsvdata, ['body' => $CSVContent, 'id' => $this->list]);

        if($response->success()){
            $import = $response->getData();
            return $import['ID']; // returns ID directly
        }

        return false;
    }
    
    public function importCSVContactslistData($dataID)
    {
        $this->hasList();

        $body = [
            'ContactsListID' => $this->list,
            'DataID'         => $dataID,
            'Method'         => "addnoforce"
        ];

        $response = $this->mailjet->post(Resources::$Csvimport, ['body' => $body]);

        if($response->success()){
            return $response->getData();
        }

        return false;
    }

    /*
     * Misc test
     * */
    public function hasList()
    {
        if(!$this->list){
            throw new \designpond\newsletter\Exceptions\ListNotSetException('Attention aucune liste indiqueé');
        }
    }
}
