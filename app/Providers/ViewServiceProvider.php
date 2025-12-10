<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share notification data with navbar component
        View::composer('components.navbar', function ($view) {
            if (auth()->check() && auth()->user()->isIntern()) {
                $notifications = auth()->user()->notifications()->take(5)->get();
                $unreadCount = auth()->user()->unreadNotifications()->count();
                
                $view->with([
                    'notifications' => $notifications,
                    'unreadCount' => $unreadCount
                ]);
            } else {
                $view->with([
                    'notifications' => collect(),
                    'unreadCount' => 0
                ]);
            }
        });
    }
}