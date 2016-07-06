<?php namespace designpond\newsletter\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_clipboards extends Model {

	protected $fillable = ['content_id'];

    public $timestamps = false;

    public function content()
    {
        return $this->belongsTo('designpond\newsletter\Newsletter\Entities\Newsletter_contents');
    }
}