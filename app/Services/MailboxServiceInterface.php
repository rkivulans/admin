<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface MailboxServiceInterface
{
    public function getMailUsers(): Collection;

    public function getMailAliases(): Collection;

    public function getAllDomains(): Collection;

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER);

    public function addOrUpdateMailAlias(string $address, string $forwards_to, ?string $permitted_senders = null, int $update_if_exists = 0);

    public function setMailUserPassword(string $email, string $password);

    public function removeMailUser(string $email);

    public function removeMailAlias(string $address);

    public function addMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN);

    public function removeMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN);
}
