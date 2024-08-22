<?php

namespace App\Http\Controllers;

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use App\Services\MailUserPrivilegeEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);
    }

    public function index()
    {
        $users = $this->mailService->getUsers([
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
            'role' => [
                'required',
                'string',
                Rule::in([
                    MailUserPrivilegeEnum::ADMIN->name,
                    MailUserPrivilegeEnum::USER->name,
                ]),
            ],
        ]);

        try {
            $this->mailService->addUser(
                $validated['email'],
                $validated['password'],
                constant(MailUserPrivilegeEnum::class."::{$validated['role']}"), // TODO change to Foo::{$searchableConstant} when upgrading to php8.3,
                ['devmail.ke.com.lv']
            );
        } catch (\ErrorException $error) {
            return redirect()->back()
                ->with('error', $error->getMessage());
        }

        return redirect()->route('emails.index')
            ->with('success', __('Email :email created successfully!', ['email' => $validated['email']]))
            ->with('lastId', $validated['email']);
    }

    public function edit(Request $request, $user)
    {

        // Atgriež skatu 'emails.edit
        return view('emails.edit', [
            'email' => $user,
        ]);
    }

    public function update(Request $request, $user): RedirectResponse
    {
        // Validē paroli (obligāta, vismaz 8 rakstzīmes)
        $validated = $request->validate([
            'password' => 'required|string|min:8',
        ]);

        try {
            $this->mailService->setPassword(
                $user, $validated['password'], ['devmail.ke.com.lv']
            );
        } catch (\ErrorException $error) {
            return redirect()->back()
                ->with('error', $error->getMessage());
        }

        // Pāradresē uz 'emails.index' ar veiksmes ziņojumu
        return redirect()->route('emails.index')
            ->with('success', __('User :user password reset successfully!', ['user' => $user]))
            ->with('lastId', $user);
    }

    //// destroy ? archive?
}
