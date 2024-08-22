<?php

namespace App\Services;

interface UserServiceInterface
{
    public function createUser(string $name, string $email, string $allowedDomains, string $password);

    public function getUserDomains(string $allowedDomains): array;
}
