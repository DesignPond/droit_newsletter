<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_lists extends Model {

	protected $fillable = ['title'];

    public function emails()
    {
        return $this->hasMany('designpond\newsletter\Newsletter\Entities\Newsletter_emails', 'list_id', 'id');
    }
}