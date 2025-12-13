<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class SettingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // View Composer untuk membuat variabel $globalSettings tersedia di SEMUA view
        View::composer('*', function ($view) {
            $globalSettings = Setting::first();
            $view->with('globalSettings', $globalSettings);
        });
    }
}