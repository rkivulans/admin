<?php

namespace App\Http\Controllers;

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmailController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);

    }

    public function index(Request $request)
    {
        $mailService = $this->mailService;

        $users = Cache::remember("emails:{$request->user()->id}", 10, function () use ($request, $mailService) {
            return $mailService
                ->getUsers($request->user()->domains)
                ->sortBy('email');
        });

        $domainCount = $users->groupBy(function ($user, int $key) {
            return explode("@", $user->email, 2)[1];
        })->count();

        $userCount = $users->count();
        
        $storageCount = 512; // to do - get from api used

        return view('emails.index', compact('users', 'domainCount', 'userCount', 'storageCount'));
    }

    public function create()
    {

        return view('emails.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (! $this->mailService->checkAccess($validated['email'], $request->user()->domains)) {
            return redirect()->back()
                ->with('error', __('You have no permision to this domain!'))
                ->withInput();
        }

        $this->mailService->addUser(
            $validated['email'],
            $validated['password'],
            $request->user()->domains,
        );

        Cache::flush();

        return redirect()->route('emails.index')
            ->with('success', __('Email :email created successfully!', ['email' => $validated['email']]))
            ->with('lastId', $validated['email']);
    }

    public function edit(Request $request, $email)
    {

        return view('emails.edit', compact('email'));
    }

    public function update(Request $request, $user): RedirectResponse
    {
        abort_if($user == $request->user()->email, 403);

        $validated = $request->validate([
            'password' => 'required|string|min:8',
        ]);

        if (! $this->mailService->checkAccess($user, $request->user()->domains)) {
            return redirect()->back()
                ->with('error', __('You have no permision to this domain!'))
                ->withInput();
        }

        $this->mailService->setPassword($user, $validated['password'], $request->user()->domains);

        Cache::flush();

        // Pāradresē uz 'emails.index' ar veiksmes ziņojumu
        return redirect()->route('emails.index')
            ->with('success', __('User :user password reset successfully!', ['user' => $user]))
            ->with('lastId', $user);
    }

    //// destroy ? archive?
}
