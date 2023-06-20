<?php

namespace App\Http\Controllers;

use App\Models\Lagu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->has('search_query')) {
            $search_query = $request->input('search_query');
            $results = Lagu::where('judul', 'like', '%' . $search_query . '%')->get();
        } else {
            $results = Lagu::all();
        }
            
        return view('homepage', compact('results'));
    }
}