<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);

    }

    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    public function create(Request $request)
    {
        return view('users.create', ['domains' => $this->mailService->getDomains(['*'])]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'domains' => ['required'],
            'domains.*' => ['required', 'string'],
        ]);

        dd($validated['domains']);

        if (! $this->mailService->getMailbox($validated['email'])) {
            return redirect()->back()
                ->with('error', __("Email doesn't exist in API!"));
        }

        foreach ($validated['domains'] as $domain) {
            if ($this->mailService->getDomains()->doesntContain($domain)) {
                return redirect()->back()
                    ->with('error', __("Atleast one of domains doesn't exist in API"));
            }
        }

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', __('User :user created successfully!', ['email' => $validated['email']]))
            ->with('lastId', $validated['email']);

    }

    public function edit(Request $request, User $user)
    {
        return view('users.edit', ['user' => $user, 'domains' => $this->mailService->getDomains(['*'])]);
    }

    public function update(Request $request, User $user)
    {

        $formData = [
            'name' => $request->input('name'),
            'domains' => $request->input('domains'),
        ];

        $validated = Validator::make($formData,
            [
                'name' => ['required', 'string', 'max:255'],
                'domains.*' => ['required', 'string'],
            ])->validate();

        foreach ($validated['domains'] as $domain) {
            if ($this->mailService->getDomains()->doesntContain($domain)) {
                return redirect()->back()
                    ->with('error', __("Atleast one of domains doesn't exist in API"));
            }
        }

        $user->update([
            'name' => $validated['name'],
            'domains' => $validated['domains'],
        ]);

        return redirect()->route('users.index')
            ->with('success', __('User :user updated successfully!', ['user' => $user->email]))
            ->with('lastId', $user);
    }
}
