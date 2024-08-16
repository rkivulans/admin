<?php

use App\Services\MailApiTransformer;
use App\Services\MailboxServiceInterface;
use App\Tests\MyMockery;



test('that list of mailboxes is returned', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'users' => [
                (object) ['email' => 'user1@domain1.example.com'],
                (object) ['email' => 'user2@domain1.example.com'],
            ],
        ],
    ]);

    $expectedResult = collect([
        (object) ['email' => 'user1@domain1.example.com'],
        (object) ['email' => 'user2@domain1.example.com'],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers()->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that mailboxes are filtered by domains', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'users' => [
                (object) ['email' => 'userAA@domain1.example.com'],
                (object) ['email' => 'userBB@domain1.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain2.example.com',
            'users' => [
                (object) ['email' => 'userCC@domain2.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain3.example.com',
            'users' => [
                (object) ['email' => 'userDD@domain3.example.com'],
            ],
        ],
    ]);

    $expectedResult = collect([
        (object) ['email' => 'userAA@domain1.example.com'],
        (object) ['email' => 'userBB@domain1.example.com'],
        (object) ['email' => 'userDD@domain3.example.com'],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers(['domain1.example.com', 'domain3.example.com'])->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that list of aliases are returned', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'aliases' => [
                (object) ['address' => 'userAA@domain1.example.com'],
                (object) ['address' => 'userBB@domain1.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain2.example.com',
            'aliases' => [
                (object) ['address' => 'userCC@domain2.example.com'],
            ],
        ],
    ]);

    $expectedResult = collect([
        (object) ['address' => 'userAA@domain1.example.com'],
        (object) ['address' => 'userBB@domain1.example.com'],
        (object) ['address' => 'userCC@domain2.example.com'],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getAliases()->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that list of aliases are filtered by domains', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'aliases' => [
                (object) ['address' => 'userAA@domain1.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain2.example.com',
            'aliases' => [
                (object) ['address' => 'userCC@domain2.example.com'],
                (object) ['address' => 'userBB@domain2.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain3.example.com',
            'aliases' => [
                (object) ['address' => 'userDD@domain3.example.com'],
            ],
        ],
    ]);

    $expectedResult = collect([
        (object) ['address' => 'userCC@domain2.example.com'],
        (object) ['address' => 'userBB@domain2.example.com'],
        (object) ['address' => 'userDD@domain3.example.com'],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getAliases(['domain2.example.com', 'domain3.example.com'])->toArray())
        ->toEqual($expectedResult->toArray());
});

test('return all domains', function () {

    /// expected same result
    $apiResponse = collect([
        'box.devmail.ke.com.lv',
        'rihardsmail.ke.com.lv',
        'laurismail.ke.com.lv',
        'devmail.ke.com.lv',
    ]);
 

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getAllDomains')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getDomains()->toArray())
        ->toEqual($apiResponse->toArray());
});

test('return filtered domains', function () {
    $apiResponse = collect([
        'box.devmail.ke.com.lv',
        'rihardsmail.ke.com.lv',
        'laurismail.ke.com.lv',
        'devmail.ke.com.lv',
    ]);

    //// Seit tiem array key jaatbilst savadak test fail
    //// labu laiku seit nosedeju...
    $expectedResult = collect([
       2 => 'laurismail.ke.com.lv', 
       3 => 'devmail.ke.com.lv',
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getAllDomains')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getDomains(['laurismail.ke.com.lv', 'devmail.ke.com.lv'])->toArray())
        ->toEqual($expectedResult->toArray());
});





/*
 //////// Sis tests jau laikam nederes jo nav jau tads api calls uz vienu useri...
 Jo ka tad es varu vispar parbaudit, vai ari es kko nepareizi sapratu.

test('if return user is not null', function () {
    $apiResponse =  collect([
        (object) [
            'domain' => 'domain1.example.com',
            'users' => [
                (object) ['email' => 'userAA@domain1.example.com'],
                (object) ['email' => 'userBB@domain1.example.com'],
            ],
        ],
        (object) [
            'domain' => 'domain2.example.com',
            'users' => [
                (object) ['email' => 'userCC@domain2.example.com'],
            ],
        ],
    ]);


    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailbox')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getMailbox([])->toArray())
        ->toEqual($expectedResult->toArray());
});
*/
