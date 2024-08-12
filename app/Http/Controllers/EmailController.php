<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
  public function index()
  {

    $dati = json_decode(
      <<<JSON
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
        JSON
    );


    return view('emails.index', [
      'users' => $dati
    ]);
  }
}
