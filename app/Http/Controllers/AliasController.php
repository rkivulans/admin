<?php

namespace App\Http\Controllers;

class AliasController extends Controller
{
    public function index()
    {

        return view('aliases.index', [
            'alias' => 'Lauris TEST alias',
        ]);
    }
}
