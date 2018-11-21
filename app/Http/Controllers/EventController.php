<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $response = [
            'msg' => 'List event',
            'events' => $events
        ];

        return response()->json($response, 201);
    }
}
