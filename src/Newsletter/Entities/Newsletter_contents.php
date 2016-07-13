<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_contents extends Model {

	protected $fillable = ['type_id','titre','contenu','image','lien','arret_id','categorie_id','newsletter_campagne_id','rang','groupe_id'];

    public $timestamps = false;

    public function getContentTitleAttribute()
    {
        if($this->titre){
            return $this->titre;
        }
        elseif(isset($this->arret)){
            return $this->arret->reference;
        }
        elseif(isset($this->groupe)){
            return $this->groupe->categorie->title;
        }
    }

    public function getLinkOrUrlAttribute()
    {
        $file = config('newsletter.path.upload').$this->lien;

        if(\File::exists($file)){
            return config('newsletter.path.upload').$this->lien;
        }

        return $this->lien;
    }

    public function campagne(){

        return $this->belongsTo('designpond\newsletter\Newsletter\Entities\Newsletter_campagnes');
    }

    public function newsletter(){

        return $this->belongsTo('designpond\newsletter\Newsletter\Entities\Newsletter');
    }

    public function type(){

        return $this->belongsTo('designpond\newsletter\Newsletter\Entities\Newsletter_types');
    }

    // Has to be defined in configuration 
    public function arret()
    {
        if(in_array(5,array_keys(config('newsletter.components'))))
        {
            return $this->hasOne(config('newsletter.models.arret'), 'id', 'arret_id');
        }
    }

    public function groupe()
    {
        if(in_array(7,array_keys(config('newsletter.components'))))
        {
            return $this->hasOne(config('newsletter.models.groupe'), 'id', 'groupe_id');
        }
    }

}
