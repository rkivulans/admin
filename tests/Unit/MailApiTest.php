<?php
use App\Services\MailboxServiceInterface;
use App\Services\MailApiTransformer;

test('that list of mailboxes is returned', function () {
    $apiResponse = collect([
        [
            "domain" => "domain1.example.com",
            "users" => [
                ["email"=>"user1@domain1.example.com"],
                ["email"=>"user2@domain1.example.com"],
            ]
        ]
    ]);

    $expectedResult = collect([
        ["email"=>"user1@domain1.example.com"],
        ["email"=>"user2@domain1.example.com"],
    ]);

    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers()->toArray())
        ->toEqual($expectedResult->toArray());
});

test('that mailboxes are filtered by domains', function () {
    $apiResponse = collect([
        [
            "domain" => "domain1.example.com",
            "users" => [
                ["email"=>"userAA@domain1.example.com"],
                ["email"=>"userBB@domain1.example.com"],
            ]
        ],
        [
            "domain" => "domain2.example.com",
            "users" => [
                ["email"=>"userCC@domain1.example.com"],
            ]
        ],
        [
            "domain" => "domain3.example.com",
            "users" => [
                ["email"=>"userDD@domain1.example.com"],
            ]
        ],
    ]);

    $expectedResult = collect([
        ["email"=>"userAA@domain1.example.com"],
        ["email"=>"userBB@domain1.example.com"],
        ["email"=>"userDD@domain3.example.com"],
    ]);


    $mailboxService = Mockery::mock(MailboxServiceInterface::class);
    $mailboxService->shouldReceive('getMailUsers')->andReturn($apiResponse);
    $api = new MailApiTransformer($mailboxService);

    expect($api->getUsers(['domain1.example.com', 'domain3.example.com'])->toArray())
        ->toEqual($expectedResult->toArray());
});
