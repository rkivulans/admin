<?php

namespace App\Services;

use ErrorException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailApiTransformer
{
    public function __construct(public MailboxServiceInterface $mailboxService) {}

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

    public function getMailbox(string $email, array $allowedDomains = []){

        return 
        $this->getUsers(!count($allowedDomains) ? [] : $allowedDomains) 
        ->whereIn('email', [$email])
        ->first(); ///// atgriez json vai null
    }

   
    public function getAlias(string $address, array $allowedDomains = []){

        return  
        $this->getAliases(!count($allowedDomains) ? [] : $allowedDomains)
        ->whereIn('address', [$address])
        ->first();   ///// atgriez json vai null
    }


    public function addUser(array $validated, array $allowedDomains = []){

        // ar so variantu neparbauda vai allowed domain ir domains (pareizs)
        //$allowed = Str::endsWith($validated['email'], $allowedDomains);

        /// Seit ir vairaki veidi ka parbaudit, nezinu ka tev labak patik
        /// var ari ar parasto ciklu.
        $allowed = Arr::first($allowedDomains, function($data) use ($validated){
             return Str::endsWith($validated['email'], "@$data");
        });

        if($allowed){
            $this->mailboxService->addMailUser(
                $validated['email'],
                $validated['password'],
                MailUserPrivilegeEnum::{Str::upper($validated['role'])},
            );
        } else {
            throw new ErrorException("Email is not in allowed emails list!");
        }

       
    }

    private function domainFilter($data, $domains)
    {
        return count($domains) ? in_array($data, $domains) : $data;
    }
}
