<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MailService
{
    public function __construct(protected MailboxApiClientInterface $mailaApi) {}

    public function getUsers(array $domains = []): Collection
    {
        $transformedUserList = $this->mailaApi->getMailUsers()
            ->filter(fn ($data) => $this->domainFilter($data->domain, $domains))
            ->flatMap(fn ($data) => $data->users);

        return $transformedUserList;
    }

    public function getAliases(array $domains = []): Collection
    {
        $transformedAlisasList = $this->mailaApi->getMailAliases()
            ->filter(fn ($data) => $this->domainFilter($data->domain, $domains))
            ->flatMap(fn ($data) => $data->aliases);

        return $transformedAlisasList;
    }

    public function getDomains(array $domains = []): Collection
    {
        return $this->mailaApi->getAllDomains()
            ->filter(fn ($domain) => $this->domainFilter($domain, $domains));
    }

    public function getMailbox(string $email, array $allowedDomains = [])
    {

        return $this->getUsers($allowedDomains)
            ->whereIn('email', [$email])
            ->first(); ///// atgriez json vai null
    }

    public function getAlias(string $address, array $allowedDomains = [])
    {

        return
        $this->getAliases($allowedDomains)
            ->whereIn('address', [$address])
            ->first();   ///// atgriez json vai null
    }

    protected function checkAccess($email, $allowedDomains = []): bool
    {
        if (in_array('*', $allowedDomains)) { // for superadmin
            return true;
        }

        foreach ($allowedDomains as $allowedDomain) {
            if (Str::endsWith($email, "@$allowedDomain")) {
                return true;
            }
        }

        return false;
    }

    public function addUser(string $email, string $password, array $allowedDomains = [], MailUserPrivilegeEnum $role = MailUserPrivilegeEnum::USER)
    {
        abort_unless($this->checkAccess($email, $allowedDomains), 403); // Unauthorized

        return $this->mailaApi->addMailUser(
            $email, $password, $role
        );

    }

    public function setPassword(string $email, string $password, array $allowedDomains)
    {
        abort_unless($this->checkAccess($email, $allowedDomains), 403); // Unauthorized

        $this->mailaApi->setMailUserPassword(
            $email, $password
        );
    }

    public function addAlias(string $address, array $forwardsTo, array $allowedDomains = [], ?string $permittedSenders = null)
    {
        abort_unless($this->checkAccess($address, $allowedDomains), 403);

        $this->mailaApi->addOrUpdateMailAlias(
            $address,
            implode(',', $forwardsTo),
            $permittedSenders,
            updateIfExists: 0
        );
    }

    public function updateAlias(string $address, array $forwardsTo, array $allowedDomains = [], ?string $permittedSenders = null)
    {
        abort_unless($this->checkAccess($address, $allowedDomains), 403);

        $this->mailaApi->addOrUpdateMailAlias(
            $address,
            implode(',', $forwardsTo),
            $permittedSenders,
            updateIfExists: 1  ///// Unknown named parameter $updateIfExists
        );
    }

    protected function domainFilter($data, $domains)
    {
        return in_array('*', $domains) ? $data : in_array($data, $domains);
    }
}
