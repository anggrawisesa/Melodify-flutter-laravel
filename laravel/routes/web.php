<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaguController;
use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});
Route::get('/play', function () {
    return view('play');
});

Route::post('/lagu', [LaguController::class, 'store'])->name('lagu.store');

Route::get('/songs', [LaguController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::resource('playlist', 'App\Http\Controllers\PlaylistController');
    Route::get('playlist/user', 'App\Http\Controllers\PlaylistController@showByUser')->name('playlist.user');
    Route::get('/', [HomeController::class, 'index'])->name('homepage');
});
Auth::routes();


Route::post('/playlist/create', [PlaylistController::class, 'store'])->name('playlists.store');

Route::get('/play/{id}', function ($id) {
    $lagu = DB::table('lagu')->where('id', $id)->first();
    return view('play', ['lagu' => $lagu]);
})->name('play');

Route::get('/songs/{id}', function ($id) {
    $song = DB::table('lagu')->where('id', $id)->first();

    // Jika lagu tidak ditemukan, kembalikan response 404 Not Found
    if (!$song) {
        return response()->json(['message' => 'Song not found'], 404);
    }

    return response()->json($song);
});

Route::get('/songs/{id}/file', function ($id) {
    $song = DB::table('lagu')->find($id);
    $file = public_path('storage/lagu/'.$song->file);
    return response()->file($file);
});
Route::get('/songs/{id}/cover', function ($id) {
    $song = DB::table('lagu')->find($id);
    $cover = public_path('storage/cover/'.$song->cover);
    return response()->file($cover);
});

Route::get('/search', 'App\Http\Controllers\SearchController@search')->name('search');