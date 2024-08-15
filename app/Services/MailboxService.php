<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class MailboxService implements MailboxServiceInterface
{
    protected $user;

    protected $password;

    protected $server;

    public function __construct()
    {
        $this->user = config('services.mailbox.user');
        $this->password = config('services.mailbox.password');
        $this->server = config('services.mailbox.server');
    }

    protected function httpCall(): PendingRequest
    {
        return Http::withBasicAuth($this->user, $this->password)
            ->withUrlParameters([
                'endpoint' => $this->server,
            ]);
    }

    public function getEmailUsers(): Collection
    {
        $response = $this->httpCall()
            ->get('{+endpoint}/mail/users?format=json');

        return collect($response->object()[0]->users);
    }

    public function getMailAliases(): Collection
    {
        $response = $this->httpCall()
            ->get('{+endpoint}/mail/aliases?format=json');

        return collect($response->object()[0]->aliases);
    }

    public function getAllDomains(): Collection
    {
        
        $response = $this->httpCall()
            ->get('{+endpoint}/mail/domains');
            
        
        //dd($response[0]->collect());
        
        return $response->collect();
        
    }

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER)
    {
        $response = $this->httpCall()
            ->asForm()    ///->dd()
            ->post('{+endpoint}/mail/users/add', [
                'email' => $email,
                'password' => $password,
                'privileges' => $privilege->value,
            ]);

        return $response; /// need to delete this line after
    }


      /// on update update_if_exists = 1, by default = 0
      /// on update permitted_users = string (with emails), by default null
    public function addOrUpdateMailAlias(string $address, string $forwards_to, ?string $permitted_senders = null, int $update_if_exists = 0)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/aliases/add', [
                'update_if_exists' => $update_if_exists,
                'address' => $address,
                'forwards_to' => $forwards_to,
                'permitted_senders' => $permitted_senders,
            ]);

        return $response; /// delete
    }

    public function setMailUserPassword(string $email, string $password)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/users/password', [
                'email' => $email,
                'password' => $password,
            ]);

        return $response; // delete
    }


    public function removeMailUser(string $email)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/users/remove', [
                'email' => $email,
            ]);

        return $response; // delete
    }

    public function removeMailAlias(string $address)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/aliases/remove', [
                'address' => $address,
            ]);

        return $response; // delete
    }
    
    // by default add privilege = admin;
    public function addMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/users/privileges/add', [
                'email' => $email,
                'privilege' => $privilege->value
            ]);

        return $response; // delete
    }

    // by default remove privilege = admin;
    public function removeMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN)
    {
        $response = $this->httpCall()
            ->asForm()    
            ->post('{+endpoint}/mail/users/privileges/remove', [
                'email' => $email,
                'privilege' => $privilege->value
            ]);

        return $response; // delete
    }
}
