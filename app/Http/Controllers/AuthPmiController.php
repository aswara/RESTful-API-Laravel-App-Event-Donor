<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTException;
use Config;

use App\Pmi;

class AuthPmiController extends Controller
{
	public function __construct()
	{
        Config::set('jwt.user', 'App\Pmi');
        Config::set('auth.providers.users.model', \App\Pmi::class);
	}

    public function index(){
        $user = auth()->user()->get();
        
        return response()->json($user, 201);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_cabang' => 'required',
            'username' => 'required',
    		'telepon' => 'required',
    		'password' => 'required|min:5'
    	]);

        $username = $request->input('username');
    	$nama_cabang = $request->input('nama_cabang');
    	$telepon = $request->input('telepon');
    	$password = $request->input('password');

    	$user = new Pmi([
            'username' => $username,
    		'nama_cabang' => $nama_cabang,
    		'telepon' => $telepon,
    		'password' => bcrypt($password)
    	]);

    	$credentials = [
    		'username' => $username,
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
    			'params' => 'nama_cabang, password'
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
    		'username' => 'required',
    		'password' => 'required|min:5'
    	]);

    	$username = $request->input('username');
    	$password = $request->input('password');

    	if($pmi = Pmi::where('username', $username)->first()) {
    		$credentials = [
    			'username' => $username,
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
    		'user' => $pmi,
    		'token' => $token
    	];

        return response()->json($response, 201);
    }
}
