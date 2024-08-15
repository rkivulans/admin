<?php

namespace App\Http\Controllers;

use App\Services\MailApiTransformer;
use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $mailApi;

    public function __construct(MailboxServiceInterface $mailboxService)
    {
        $this->mailApi = new MailApiTransformer($mailboxService);
    }

    public function index()
    {
        $users = $this->mailApi->getUsers([
            'box.devmail.ke.com.lv',
            'rihardsmail.ke.com.lv',
            'devmail.ke.com.lv',
        ])->sortBy('email');

        return view('emails.index', [
            'users' => $users,
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
