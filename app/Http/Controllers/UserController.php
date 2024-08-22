<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected $mailService;

    protected $userService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);
        $this->userService = new UserService;

    }

    public function index()
    {

        //dd(User::all());
        $fakeData = json_decode(
            <<<'JSON'
        [
        {"name": "Lauris", "email" : "lauris@inbox.lv", "domains" : "inbox.lv, devmail.com"},
        {"name": "Janis", "email" : "janis@test.lv", "domains": "test.lv" }
        ]
        JSON
        );

        return view('users.index', ['users' => User::all()]);
    }

    public function create()
    {

        return view('users.create', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'domains' => ['required', 'string'],
            'password' => ['required', Password::defaults()],

        ]);

        ///// need try and catch error

        $this->userService->createUser(
            $validated['name'],
            $validated['email'],
            $validated['domains'],
            $validated['password']
        );

        return redirect()->route('users.index')
            ->with('success', __('User :user created successfully!', ['email' => $validated['email']]))
            ->with('lastId', $validated['email']);

    }

    public function edit()
    {
        abort(404, 'Work in progress');
    }
}
