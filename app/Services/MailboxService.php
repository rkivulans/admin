<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class MailboxService implements MailboxServiceInterface
{
    protected $user;

    protected $password;

    protected $server;

    public function __construct()
    {
        $this->user = config('services.mailbox.user');
        $this->password = config('services.mailbox.password');
        $this->server = config('services.mailbox.server');
    }

    public function getEmailUsers(): Collection
    {
        $response = Http::withoutVerifying()
            ->withBasicAuth($this->user, $this->password)
            ->get("{$this->server}/mail/users?format=json")
            ->object();

        return collect($response[0]->users);
    }

    public function getMailAliases(): Collection
    {
        $response = Http::withoutVerifying()
            ->withBasicAuth($this->user, $this->password)
            ->get("{$this->server}/mail/aliases?format=json")
            ->object();

        return collect($response[0]->aliases);
    }
}
