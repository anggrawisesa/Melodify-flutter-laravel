<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = auth()->user()->playlists;
        return view('homepage', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('playlist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:playlists,name',
            'cover' => 'nullable|image|max:2048',
        ]);
        
        // Simpan cover playlist ke dalam storage
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('public/playlist_covers');
            $coverPath = str_replace('public/', 'storage/', $coverPath);
        }
        
        // Simpan playlist ke database
        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->cover = $coverPath;
        $playlist->user_id = auth()->user()->id;
        $playlist->save();
        
        return redirect()->route('playlist.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_id = auth()->user()->id;
        $playlists = Playlist::where('user_id', $user_id)->get();
        
        return view('playlist.show-by-user', compact('playlists'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $playlist = Playlist::findOrFail($id);
    
        return view('playlist.edit', compact('playlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:playlists,name,' . $id,
        ]);
        
        // Simpan perubahan pada playlist ke database
        $playlist = Playlist::findOrFail($id);
        $playlist->name = $request->name;
        $playlist->save();
        
        return redirect()->route('playlist.index')->with('success', 'Playlist berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->delete();
        
        return redirect()->route('playlist.index')->with('success', 'Playlist berhasil dihapus');
    }
}