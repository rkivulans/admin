<?php

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use App\Services\MailUserPrivilegeEnum;
use Tests\TestData;

$data = new TestData;

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

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getUsers()->toArray())
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

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getUsers(['domain1.example.com', 'domain3.example.com'])->toArray())
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

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getAliases()->toArray())
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

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getAliases(['domain2.example.com', 'domain3.example.com'])->toArray())
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

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getAllDomains')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getDomains()->toArray())
        ->toEqual($apiResponse->toArray());
});

test('return filtered domains', function () {
    $apiResponse = collect([
        'box.devmail.ke.com.lv',
        'rihardsmail.ke.com.lv',
        'laurismail.ke.com.lv',
        'devmail.ke.com.lv',
    ]);

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getAllDomains')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getDomains(['laurismail.ke.com.lv', 'devmail.ke.com.lv'])->toArray())
        ->toContain('laurismail.ke.com.lv')
        ->toContain('devmail.ke.com.lv')
        ->toHaveCount(2);
});

test('if user is returned by domain', function () {
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
                (object) ['email' => 'userCC@domain3.example.com'],
            ],
        ],
    ]);

    $expectedResult = json_decode(<<<'JSON'
    {"email":"userCC@domain3.example.com"}
    JSON
    );

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getMailbox('userCC@domain3.example.com', ['domain3.example.com']))
        ->toEqual($expectedResult);
});

test('test if returned user belongs to domains', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'users' => [
                (object) ['email' => 'userAA@domain1.example.com'],
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
                (object) ['email' => 'userCC@domain3.example.com'],
            ],
        ],
    ]);

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getMailbox('userAA@domain1.example.com', ['domain2.example.com', 'domain3.example.com']))
        ->toEqual(null);
});

test('test if user is returned (superadmin)', function () {
    $apiResponse = collect([
        (object) [
            'domain' => 'domain1.example.com',
            'users' => [
                (object) ['email' => 'userAA@domain1.example.com'],
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
                (object) ['email' => 'userCC@domain3.example.com'],
            ],
        ],
    ]);

    $expectedResult = json_decode(<<<'JSON'
        {"email":"userAA@domain1.example.com"}
        JSON
    );

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $mailService = new MailService($mailboxService);

    expect($mailService->getMailbox('userAA@domain1.example.com'))
        ->toEqual($expectedResult);
});

test('if alias is returned by domain', function () use ($data) {
    $expectedResult = json_decode(<<<'JSON'
    {"address":"userCC@domain3.example.com"}
    JSON
    );

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($data->apiAliasResponse());
    $mailService = new MailService($mailboxService);

    expect($mailService->getAlias('userCC@domain3.example.com', ['domain3.example.com']))
        ->toEqual($expectedResult);
});

test('test if returned alias belongs to domains', function () use ($data) {

    $expectedResult = json_decode(<<<'JSON'
    {"address":"userCC@domain3.example.com"}
    JSON
    );

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($data->apiAliasResponse());
    $mailService = new MailService($mailboxService);

    expect($mailService->getAlias('userCC@domain3.example.com', ['domain2.example.com']))
        ->toEqual(null);
});

test('test if alias is returned (superadmin)', function () use ($data) {
    $expectedResult = json_decode(<<<'JSON'
    {"address":"userCC@domain3.example.com"}
    JSON
    );

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($data->apiAliasResponse());
    $mailService = new MailService($mailboxService);

    expect($mailService->getAlias('userCC@domain3.example.com'))
        ->toEqual($expectedResult);
});


test('add new email if respecting domain', function () {
    

    $mailboxService = Mockery::mock(MailboxApiClientInterface::class);
    $mailboxService->shouldReceive('addMailUser')->andReturn(true);
    $mailService = new MailService($mailboxService);
    
    
    expect($mailService->addUser('testuser@domain2.example.com', '12345678', MailUserPrivilegeEnum::USER, ['domain2.example.com']))
    ->toEqual(true);
    
});




