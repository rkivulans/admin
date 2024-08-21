<?php

namespace App\Http\Controllers;

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AliasController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);
    }

    public function index()
    {

        return view('aliases.index', [
            'aliases' => $this->mailService->getAliases()->sortBy('address'),
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
            ->with('success', __('Alias :alias created successfully!', ['alias' => $validated['alias']]))
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
