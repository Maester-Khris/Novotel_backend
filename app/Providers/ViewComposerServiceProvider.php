<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $syncTable = DB::table('DBsync')->where('id',1)->first()
        // $user = Auth::user();
        // dd($user);
        // if($user){
        //     View::share('last_sync', $user->last_visit);
        // }
        // View::composer('*', function ($view) {
        //     $view->with('user', auth()->user());
        // });
        // View::share('last_sync', auth()->user()->last_visit);
        View::composer('*', function ($view) {
            $user = auth()->user();
            if ($user) {
                $view->with('last_sync', $user->last_visit);
            }
        });
    }
}
