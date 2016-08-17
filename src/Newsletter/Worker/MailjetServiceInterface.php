<?php namespace designpond\newsletter\Newsletter\Worker;

interface MailjetServiceInterface {

    public function setList($list);
    public function setSenderEmail($email);
    public function getList();
    public function getAllLists();
    /**
     * Subscriptions
     */
    public function getSubscribers();
    public function getAllSubscribers();
    public function addContact($email);
    public function getContactByEmail($contactEmail);
    public function addContactToList($contactID);
    public function subscribeEmailToList($email);
    public function removeContact($email);

    /**
     * Lists
     */
    public function getListRecipient($email);

    /**
     * Campagnes
     */
    public function createCampagne($campagne);
    public function getCampagne($CampaignID);
    public function updateCampagne($CampaignID, $status);
    public function setHtml($html,$id);
    public function sendTest($id,$email,$sujet);
    public function sendCampagne($id, $date = null);
    public function deleteCampagne($id);

    /**
     * Statistiques
     */
    public function statsCampagne($id);
    public function clickStatistics($id, $offset = 0);

    /**
     * import listes
     */
    public function uploadCSVContactslistData($data);
    public function importCSVContactslistData($data);
}
