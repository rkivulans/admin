<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AliasController extends Controller
{
    public function index(){


        return view('aliases.index', [
            'alias' => "Lauris TEST alias"
        ]);
    }
}
