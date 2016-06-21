<?php namespace designpond\newsletter\Newsletter\Repo;

use designpond\newsletter\Newsletter\Entities\Newsletter_emails as M;
use designpond\newsletter\Newsletter\Repo\NewsletterEmailInterface;

class NewsletterEmailEloquent implements NewsletterEmailInterface{

	protected $email;

	public function __construct(M $email)
	{
		$this->email = $email;
	}
	
	public function getAll(){
		
		return $this->email->all();
	}
	
	public function find($id){

		return $this->email->findOrFail($id);
	}

    public function create(array $data){

        $email = $this->email->create(array(
            'email'        => $data['email'],
            'list_id'      => $data['list_id']
        ));

        if( ! $email )
        {
            return false;
        }

        return $email;
    }

    public function update(array $data){

        $email = $this->email->findOrFail($data['id']);

        if( !$email )
        {
            return false;
        }

        $email->fill($data);
        $email->save();

        return $email;
    }

	public function delete($id){

        $email = $this->email->find($id);

        return $email->delete();
    }
}
