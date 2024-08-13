<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AliasController extends Controller
{
    public function index()
    {

        $dati = json_decode(<<<'JSON'
             [
                { "address": "user1@example.com", "address_display": "user1@example.com", "forwards_to": [ "user@example.com" ], "permitted_senders": [ "user@example.com" ], "required": true } ,
                { "address": "user2@example.com", "address_display": "user2@example.com", "forwards_to": [ "user@example.com", "user@example.com" ], "permitted_senders": [ "user@example.com", "user@example.com" ], "required": true } ,
                { "address": "user3@example.com", "address_display": "user3@example.com", "forwards_to": [ "user@example.com" ], "permitted_senders": [ "user@example.com" ], "required": false } ,
                { "address": "user4@example.com", "address_display": "user4@example.com", "forwards_to": [ "user@example.com", "user@example.com"  ], "permitted_senders": [ "user@example.com", "user@example.com" ], "required": false} ,
                { "address": "user5@example.com", "address_display": "user5@example.com", "forwards_to": [ "user@example.com" ], "permitted_senders": [ "user@example.com" ], "required": false} 
             ]
        JSON);

        

        return view('aliases.index', [
            'aliases' => $dati,
        ]);
    }


    public function create()
    {

        return view('aliases.create', []);
    }

    public function edit(Request $request)
    {

        $email = 'kristaps321@example.coom';

        return view('aliases.edit', [
            'email' => $email,

        ]);
    }
}
