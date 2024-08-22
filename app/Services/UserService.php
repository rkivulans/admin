<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function createUser(string $name, string $email, string $allowedDomains, string $password)
    {

        User::create([
            'name' => $name,
            'email' => $email,
            'domains' => $allowedDomains,
            'password' => Hash::make($password),
        ]);
    }

    public function getUserDomains(string $allowedDomains): array
    {
        return Arr::map(explode(',', $allowedDomains), fn ($domain) => trim($domain));
    }
}
