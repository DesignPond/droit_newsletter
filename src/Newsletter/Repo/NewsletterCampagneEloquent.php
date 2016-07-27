<?php namespace designpond\newsletter\Newsletter\Repo;

use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Entities\Newsletter_campagnes as M;

class NewsletterCampagneEloquent implements NewsletterCampagneInterface{

	protected $campagne;

	public function __construct(M $campagne)
	{
		$this->campagne = $campagne;
	}
	
	public function getAll($newsletter_id = null)
	{
		return $this->campagne->news($newsletter_id)->orderBy('created_at','DESC')->get();
	}

    public function getAllSent(){

        return $this->campagne->where('status','=','envoyé')->orderBy('id','DESC')->get();
    }

    public function getLastCampagne($newsletter_id = null)
	{
        return $this->campagne->where('status','=','envoyé')->news($newsletter_id)->orderBy('id','DESC')->get();
    }

	public function getArchives($newsletter_id,$year)
	{
		return $this->campagne->where('newsletter_id','=',$newsletter_id)
			->where('status','=','envoyé')
			->where(function ($query) {
				$query->whereDate('send_at', '<', \Carbon\Carbon::now())->orWhereNull('send_at');
			})
			->whereRaw('YEAR(`created_at`) = ?', [$year])
			->orderBy('created_at','DESC')
			->get();
	}

	public function find($id)
	{
        $with = ['newsletter','content'];

		$with = config('newsletter.multi') ? array_merge($with,['newsletter.site']) : $with;
		$with = in_array(5,array_keys(config('newsletter.components'))) ? array_merge($with,['content.arret']) : $with;
        $with = in_array(7,array_keys(config('newsletter.components'))) ? array_merge($with,['content.groupe.arrets','content.groupe']) : $with;

		return $this->campagne->with($with)->find($id);
	}

	public function create(array $data){

		$campagne = $this->campagne->create(array(
			'sujet'          => $data['sujet'],
			'auteurs'        => $data['auteurs'],
            'newsletter_id'  => $data['newsletter_id'],
			'created_at'     => date('Y-m-d G:i:s'),
			'updated_at'     => date('Y-m-d G:i:s')
		));
		
		if( ! $campagne )
		{
			return false;
		}
		
		return $campagne;
		
	}
	
	public function update(array $data){

        $campagne = $this->campagne->findOrFail($data['id']);
		
		if( ! $campagne )
		{
			return false;
		}

        $campagne->fill($data);
		$campagne->updated_at = date('Y-m-d G:i:s');

		$campagne->save();
		
		return $campagne;
	}

    public function updateStatus($data){

        $campagne = $this->campagne->findOrFail($data['id']);

        if( ! $campagne )
        {
            return false;
        }

        $campagne->status      = $data['status'];
        $campagne->updated_at  = date('Y-m-d G:i:s');

        $campagne->save();

        return $campagne;
    }

	public function delete($id){

        $campagne = $this->campagne->find($id);

		return $campagne->delete();
		
	}
}
