<?php

namespace App\Services;

use Illuminate\Support\Collection;

class DevMailboxService implements MailboxServiceInterface
{
    public function getMailUsers(): Collection
    {
        $response = json_decode(<<<'JSON'
            [{"domain":"devmail.ke.com.lv","users":[{"email":"kristaps@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards@devmail.ke.com.lv","privileges":["admin"],"status":"active"}, {"email":"test@devmail.ke.com.lv", "mailbox": "/home/user-data/mail/mailboxes/devmail.ke.com.lv/test", "privileges":[],"status":"inactive"}]},{"domain":"laurismail.ke.com.lv","users":[{"email":"user@laurismail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"rihardsmail.ke.com.lv","users":[{"email":"user@rihardsmail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"supermail.ke.com.lv","users":[{"email":"other-user@supermail.ke.com.lv","privileges":[],"status":"active"},{"email":"user@supermail.ke.com.lv","privileges":[],"status":"active"}]}]
        JSON);
        
        return collect($response[0]->users);
    }

    public function getMailAliases(): Collection
    {

        $response = json_decode(<<<'JSON'
            [{"aliases":[{"address":"administrator@box.devmail.ke.com.lv","address_display":"administrator@box.devmail.ke.com.lv","auto":false,"forwards_to":["kristaps@devmail.ke.com.lv", "kristapsTEST@devmail.ke.com.lv", "kristapsTEST2@devmail.ke.com.lv"],"permitted_senders":null},{"address":"abuse@box.devmail.ke.com.lv","address_display":"abuse@box.devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv", "adminTEST@inbox.lv"],"permitted_senders":null},{"address":"admin@box.devmail.ke.com.lv","address_display":"admin@box.devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"hostmaster@box.devmail.ke.com.lv","address_display":"hostmaster@box.devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@box.devmail.ke.com.lv","address_display":"postmaster@box.devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"box.devmail.ke.com.lv"},{"aliases":[{"address":"info@devmail.ke.com.lv","address_display":"info@devmail.ke.com.lv","auto":false,"forwards_to":["kristaps@devmail.ke.com.lv","rihards@devmail.ke.com.lv"],"permitted_senders":null},{"address":"prakse@devmail.ke.com.lv","address_display":"prakse@devmail.ke.com.lv","auto":false,"forwards_to":["lauris@laurismail.ke.com.lv","rihards@rihardsmail.ke.com.lv"],"permitted_senders":null},{"address":"abuse@devmail.ke.com.lv","address_display":"abuse@devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"admin@devmail.ke.com.lv","address_display":"admin@devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@devmail.ke.com.lv","address_display":"postmaster@devmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"devmail.ke.com.lv"},{"aliases":[{"address":"info@extramail.ke.com.lv","address_display":"info@extramail.ke.com.lv","auto":false,"forwards_to":["kristaps@devmail.ke.com.lv"],"permitted_senders":null},{"address":"abuse@extramail.ke.com.lv","address_display":"abuse@extramail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"admin@extramail.ke.com.lv","address_display":"admin@extramail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@extramail.ke.com.lv","address_display":"postmaster@extramail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"extramail.ke.com.lv"},{"aliases":[{"address":"abuse@laurismail.ke.com.lv","address_display":"abuse@laurismail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"admin@laurismail.ke.com.lv","address_display":"admin@laurismail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@laurismail.ke.com.lv","address_display":"postmaster@laurismail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"laurismail.ke.com.lv"},{"aliases":[{"address":"abuse@rihardsmail.ke.com.lv","address_display":"abuse@rihardsmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"admin@rihardsmail.ke.com.lv","address_display":"admin@rihardsmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@rihardsmail.ke.com.lv","address_display":"postmaster@rihardsmail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"rihardsmail.ke.com.lv"},{"aliases":[{"address":"info@supermail.ke.com.lv","address_display":"info@supermail.ke.com.lv","auto":false,"forwards_to":["user@supermail.ke.com.lv"],"permitted_senders":null},{"address":"abuse@supermail.ke.com.lv","address_display":"abuse@supermail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"admin@supermail.ke.com.lv","address_display":"admin@supermail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null},{"address":"postmaster@supermail.ke.com.lv","address_display":"postmaster@supermail.ke.com.lv","auto":true,"forwards_to":["administrator@box.devmail.ke.com.lv"],"permitted_senders":null}],"domain":"supermail.ke.com.lv"}]
         JSON
        );

        return collect($response[0]->aliases);
    }

    public function getAllDomains(): Collection
    {
        $response = [
            "box.devmail.ke.com.lv",
            "rihardsmail.ke.com.lv",
            "laurismail.ke.com.lv",
            "devmail.ke.com.lv",
            "supermail.ke.com.lv",
            "extramail.ke.com.lv",
        ];

        return collect($response);
    }

    public function addMailUser(string $email, string $password, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::USER)
    {
        return true;
    }

    public function addOrUpdateMailAlias(string $address, string $forwards_to, ?string $permitted_senders = null, int $update_if_exists = 0)
    {
        return true;
    }


    public function setMailUserPassword(string $email, string $password)
    {
        return true;
    }

    public function removeMailUser(string $email)
    {
        return true;
    }


    public function removeMailAlias(string $address)
    {
        return true;
    }

    public function addMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN)
    {
        return true;
    }

    public function removeMailUserPrivilege(string $email, MailUserPrivilegeEnum $privilege = MailUserPrivilegeEnum::ADMIN)
    {
        return true;
    }
}
