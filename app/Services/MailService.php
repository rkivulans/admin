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
        $this->getUsers($allowedDomains)
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
        foreach ($allowedDomains as $allowedDomain) {
            return Str::endsWith($email, "@$allowedDomain");
        }

        return false;
    }

    public function addUser(string $email, string $password, MailUserPrivilegeEnum $role, array $allowedDomains = [])
    {
        if (count($allowedDomains)){ /// for superadmin
            abort_unless($this->checkAccess($email, $allowedDomains), 403); // Unauthorized
        }
        

        $this->mailaApi->addMailUser(
            $email, $password, $role
        );
    }

    public function setPassword(string $email, string $password, array $allowedDomains){
        if (count($allowedDomains)){  //// for super admin
            abort_unless($this->checkAccess($email, $allowedDomains), 403); // Unauthorized
        }

        $this->mailaApi->setMailUserPassword(
            $email, $password
        );
    }
           ////// Uztaisiju 2 atseviskas funkcijas add un update lai labak var saprast
    public function addAlias(string $address, string $forwardsTo, array $allowedDomains = [], ?string $permittedSenders = null){
        if (count($allowedDomains)){
            abort_unless($this->checkAccess($address, $allowedDomains), 403);
        }
        
        $this->mailaApi->addOrUpdateMailAlias(
            $address, $forwardsTo, $permittedSenders  /// update = 0
        );
    }


    public function updateAlias(string $address, string $forwardsTo, array $allowedDomains = [], ?string $permittedSenders = null){
        if (count($allowedDomains)){
            abort_unless($this->checkAccess($address, $allowedDomains), 403);
        }

        $this->mailaApi->addOrUpdateMailAlias(
            $address, $forwardsTo, $permittedSenders, 1  /// update = 1
        );
    }

     //// nezinu vai sadu vajadzeja, bet savadak uz edit padod statiskus datus prieks formas
    public function getAliasForwardsTo(string $address, array $allowedDomains = []){
        abort_unless($this->checkAccess($address, $allowedDomains), 403);

        return $this->getAlias($address, $allowedDomains)->forwards_to;
    }

    private function domainFilter($data, $domains)
    {
        return count($domains) ? in_array($data, $domains) : $data;
    }
}
