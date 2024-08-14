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
    // https://{host}/admin/mail/users/add

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER)
    {
        $response = $this->httpCall()
            ->asForm()    ///->dd()
            ->post('{+endpoint}/mail/users/add}', [
                'email' => $email,
                'password' => $password,
                'privileges' => $privilege->value,
            ]);

        return $response; /// need to delete this line after
    }
}
