<?php namespace designpond\newsletter\Newsletter\Repo;

interface NewsletterCampagneInterface {

	public function getAll();
    public function getAllSent();
    public function getLastCampagne();
	public function getArchives($newsletter_id,$year);
	public function find($data);
	public function create(array $data);
	public function update(array $data);
    public function updateStatus($data);
	public function delete($id);

}
