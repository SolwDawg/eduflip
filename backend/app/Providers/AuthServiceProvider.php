<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::createUrlUsing(function (User $user) {
            $frontendUrl = config('app.frontend_url') . '/email/verify';
            $baseUrl = config('app.url');

            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(60),
                ['user' => $user->hashid, 'hash' => sha1($user->getEmailForVerification())]
            );

            return $frontendUrl . '?verify_url=' . urlencode(Str::of($verifyUrl)->replace($baseUrl . '/api', ''));
        });
    }
}
