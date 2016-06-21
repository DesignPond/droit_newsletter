<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_subscriptions extends Model {

    public $timestamps = false;

	protected $fillable = ['user_id','newsletter_id'];

    public function newsletter()
    {
        return $this->hasOne('designpond\newsletter\Newsletter\Entities\Newsletter');
    }

}