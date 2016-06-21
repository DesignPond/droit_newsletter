<?php namespace designpond\newsletter\Newsletter\Repo;

interface NewsletterUserInterface {

	public function getAll();
    public function getAllNbr($nbr);
	public function find($id);
	public function findByEmail($email);
    public function get_ajax($draw, $start, $length, $sortCol, $sortDir, $search);
    public function activate($token);
	public function subscribe($id,$newsletter_id);
	public function create(array $data);
	public function update(array $data);
    public function add(array $data);
	public function delete($id);

}
