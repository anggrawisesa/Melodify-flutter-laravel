<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lagu;
use Illuminate\Support\Facades\DB;

class LaguController extends Controller
{
    public function index()
    {
        $songs = Lagu::all();
        return response()->json($songs);
    }


    public function create()
    {
        return view('lagu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penyanyi' => 'required',
            'file' => 'required|mimes:mp3',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/lagu', $fileName);
        $path = str_replace('public/lagu', '', $path);
        

        $cover = $request->file('cover');
        if ($cover) {
            $coverName = time() . '_' . $cover->getClientOriginalName();
            $pathCover = $cover->storeAs('public/cover', $coverName);
            $pathCover = str_replace('public/cover', '', $pathCover);
        }

        $lagu = Lagu::create([
            'judul' => $request->judul,
            'penyanyi' => $request->penyanyi,
            'album' => $request->album,
            'cover' => isset($pathCover) ? $pathCover : null,
            'file' => $path,
        ]);

        return redirect('/');
    }

    public function destroy(Lagu $lagu)
    {
        $lagu->delete();

        return redirect()->route('lagu.index')->with('success', 'Lagu berhasil dihapus');
    }
}