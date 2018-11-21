<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTException;
use Config;

use App\Hero;

class AuthHeroController extends Controller
{
	public function __construct()
	{
	    Config::set('jwt.user', 'App\Hero');
        Config::set('auth.providers.users.model', \App\Hero::class);
	}

    public function store(Request $request)
    {

    	$this->validate($request, [
    		'nama' => 'required',
    		'nik' => 'required',
            'telepon' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'foto' => 'required',
            'telepon' => 'required',
    		'password' => 'required|min:5'
    	]);

    	$nama = $request->input('nama');
        $nik = $request->input('nik');
        $telepon = $request->input('telepon');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $tanggal_lahir = $request->input('tanggal_lahir');
    	$alamat = $request->input('alamat');
        $kota = $request->input('kota');
        $foto = $request->input('foto');
        $no_pmi = $request->input('no_pmi');
        $gol_darah = $request->input('gol_darah');
    	$password = $request->input('password');

    	$user = new Hero([
    		'nama' => $nama,
            'nik' => $nik,
    		'telepon' => $telepon,
            'jenis_kelamin' => $jenis_kelamin,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'kota' => $kota,
            'foto' => $foto,
            'no_pmi' => $no_pmi,
            'gol_darah' => $gol_darah,
    		'password' => bcrypt($password)
    	]);

    	$credentials = [
    		'nik' => $nik,
    		'password' => $password
    	];

    	if($user->save()) {
    		$token = null;
    		try {

    			if(!$token = JWTAuth::attempt($credentials)) {
    				return response()->json([
    					'msg' => 'Email or Password are incorrect' 
    				], 404);
    			}
    		} catch (JWTException $e) {
    			return response()->json([
    				'msg' => 'Failed to create token'
    			], 404);
    		}

    		$user->signin = [
    			'href' => 'api/pmi/masuk',
    			'method' => 'POST',
    			'params' => 'nama, password'
    		];

    		$response = [
    			'msg' => 'Akun berhasil di buat',
    			'user' => $user,
    			'token' => $token
    		];

    		return response()->json($response, 201);
    	}
    }

    public function signin(Request $request)
    {
    	$this->validate($request, [
    		'nik' => 'required',
    		'password' => 'required|min:5'
    	]);

    	$nik = $request->input('nik');
    	$password = $request->input('password');

    	if($user = Hero::where('nik', $nik)->first()) {
    		$credentials = [
    			'nik' => $nik,
    			'password' => $password
    		];

    		$token = null;
    		try {
    			if(!$token = JWTAuth::attempt($credentials)) {
    				return response()->json([
    					'msg' => 'Email or Password are incorrect' 
    				], 404);
    			}
    		} catch (JWTException $e) {
    			return response()->json([
    				'msg' => 'Failed to create token'
    			], 404);
    		}
    	}

    	$response = [
    		'msg' => 'Pmi masuk',
    		'user' => $user,
    		'token' => $token
    	];

        return response()->json($response, 201);
    }

}
