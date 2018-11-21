<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pmi extends Authenticatable implements JWTSubject
{
	use Notifiable;
    protected $fillable = [ 'nama_cabang', 'telepon', 'password', 'username' ];

    protected $hidden = [
    	'password', 'remember_token'
    ];

    public function event()
    {
    	return $this->hasMany('App\Event', 'id_pmi');
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
