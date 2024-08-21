<?php

namespace App\Services;

use ErrorException;
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

        return
        $this->getUsers(! count($allowedDomains) ? [] : $allowedDomains)
            ->whereIn('email', [$email])
            ->first(); ///// atgriez json vai null
    }

    public function getAlias(string $address, array $allowedDomains = [])
    {

        return
        $this->getAliases(! count($allowedDomains) ? [] : $allowedDomains)
            ->whereIn('address', [$address])
            ->first();   ///// atgriez json vai null
    }

    protected function checkAccess($email, $allowedDomains = []): bool
    {
        foreach ($allowedDomains as $allowedDomain) {
            return Str::endsWith($email, "@$allowedDomain");
        }

        return false;
    }

    public function addUser(string $email, string $password, MailUserPrivilegeEnum $role, array $allowedDomains = [])
    {

        // ar so variantu neparbauda vai allowed domain ir domains (pareizs)
        //$allowed = Str::endsWith($validated['email'], $allowedDomains);

        /// Seit ir vairaki veidi ka parbaudit, nezinu ka tev labak patik
        /// var ari ar parasto ciklu.
        abort_unless($this->checkAccess($email, $allowedDomains), 403); // Unauthorized

        $this->mailaApi->addMailUser(
            $email, $password, $role
        );
    }

    private function domainFilter($data, $domains)
    {
        return count($domains) ? in_array($data, $domains) : $data;
    }
}
