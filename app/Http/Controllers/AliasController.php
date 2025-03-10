<?php

namespace App\Http\Controllers;

use App\Services\MailboxApiClientInterface;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AliasController extends Controller
{
    protected $mailService;

    public function __construct(MailboxApiClientInterface $apiClient)
    {
        $this->mailService = new MailService($apiClient);
    }

    public function index(Request $request)
    {
        $mailService = $this->mailService;

        $aliases = Cache::remember("aliases:{$request->user()->id}", 10, function () use ($request, $mailService) {
            return $mailService
                ->getAliases($request->user()->domains)
                ->sortBy('address');
        });

        $aliasCount = $aliases->count();

        return view('aliases.index', compact('aliases', 'aliasCount'));
    }

    public function create()
    {

        return view('aliases.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formData = [
            'alias' => $request->input('alias'),
            'forwards_to' => explode(' ', trim(preg_replace('/[\s,]+/', ' ', $request->input('forwards_to')))),
        ];

        $validated = Validator::make($formData, [
            'alias' => 'required|max:255',
            'forwards_to.*' => 'required|email',
        ])->sometimes('alias', 'email', function ($input) {
            return ! str_starts_with($input->alias, '@');
        })->validate();

        Cache::flush();

        if (! $this->mailService->checkAccess($validated['alias'], $request->user()->domains)) {
            return redirect()->back()
                ->with('error', __('You have no permision to this domain!'))
                ->withInput();
        }

        $this->mailService->addAlias(
            $validated['alias'],
            $validated['forwards_to'],
            $request->user()->domains,
        );

        return redirect()->route('aliases.index')
            ->with('success', __('Alias :alias created successfully!', ['alias' => $validated['alias']]))
            ->with('lastId', $validated['alias']);
    }

    public function edit(Request $request, $alias)
    {
        /// ceru ka es pareizi domaju
        //// seit iespejams ari vajadzeja try un catch, bet pagaidam atstaju
        $aliasData = $this->mailService->getAlias($alias, $request->user()->domains);
        $forwards_to = $aliasData->forwards_to;

        // dd($aliasData);

        abort_unless($aliasData, 404);

        return view('aliases.edit', compact('alias', 'forwards_to'));
    }

    public function update(Request $request, $alias): RedirectResponse
    {
        $formData = [
            'forwards_to' => explode(' ', trim(preg_replace('/[\s,]+/', ' ', $request->input('forwards_to')))),
        ];

        $validated = Validator::make($formData,
            [
                'forwards_to.*' => 'required|email',
            ])->validate();

        Cache::flush();

        try {
            $this->mailService->updateAlias(
                $alias,
                $validated['forwards_to'],
                $request->user()->domains,
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
