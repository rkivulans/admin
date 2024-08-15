<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface MailboxServiceInterface
{
    public function getEmailUsers(): Collection;

    public function getMailAliases(): Collection;

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER);

    public function addOrUpdateMailAlias(string $address, string $forwards_to, ?string $permitted_senders = null, int $update_if_exists = 0);

    public function setMailUserPassword(string $email, string $password);
}
