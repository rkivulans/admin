<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $mailService = $this->mailService;
        $domains = Cache::remember('allDomains', 10, function () use ($mailService) {
            return $mailService->getDomains(['*']);
        });

        return view('users.create', compact('domains'));
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'domains' => ['array'],
            'domains.*' => ['required', 'string'],
            'max_emails' => ['nullable', 'integer', 'min:0'],
            'max_aliases' => ['nullable', 'integer', 'min:0'],
            'max_storage' => ['nullable', 'integer', 'min:0'],
            'max_domains' => ['nullable', 'integer', 'min:0'],
        ]);

        if (! $this->mailService->getMailbox($validated['email'], ['*'])) {
            return redirect()->back()
                ->with('error', __("Email doesn't exist in API!"));
        }

        if (isset($validated['domains'])) {
            $mailService = $this->mailService;
            $apiDomains = Cache::remember('allDomains', 10, function () use ($mailService) {
                return $mailService->getDomains(['*']);
            });
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

        $mailService = $this->mailService;
        $domains = Cache::remember('allDomains', 10, function () use ($mailService) {
            return $mailService->getDomains(['*']);
        });

        return view('users.edit', compact('user', 'domains'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'domains' => ['array'],
            'domains.*' => ['required', 'string'],
            'max_emails' => ['nullable', 'integer', 'min:0'],
            'max_aliases' => ['nullable', 'integer', 'min:0'],
            'max_storage' => ['nullable', 'integer', 'min:0'],
            'max_domains' => ['nullable', 'integer', 'min:0'],
        ]);

        if (isset($validated['domains'])) {
            $mailService = $this->mailService;
            $apiDomains = Cache::remember('allDomains', 10, function () use ($mailService) {
                return $mailService->getDomains(['*']);
            });
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
            'domains' => $validated['domains'] ?? [],
            'max_emails' => $validated['max_emails'],
            'max_aliases' => $validated['max_aliases'],
            'max_storage' => $validated['max_storage'],
            'max_domains' => $validated['max_domains'],
        ]);

        Cache::flush();

        return redirect()->route('users.index')
            ->with('success', __('User :user updated successfully!', ['user' => $user->email]))
            ->with('lastId', $user);
    }
}
