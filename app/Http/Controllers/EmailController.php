<?php

namespace App\Http\Controllers;

use App\Services\MailApiTransformer;
use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);
        
        return redirect()->route('emails.index')
            ->with('success', 'Email ' . $validated['email'] . ' created successfully!')
            ->with('lastId', $validated['email']);
    }

    public function edit(Request $request, $user)
    {

        $email = 'kristaps321@example.coom';

        return view('emails.edit', ['email' => $email,

        ]);
    }

    public function update(Request $request, $user): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        return redirect()->route('emails.index')
            ->with('success', 'User ' . $user . ' password reset successfully!')
            ->with('lastId', $user);
    }
}
