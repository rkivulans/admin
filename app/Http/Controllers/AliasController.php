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
   
        try {
            $this->mailService->addAlias(
                $validated['alias'], 
                $validated['forwards_to'],
                ['devmail.ke.com.lv']
                //// permitted default = null
            );
        } catch (\ErrorException $error) {
            return redirect()->back()
                ->with('error', $error->getMessage());
        }

        return redirect()->route('aliases.index')
            ->with('success', __('Alias :alias created successfully!', ['alias' => $validated['alias']]))
            ->with('lastId', $validated['alias']);
    }

    public function edit($alias)
    {      
        /// ceru ka es pareizi domaju
        //// seit iespejams ari vajadzeja try un catch, bet pagaidam atstaju
        $forwards_to = $this->mailService->getAliasForwardsTo($alias, ['devmail.ke.com.lv']);

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

        
            try {
                $this->mailService->updateAlias(
                    $alias, 
                    join(', ', $validated['forwards_to']),
                    ['devmail.ke.com.lv']
                    //// permitted default = null
                );
            } catch (\ErrorException $error) {
                return redirect()->back()
                    ->with('error', $error->getMessage());
            }

        return redirect()->route('aliases.index')
            ->with('success', __('Alias :alias updated successfully!', ['alias' => $alias]))
            ->with('lastId', $alias);
    }




    /////destroy ? archive?
}
