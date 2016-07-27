<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model {

	protected $fillable = ['titre','from_name','from_email','return_email','unsuscribe','preview','site_id','list_id','color','logos','header','soutien'];

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

    public function draft()
    {
        return $this->hasMany('\designpond\newsletter\Newsletter\Entities\Newsletter_campagnes')->where('status','=','brouillon')->orderBy('updated_at','DESC');
    }

    public function pending()
    {
        return $this->hasMany('\designpond\newsletter\Newsletter\Entities\Newsletter_campagnes')
            ->where('status','=','envoyé')
            ->where('send_at', '>', \Carbon\Carbon::now())
            ->orderBy('updated_at','DESC');
    }

    public function sent()
    {
        return $this->hasMany('\designpond\newsletter\Newsletter\Entities\Newsletter_campagnes')
            ->where('status','=','envoyé')
            ->where(function ($query) {
                $query->whereDate('send_at', '<', \Carbon\Carbon::now())->orWhereNull('send_at');
            })
            ->orderBy('updated_at','DESC');
    }
    
    public function site()
    {
        if(config('newsletter.multi'))
        {
            return $this->belongsTo(config('newsletter.models.site'));
        }
    }
}