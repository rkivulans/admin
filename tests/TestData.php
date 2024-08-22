<?php

namespace Tests;

class TestData
{
    public function apiAliasResponse()
    {
        return collect([
            (object) [
                'domain' => 'domain1.example.com',
                'aliases' => [
                    (object) ['address' => 'userAA@domain1.example.com'],
                ],
            ],
            (object) [
                'domain' => 'domain2.example.com',
                'aliases' => [
                    (object) ['address' => 'userCC@domain2.example.com'],
                ],
            ],
            (object) [
                'domain' => 'domain3.example.com',
                'aliases' => [
                    (object) ['address' => 'userCC@domain3.example.com'],
                ],
            ],
        ]);
    }

    public function apiAddMailResponse()
    {
        return collect([
            (object) [
                'domain' => 'domain1.example.com',
                'users' => [
                    (object) ['email' => 'userAA@domain1.example.com'],
                ],
            ],
            (object) [
                'domain' => 'domain2.example.com',
                'users' => [
                    (object) ['email' => 'userCC@domain2.example.com'],
                ],
            ],
            (object) [
                'domain' => 'domain3.example.com',
                'users' => [
                    (object) ['email' => 'userCC@domain3.example.com'],
                ],
            ],
        ]);
    }
}
