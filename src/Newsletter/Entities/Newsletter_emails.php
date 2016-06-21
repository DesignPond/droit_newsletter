<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_emails extends Model {

	protected $fillable = ['email','list_id'];

    public $timestamps = false;

    public function liste()
    {
        return $this->hasMany('designpond\newsletter\Newsletter\Entities\Newsletter_lists');
    }
}