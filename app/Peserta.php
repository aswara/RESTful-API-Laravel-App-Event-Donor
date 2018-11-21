<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [ 'id_hero', 'id_event', 'status' ];

    public function pmi()
    {
    	return $this->belongsTo('App\Pmi', 'id');
    }

    public function hero()
    {
    	return $this->belongsTo('App\Hero', 'id');
    }

   	public function events()
    {
    	return $this->belongsTo('App\Event', 'id');
    }
}
