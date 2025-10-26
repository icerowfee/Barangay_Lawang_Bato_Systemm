<?php

namespace App\Providers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        Activity::saving(function (Activity $activity) {
            $guards = ['super_admin', 'admin']; // add more guards here if needed
    
            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $user = Auth::guard($guard)->user();
                    $activity->causer_type = get_class($user);
                    $activity->causer_id = $user->id;
                    break;
                }
            }
        });
    }
}
