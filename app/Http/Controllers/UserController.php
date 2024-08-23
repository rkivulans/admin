<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;



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

       
        /// domain var atdalit ar "," vai 'enter' vai "space"
        //// bet velams izmantot 1 veidu, savadak vel jafiltre tuksumi.
        $domains = array_map(fn($domain) => trim($domain), preg_split('/((\s*,\s*)|(\r\n)|(\s+))/', $validated['domains'])); 
        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'domains' => $domains ,
                'password' => Hash::make($validated['password']),
            ]);
        } catch (\ErrorException $error) {
            return redirect()->back()
                ->with('error', $error->getMessage());
        }
      
    
        return redirect()->route('users.index')
            ->with('success', __('User :user created successfully!', ['email' => $validated['email']]))
            ->with('lastId', $validated['email']);

    }

    public function edit()
    {
        abort(404, 'Work in progress');
    }
}
