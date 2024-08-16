<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MailApiTransformer
{
    public function __construct(protected MailboxServiceInterface $mailboxService) {}

    public function getUsers(array $domains): Collection
    {
       // $usersFromMailboxApi = $this->mailboxService->getMailUsers();
        // $usersFromMailboxApi = [{"domain":"devmail.ke.com.lv","users":[{"email":"kristaps@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards@devmail.ke.com.lv","privileges":["admin"],"status":"active"}, {"email":"test@devmail.ke.com.lv", "mailbox": "/home/user-data/mail/mailboxes/devmail.ke.com.lv/test", "privileges":[],"status":"inactive"}]},{"domain":"laurismail.ke.com.lv","users":[{"email":"user@laurismail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"rihardsmail.ke.com.lv","users":[{"email":"user@rihardsmail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"supermail.ke.com.lv","users":[{"email":"other-user@supermail.ke.com.lv","privileges":[],"status":"active"},{"email":"user@supermail.ke.com.lv","privileges":[],"status":"active"}]}]

        //... here we do magic... with collection...

        // $transformedUserList = [{"email":"kristaps@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"lauris@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards-api@devmail.ke.com.lv","privileges":["admin"],"status":"active"},{"email":"rihards@devmail.ke.com.lv","privileges":["admin"],"status":"active"}, {"email":"test@devmail.ke.com.lv", "mailbox": "/home/user-data/mail/mailboxes/devmail.ke.com.lv/test", "privileges":[],"status":"inactive"}]},{"domain":"laurismail.ke.com.lv","users":[{"email":"user@laurismail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"rihardsmail.ke.com.lv","users":[{"email":"user@rihardsmail.ke.com.lv","privileges":[],"status":"active"}]},{"domain":"supermail.ke.com.lv","users":[{"email":"other-user@supermail.ke.com.lv","privileges":[],"status":"active"},{"email":"user@supermail.ke.com.lv","privileges":[],"status":"active"}]}]

      //  return $transformedUserList;

        $transformedUserList = $this->mailboxService->getMailUsers()
        ->filter(fn($data1) => in_array($data1->domain, $domains))
        ->flatMap(fn($data2) => $data2->users);
       
        return $transformedUserList;
    }

    public function getAliases(array $domains): Collection {
        $transformedAlisasList = $this->mailboxService->getMailAliases();
        ///// here comes the magic

        return $transformedAlisasList;
    }
}
