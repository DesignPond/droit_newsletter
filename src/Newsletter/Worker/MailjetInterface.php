<?php namespace designpond\newsletter\Newsletter\Worker;

interface MailjetInterface {

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
    public function getCampagne($CampaignID);
    public function createCampagne($campagne);
    public function setHtml($html,$id);
    public function sendTest($email,$html,$sujet);
    public function sendCampagne($id,$CampaignID);

    /**
     * Statistiques
     */
    public function statsCampagne($id);
    public function statsListe();
    public function campagneAggregate($id);

    /**
     * import listes
     */
    public function uploadCSVContactslistData($data);
    public function importCSVContactslistData($data);
}
