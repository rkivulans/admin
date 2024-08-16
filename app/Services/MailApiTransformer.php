<?php

namespace App\Services;

use Illuminate\Support\Collection;

class MailApiTransformer
{
    public function __construct(protected MailboxServiceInterface $mailboxService) {}

    public function getUsers(array $domains = []): Collection
    {
        $transformedUserList = $this->mailboxService->getMailUsers()
            ->filter(fn ($data) => $this->domainFilter($data->domain, $domains))
            ->flatMap(fn ($data) => $data->users);

        return $transformedUserList;
    }

    public function getAliases(array $domains = []): Collection
    {
        $transformedAlisasList = $this->mailboxService->getMailAliases()
            ->filter(fn ($data) => $this->domainFilter($data->domain, $domains))
            ->flatMap(fn ($data) => $data->aliases);

        return $transformedAlisasList;
    }

    public function getDomains(array $domains = []): Collection
    {
        return $this->mailboxService->getAllDomains()
            ->filter(fn ($domain) => $this->domainFilter($domain, $domains));
    }


    public function getMailbox(string $email, array $allowedDomains){
        return $this->getUsers($allowedDomains)
        ->whereIn('email', [$email])
        ->first();
    }

    private function domainFilter($data, $domains)
    {
        return count($domains) ? in_array($data, $domains) : $data;
    }
}
