<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface MailboxServiceInterface
{
    public function getEmailUsers(): Collection;
}
