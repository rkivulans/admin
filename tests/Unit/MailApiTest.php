<?php
use App\Services\MailboxServiceInterface;
use App\Services\MailApiTransformer;

test('that list of mailboxes is returned', function () {
    $apiResponse = collect([
        (object)[
            "domain" => "domain1.example.com",
            "users" => [
                (object)["email"=>"user1@domain1.example.com"],
                (object)["email"=>"user2@domain1.example.com"],
            ]
        ]
    ]);

    $expectedResult = collect([
        (object)["email"=>"user1@domain1.example.com"],
        (object)["email"=>"user2@domain1.example.com"],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers()->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that mailboxes are filtered by domains', function () {
    $apiResponse = collect([
        (object)[
            "domain" => "domain1.example.com",
            "users" => [
                (object)["email"=>"userAA@domain1.example.com"],
                (object)["email"=>"userBB@domain1.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain2.example.com",
            "users" => [
                (object)["email"=>"userCC@domain2.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain3.example.com",
            "users" => [
                (object)["email"=>"userDD@domain3.example.com"],
            ]
        ],
    ]);

    $expectedResult = collect([
        (object)["email"=>"userAA@domain1.example.com"],
        (object)["email"=>"userBB@domain1.example.com"],
        (object)["email"=>"userDD@domain3.example.com"],
    ]);


    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers(['domain1.example.com', 'domain3.example.com'])->toArray())
        ->toEqual($expectedResult->toArray());
});


test('that list of aliases are returned', function () {
    $apiResponse = collect([
        (object)[
            "domain" => "domain1.example.com",
            "aliases" => [
                (object)["address"=>"userAA@domain1.example.com"],
                (object)["address"=>"userBB@domain1.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain2.example.com",
            "aliases" => [
                (object)["address"=>"userCC@domain2.example.com"],
                (object)["address"=>"userBB@domain2.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain3.example.com",
            "aliases" => [
                (object)["address"=>"userDD@domain3.example.com"],
            ]
        ],
    ]);

    $expectedResult = collect([
        (object)["address"=>"userAA@domain1.example.com"],
        (object)["address"=>"userBB@domain1.example.com"],
        (object)["address"=>"userCC@domain2.example.com"],
        (object)["address"=>"userBB@domain2.example.com"],
        (object)["address"=>"userDD@domain3.example.com"],
    ]);


    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getAliases()->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that list of aliases are filtered by domains', function () {
    $apiResponse = collect([
        (object)[
            "domain" => "domain1.example.com",
            "aliases" => [
                (object)["address"=>"userAA@domain1.example.com"],
                (object)["address"=>"userBB@domain1.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain2.example.com",
            "aliases" => [
                (object)["address"=>"userCC@domain2.example.com"],
                (object)["address"=>"userBB@domain2.example.com"],
            ]
        ],
        (object)[
            "domain" => "domain3.example.com",
            "aliases" => [
                (object)["address"=>"userDD@domain3.example.com"],
            ]
        ],
    ]);

    $expectedResult = collect([
        (object)["address"=>"userCC@domain2.example.com"],
        (object)["address"=>"userBB@domain2.example.com"],
    ]);


    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailAliases')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getAliases(['domain2.example.com'])->toArray())
        ->toEqual($expectedResult->toArray());
});