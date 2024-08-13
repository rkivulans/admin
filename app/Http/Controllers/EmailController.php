<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmailController extends Controller
{
    public function index()
    {
        $user = config('services.mailbox.user');
        $pw = config('services.mailbox.password');
        $server = config('services.mailbox.server');

        $data = collect((Http::withoutVerifying()
            ->withBasicAuth($user, $pw)
            ->get("$server/mail/users?format=json")
            ->object())[0]->users);

        /*
        $data = json_decode(<<<'JSON'
            [
                { "email" : "bills@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "ext.lauris@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "ext.rihards@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "pve@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "gitea@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "kristaps@kecom.lv", "privileges": [ "admin" ], "status": "active" },
                { "email" : "leadcollect@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "odoo@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "passit@kecom.lv", "privileges": [ ], "status": "active" }
            ]
        JSON);
        */

        return view('emails.index', [
            'users' => $data->sortBy('email'),
        ]);
    }

    public function create()
    {

        return view('emails.create', [

        ]);
    }

    public function edit(Request $request)
    {

        $email = 'kristaps321@example.coom';

        return view('emails.edit', ['email' => $email,

        ]);
    }
}
