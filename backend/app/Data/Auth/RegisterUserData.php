<?php
namespace App\Data\Auth;

use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class RegisterUserData extends Data
{
    public string $name;
    public string $email;
    public string $password;

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public static function messages(...$args): array
    {
        return [];
    }
}
