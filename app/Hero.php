<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Hero extends Authenticatable implements JWTSubject
{
	use Notifiable;
    protected $fillable = [ 'nama', 'telepon', 'password', 'nik', 'jenis_kelamin', 'tanggal_lahir', 'kota', 'alamat', 'foto', 'jumlah_donor', 'no_pmi', 'gol_darah'];

    protected $hidden = [
    	'password', 'remember_token'
    ];

    public function event()
	    {
	    	return $this->hasMany('App\Peserta', 'id_hero');
	    }

    public function getJWTIdentifier()
	    {
	        return $this->getKey();
	    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
        {
            return [];
        }
}
