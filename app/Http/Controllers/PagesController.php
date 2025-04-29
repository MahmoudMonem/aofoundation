<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function privacy_policy()
    {
            return view('privacy-policy');
    }

    public function terms_and_conditions()
    {
            return view('terms-and-conditions');
    }
}
