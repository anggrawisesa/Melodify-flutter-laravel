<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Playlist;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('homepage', function ($view) {
            $userPlaylists = Playlist::where('user_id', auth()->user()->id)->get();
            $view->with('userPlaylists', $userPlaylists);
        });
    }
}