<?php

namespace App\Http\Controllers;

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);

    }

    public function index(Request $request)
    {
        $users = $this->mailService
            ->getUsers($request->user()->domains)
            ->sortBy('email');

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

        if (! $this->mailService->checkAccess($user, $request->user()->domains)) {
            return redirect()->back()
                ->with('error', __('You have no permision to this domain!'))
                ->withInput();
        }

        $this->mailService->setPassword($user, $validated['password'], $request->user()->domains);

        // Pāradresē uz 'emails.index' ar veiksmes ziņojumu
        return redirect()->route('emails.index')
            ->with('success', __('User :user password reset successfully!', ['user' => $user]))
            ->with('lastId', $user);
    }

    //// destroy ? archive?
}
