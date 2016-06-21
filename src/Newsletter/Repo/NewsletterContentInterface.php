<?php namespace designpond\newsletter\Newsletter\Repo;

interface NewsletterContentInterface {

	public function getByCampagne($newsletter_campagne_id);
    public function getRang($newsletter_campagne_id);
    public function updateSorting(array $data);
    public function getArretsByCampagne($brouillon);
	public function find($data);
    public function findyByImage($file);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);

}
