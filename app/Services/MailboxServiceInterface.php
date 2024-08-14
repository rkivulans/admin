<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface MailboxServiceInterface
{
    public function getEmailUsers(): Collection;

    public function getMailAliases(): Collection;

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER);
}
