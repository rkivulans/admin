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
                'string',
                Rule::in([
                    MailUserPrivilegeEnum::ADMIN->name,
                    MailUserPrivilegeEnum::USER->name
                ])
            ],
        ]);

        /*
           Es ieliku addUser funckija kaa parametru visu validation,
           jo padodot tikai email un allowed domains es netieku pie paroles,
           savadak so funkciju man liekas butu jasauc savadak.
           Varu partaisit ja nav pareizi un uzlikt ka transformeri parbauda tikai allowed domains
           un seit controlieri palaist $this->mailService->mailboxService->addMailUser,
           bet tad atkal addUser funkcija butu janosauc savadak.
        */
        try {
            $this->mailService->addUser(
                $validated['user'],
                $validated['password'],
                MailUserPrivilegeEnum::from($validated['role']),
                ['devmail.ke.com.lv']
            );
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', $th->getMessage());
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
            $this->mailService->setMailUserPassword($user, $validated['password']);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', $th->getMessage());
        }

        // Pāradresē uz 'emails.index' ar veiksmes ziņojumu
        return redirect()->route('emails.index')
            ->with('success', __('User :user password reset successfully!', ['user' => $user]))
            ->with('lastId', $user);
    }
}
