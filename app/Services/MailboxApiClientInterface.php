<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface MailboxApiClientInterface
{
    public function getMailUsers(): Collection;

    public function getMailAliases(): Collection;

    public function getAllDomains(): Collection;

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER);

    public function addOrUpdateMailAlias(string $address, string $forwardsTo, ?string $permittedSenders = null, int $updateIfExists = 0);

    public function setMailUserPassword(string $email, string $password);

    public function removeMailUser(string $email);

    public function removeMailAlias(string $address);

    public function addMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN);

    public function removeMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN);

    public function checkAccess(string $email, array $allowedDomains = []): bool;

    public function getLoginApiKey(string $email, string $password);
}
