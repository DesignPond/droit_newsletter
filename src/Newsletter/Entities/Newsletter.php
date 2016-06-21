<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model {

	protected $fillable = ['titre','from_name','from_email','return_email','unsuscribe','preview','list_id','color','logos','header','soutien'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getBanniereLogosAttribute()
    {
        $logos = public_path('newsletter/'.$this->logos);

        return \File::exists($logos) ? 'newsletter/'.$this->logos : null;
    }

    public function getBanniereHeaderAttribute()
    {
        $header = public_path('newsletter/'.$this->header);

        return \File::exists($header) ? 'newsletter/'.$this->header : null;
    }

    public function getLogoSoutienAttribute()
    {
        $soutien = public_path('newsletter/'.$this->soutien);

        return $this->soutien && \File::exists($soutien) ? 'newsletter/'.$this->soutien : null;
    }

    public function campagnes()
    {
        return $this->hasMany('\designpond\newsletter\Newsletter\Entities\Newsletter_campagnes')->orderBy('updated_at','DESC');
    }

    public function sent()
    {
        return $this->hasMany('\designpond\newsletter\Newsletter\Entities\Newsletter_campagnes')->where('status','=','envoyé')->orderBy('updated_at','DESC');
    }
}