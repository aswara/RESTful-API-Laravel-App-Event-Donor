<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Event;
use App\Pmi;
use Config;

class PmiEventController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', 'App\Pmi');
        Config::set('auth.providers.users.model', \App\Pmi::class);

        $this->middleware('jwt.auth',['except' => [ 'show',]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $events = $user->event()->get();
        
        foreach ($events as $event) {
            $data[] = [
                'nama_cabang' => $user->nama_cabang,
                'penanggung_jawab' => $event->penanggung_jawab,
                'tempat' => $event->tempat,
                'kota' => $event->kota,
                'tanggal' => $event->tanggal,
                'deskripsi' => $event->deskripsi,
                'lihat_event' => [
                    'href' => 'api/pmi/event/' . $event->id,
                    'method' => 'GET',
                ]
            ];
        }

        $response = [
            'msg' => 'List event',
            'events' => $data
        ];

        return response()->json($response, 201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'penanggung_jawab' => 'required',
            'deskripsi' => 'required',
            'tempat' => 'required'
        ]);


        $judul = $request->input('judul');
        $tanggal = $request->input('tanggal');
        $penanggung_jawab = $request->input('penanggung_jawab');
        $deskripsi = $request->input('deskripsi');
        $tempat = $request->input('tempat');
        $kota = $request->input('kota');

        $event = new Event([
            'judul' => $judul,
            'tanggal' => $tanggal,
            'penanggung_jawab' => $penanggung_jawab,
            'deskripsi' => $deskripsi,
            'tempat' => $tempat,
            'kota' => $tempat
        ]);

        $user = auth()->user();

        if ($user->event()->save($event)) {
            $event->lihat_event = [
                'href' => 'api/pmi/event/' . $event->id,
                'method' => 'GET'
            ];
            $message = [
                'msg' => 'Event berhasil di tambah',
                'event' => $event
            ];
            return response()->json($message, 201);
        }

        $response = [
            'msg' => 'Gagal menambah event',
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return  response()->json($event, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'tanggal' => 'required',
            'penanggung_jawab' => 'required',
            'deskripsi' => 'required',
            'tempat' => 'required',
        ]);

        $judul = $request->input('judul');
        $tanggal = $request->input('tanggal');
        $penanggung_jawab = $request->input('penanggung_jawab');
        $deskripsi = $request->input('deskripsi');
        $tempat = $request->input('tempat');
        $kota = $request->input('kota');    

        $event = [
            'judul' => $judul,
            'tanggal' => $tanggal,
            'penanggung_jawab' => $penanggung_jawab,
            'deskripsi' => $deskripsi,
            'tempat' => $tempat,
            'kota' => $kota
        ];

        $user = auth()->user();

        if ($user->event()->where('id', $id)->update($event)) {
            $message = [
                'msg' => 'Event berhasil di di ubah',
                'event' => $event,
                'lihat_event' => [
                    'href' => 'api/pmi/event/' . $id,
                    'method' => 'GET',
                ]
            ];

            return response()->json($message, 201);
        }


        $message = [
        'msg' => 'Event gagal di di ubah',
        'event' => ''
        ];
        return response()->json($message, 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        if($user->event()->where('id',$id)->delete()) {
            return response()->json(['msg'=>'berhasil hapus'], 201);
        }

        return response()->json('data event tidak ada', 404);
    }
}
