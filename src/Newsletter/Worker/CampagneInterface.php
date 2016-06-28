<?php namespace designpond\newsletter\Newsletter\Worker;

interface CampagneInterface {

    public function arretsToHide();
    public function infos($id);
    public function html($id);
    public function siteNewsletter($site_id);
}
