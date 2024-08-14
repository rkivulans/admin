<?php

namespace App\Http\Controllers;

use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;

class AliasController extends Controller
{
    protected $mailboxService;

    public function __construct(MailboxServiceInterface $mailboxService)
    {
        $this->mailboxService = $mailboxService;
    }

    public function index()
    {

        return view('aliases.index', [
            'aliases' => $this->mailboxService->getMailAliases()->sortBy('address'),
        ]);
    }

    public function create()
    {

        return view('aliases.create', []);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alias' => 'required|string|max:255',
            'forwards_to' => 'required|string',
        ]);
        
        return redirect()->route('aliases.create')->with('success', 'Alias created successfully!');
    }

    public function edit(Request $request)
    {
        $address = 'test@gmail.com';
        $forwards_to = ['test2@gmail.com', 'test3@gmail.com'];

        return view('aliases.edit', [
            'address' => $address,
            'forwards_to' => $forwards_to,
        ]);
    }

    public function update(Request $request, $alias): RedirectResponse
    {
        $validated = $request->validate([
            'forwards_to' => 'required|string',
        ]);
        
        return redirect()->route('aliases.edit', ['alias' => $alias])->with('success', 'Alias updated successfully!');
    }
}
