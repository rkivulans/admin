<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);

    }

    public function index(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        return view('users.index', ['users' => User::all()]);
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        return view('users.create', ['domains' => $this->mailService->getDomains(['*'])]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'domains' => ['array'],
            'domains.*' => ['required', 'string'],
        ]);

        if (! $this->mailService->getMailbox($validated['email'], ['*'])) {
            return redirect()->back()
                ->with('error', __("Email doesn't exist in API!"));
        }

        if (isset($validated['domains'])) {
            $apiDomains = $this->mailService->getDomains(['*']);
            foreach ($validated['domains'] as $domain) {
                if ($domain === '*') {
                    continue;
                }
                if ($apiDomains->doesntContain($domain)) {
                    return redirect()->back()
                        ->with('error', __("Domain :domain domains doesn't exist in API", ['domain' => $domain]));
                }
            }
        }

        $user = new User($validated);
        $user->password = Str::random(40);
        $user->save();

        return redirect()->route('users.index')
            ->with('success', __('User :user created successfully!', ['user' => $validated['email']]))
            ->with('lastId', $validated['email']);

    }

    public function edit(Request $request, User $user)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        return view('users.edit', ['user' => $user, 'domains' => $this->mailService->getDomains(['*'])]);
    }

    public function update(Request $request, User $user)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'domains' => ['array'],
            'domains.*' => ['required', 'string'],
        ]);

        if (isset($validated['domains'])) {
            $apiDomains = $this->mailService->getDomains(['*']);
            foreach ($validated['domains'] as $domain) {
                if ($domain === '*') {
                    continue;
                }
                if ($apiDomains->doesntContain($domain)) {
                    return redirect()->back()
                        ->with('error', __("Domain :domain domains doesn't exist in API", ['domain' => $domain]));
                }
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
