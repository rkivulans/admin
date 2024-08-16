<?php

namespace App\Http\Controllers;

use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{    
    protected $mailboxService;

    public function __construct(MailboxServiceInterface $mailboxService)
    {
        $this->mailboxService = $mailboxService;
    }

    public function index()
    {

        /*
        $user = config('services.mailbox.user');
        $pw = config('services.mailbox.password');
        $server = config('services.mailbox.server');

        $data = collect((Http::withoutVerifying()
            ->withBasicAuth($user, $pw)
            ->get("$server/mail/users?format=json")
            ->object())[0]->users);
            */

        /*
        $data = json_decode(<<<'JSON'
            [
                { "email" : "bills@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "ext.lauris@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "ext.rihards@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "pve@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "gitea@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "kristaps@kecom.lv", "privileges": [ "admin" ], "status": "active" },
                { "email" : "leadcollect@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "odoo@kecom.lv", "privileges": [ ], "status": "active" },
                { "email" : "passit@kecom.lv", "privileges": [ ], "status": "active" }
            ]
        JSON);
        */

        return view('emails.index', [
            'users' => $this->mailboxService->getEmailUsers()->sortBy('email'),
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
            ->with('success', 'Email ' . $validated['email'] . ' created successfully!')
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
            ->with('success', 'User ' . $user . ' password reset successfully!')
            ->with('lastId', $user);
    }
}
