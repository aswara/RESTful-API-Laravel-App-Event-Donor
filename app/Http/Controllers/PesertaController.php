<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Peserta;
use App\Hero;
use App\Event;
use Config;

class PesertaController extends Controller
{
	function __construct()
	{
		Config::set('jwt.user', 'App\Hero');
        Config::set('auth.providers.users.model', \App\Hero::class);

        $this->middleware('jwt.auth',['except' => [ 'show' ]]);
	}

	public function events(){
        $user = auth()->user();

        $events =  $user->event()->get();

        foreach ($events as $event) {
            $data[] = [
            	'id_hero' => $event->id_hero,
            	'data' => Event::findOrFail($event->id_event),
            	'status' => $event->status
            ];
        }

        $response = [
            'msg' => 'List event yang sudah daftar',
            'events' => $data
        ];

        return response()->json($response, 201);
    }


    public function store(Request $request)
    {
    	$this->validate($request, [
            'id_event' => 'required',
            'status' => 'required'
        ]);

    	$id_event = $request->input('id_event');
    	$status = $request->input('status');

    	$daftar = new Peserta([
    		'id_event' => $id_event,
    		'status' => $status
    	]);

    	$user = auth()->user();

       	if ($user->event()->save($daftar)) {

            $message = [
                'msg' => 'Berhasil mendaftar'
            ];
            return response()->json($message, 201);
        }

        $response = [
            'msg' => 'Gagal menambah event',
        ];

        return response()->json($response, 404);

    }
}
