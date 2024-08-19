<?php

namespace App\Http\Controllers;

use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\MailApiTransformer;

class AliasController extends Controller
{
    protected $mailApi;

    public function __construct(MailboxServiceInterface $mailboxService)
    {
        $this->mailApi = new MailApiTransformer($mailboxService);
    }

    public function index()
    {
     
        return view('aliases.index', [
            'aliases' => $this->mailApi->getAliases()->sortBy('address'),
        ]);
    }

    public function create()
    {

        return view('aliases.create', []);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alias' => 'required|email|max:255',
            'forwards_to' => 'required|string',
        ]);

        return redirect()->route('aliases.index')
            ->with('success', 'Alias ' . $validated['alias'] . ' created successfully!')
            ->with('lastId', $validated['alias']);
    }

    public function edit(Request $request, $alias)
    {
        $address = 'test@gmail.com';
        $forwards_to = ['test2@gmail.com', 'test3@gmail.com'];

        return view('aliases.edit', [
            'address' => $alias,
            'forwards_to' => $forwards_to,
        ]);
    }

    public function update(Request $request, $alias): RedirectResponse
    {
        $validated = $request->validate([
            'forwards_to' => 'required|string',
        ]);

        return redirect()->route('aliases.index')
            ->with('success', 'Alias ' . $alias . ' updated successfully!')
            ->with('lastId', $alias);
    }
}
