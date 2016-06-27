<?php namespace designpond\newsletter\Newsletter\Repo;

use designpond\newsletter\Newsletter\Repo\NewsletterContentInterface;
use designpond\newsletter\Newsletter\Entities\Newsletter_contents as M;
use designpond\newsletter\Newsletter\Helper\Helper;

class NewsletterContentEloquent implements NewsletterContentInterface{

	protected $contents;
    protected $groupe;

	/**
	 * Construct a new SentryUser Object
	 */
	public function __construct(M $contents)
	{
		$this->contents = $contents;
	}
	
	public function getByCampagne($newsletter_campagne_id)
    {
        $with = in_array(5,array_keys(config('newsletter.components'))) ? ['type','arrets'] : ['type'];

		return $this->contents->where('newsletter_campagne_id','=',$newsletter_campagne_id)->with($with)->orderBy('newsletter_contents.rang','ASC')->get();
	}

    public function getArretsByCampagne($brouillon){

        return $this->contents->where('newsletter_campagne_id','=',$brouillon)->get();
    }

    public function getRang($newsletter_campagne_id){

        $rang = $this->contents->where('newsletter_campagne_id','=',$newsletter_campagne_id)->max('rang');

        return ($rang ? $rang : 0);
    }

	public function find($id){
				
		return $this->contents->where('id','=',$id)->with(['campagne','newsletter'])->get()->first();
	}

    public function findyByImage($file){

        return $this->contents->where('image','=',$file)->get();
    }

    public function updateSorting(array $data){

        if(!empty($data))
        {
            foreach($data as $rang => $id)
            {
                $contents = $this->find($id);

                if( ! $contents )
                {
                    return false;
                }

                $contents->rang = $rang;
                $contents->save();
            }

            return true;
        }
    }

	public function create(array $data){

        $helper = new Helper();

		$contents = $this->contents->create(array(
			'type_id'                => $data['type_id'],
			'titre'                  => (isset($data['titre']) ? $data['titre'] : null),
            'contenu'                => (isset($data['contenu']) ? $data['contenu'] : null),
            'image'                  => (isset($data['image']) ? $data['image'] : null),
            'lien'                   => (isset($data['lien']) ? $helper->sanitizeUrl($data['lien']) : null),
            'arret_id'               => (isset($data['arret_id']) ? $data['arret_id'] : 0),
            'categorie_id'           => (isset($data['categorie_id']) ? $data['categorie_id'] : 0),
            'groupe_id'              => (isset($data['groupe_id']) ? $data['groupe_id'] : null),
            'newsletter_campagne_id' => $data['campagne'],
            'rang'                   => $this->getRang($data['campagne']),
			'created_at'             => date('Y-m-d G:i:s'),
			'updated_at'             => date('Y-m-d G:i:s')
		));
		
		if(!$contents)
		{
            throw new \App\Exceptions\ContentCreationException('Creation of new content failed');
		}

        if($data['type_id'] == 7)
        {
            $helper = new Helper();
            $arrets = $helper->prepareCategories($data['arrets']);

            $model = new \App\Droit\Arret\Entities\Groupe();

            $groupe = $model->create(['categorie_id' => $data['categorie_id']]);
            $groupe->arrets()->sync($arrets);

            $contents->groupe_id = $groupe->id;
            $contents->save();
        }
		
		return $contents;
		
	}
	
	public function update(array $data){

        $contents = $this->contents->findOrFail($data['id']);
		
		if( ! $contents )
		{
            throw new \App\Exceptions\CampagneUpdateException('Update of content failed');
		}

        $contents->fill($data);

        // if we changed the image
        if(isset($data['image']))
        {
            $contents->image = $data['image'];
        }

        // if we changed the lien
        if(isset($data['lien']))
        {
            $helper = new Helper();
            $contents->lien = $helper->sanitizeUrl($data['lien']);
        }

        $contents->updated_at = date('Y-m-d G:i:s');
		$contents->save();
		
		return $contents;
	}

	public function delete($id)
    {
        $contents = $this->contents->find($id);

		return $contents->delete();
	}

					
}
