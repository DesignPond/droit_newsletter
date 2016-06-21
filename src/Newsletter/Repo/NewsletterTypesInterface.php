<?php namespace designpond\newsletter\Newsletter\Repo;

interface NewsletterTypesInterface {

	public function getAll();
	public function find($data);
    public function findByPartial($partial);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);

}
