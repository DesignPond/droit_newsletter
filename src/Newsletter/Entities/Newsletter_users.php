<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_users extends Model {

    protected $dates    = ['activated_at'];
	protected $fillable = ['email','activation_token','activated_at'];

    public function subscriptions()
    {
        return $this->belongsToMany('designpond\newsletter\Newsletter\Entities\Newsletter', 'newsletter_subscriptions', 'user_id', 'newsletter_id');
    }

}