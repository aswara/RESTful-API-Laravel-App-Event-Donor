<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'judul', 'tanggal', 'tempat', 'kota', 'penanggung_jawab', 'deskripsi', 'id_pmi',
    ];

    public function pmi()
    {
    	return $this->belongsTo('App\Pmi', 'id');
    }
}
