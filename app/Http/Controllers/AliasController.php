<?php

namespace App\Http\Controllers;

use App\Services\MailboxServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
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
            ->with('success', __('Alias :alias created successfully!', ['alias'=> $validated['alias'] ]))
            ->with('lastId', $validated['alias']);
    }

    public function edit($alias)
    {
        $forwards_to = ['test2@gmail.com', 'test3@gmail.com'];

        return view('aliases.edit', [
            'address' => $alias,
            'forwards_to' => $forwards_to,
        ]);
    }

    public function update(Request $request, $alias): RedirectResponse
    {
        $formData = [
            'forwards_to' => explode("\r\n", $request->input('forwards_to')),
        ];

        $validated = Validator::make($formData,
        [
            'forwards_to.*' => 'required|email',
        ])->validate();

        return redirect()->route('aliases.index')
        ->with('success', __('Alias :alias updated successfully!', ['alias' => $alias]))
            ->with('lastId', $alias);
    }
}
