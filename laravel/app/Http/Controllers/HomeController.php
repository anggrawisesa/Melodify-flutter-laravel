<?php

namespace App\Http\Controllers;

use App\Models\Lagu;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $playlists = Playlist::where('user_id', auth()->user()->id)->get();
        return view('homepage', compact('playlists'));
    }

}