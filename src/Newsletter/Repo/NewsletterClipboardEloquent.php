<?php namespace designpond\newsletter\Newsletter\Repo;

use designpond\newsletter\Newsletter\Repo\NewsletterClipboardInterface;
use designpond\newsletter\Newsletter\Entities\Newsletter_clipboards as M;

class NewsletterClipboardEloquent implements NewsletterClipboardInterface{

	protected $clipboard;

	public function __construct(M $clipboard)
	{
		$this->clipboard = $clipboard;
	}
	
	public function getAll(){
		
		return $this->clipboard->all();
	}

	public function find($id){
				
		return $this->clipboard->find($id);
	}

	public function create(array $data)
	{
		$clipboard = $this->clipboard->create(array(
			'content_id' => $data['content_id'],
		));
		
		if( ! $clipboard )
		{
			return false;
		}
		
		return $clipboard;
	}
	
	public function update(array $data){

        $clipboard = $this->clipboard->findOrFail($data['id']);
		
		if( ! $clipboard )
		{
			return false;
		}

        $clipboard->content_id = $data['content_id'];
		$clipboard->save();
		
		return $clipboard;
	}

	public function delete($id)
	{
        $clipboard = $this->clipboard->find($id);

		return $clipboard->delete();
	}
}
