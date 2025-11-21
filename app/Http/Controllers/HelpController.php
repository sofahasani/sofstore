<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display help & FAQ page
     */
    public function index()
    {
        return view('help.index');
    }
}
