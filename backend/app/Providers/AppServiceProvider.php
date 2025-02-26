<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Resources\Json\JsonResource;

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
        require app_path('Support/helpers.php');
        JsonResource::withoutWrapping();
        Password::defaults(
            fn() => Password::min(8)
                ->mixedCase()
                ->uncompromised()
        );
    }
}
