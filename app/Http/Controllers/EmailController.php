<?php

namespace App\Http\Controllers;

use App\Services\MailApiTransformer;
use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

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
            'role' => ['required', 'string', Rule::in(['user', 'admin'])], // Pārbauda, vai lomas vērtība ir "user" vai "admin"
        ]);
        
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
        
        // Pāradresē uz 'emails.index' ar veiksmes ziņojumu
        return redirect()->route('emails.index')
            ->with('success', __('User :user password reset successfully!', ['user' => $user]))
            ->with('lastId', $user);
    }
}
