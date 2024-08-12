<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(){

        /*
        $users = [
            {
              "domain": "example.com",
              "users": [
                {
                  "email": "user@example.com",
                  "privileges": [
                    "admin"
                  ],
                  "status": "active",
                  "mailbox": "/home/user-data/mail/mailboxes/example.com/user"
                }
              ]
            }
          ]
            */

        
            

        return view('emails.index', [
            'users' => $users
        ]);
}

}
