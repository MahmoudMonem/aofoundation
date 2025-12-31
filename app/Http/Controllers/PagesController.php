<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventimage;
use App\Models\ClientLogo;

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

    
    
    
    public function index()
    {
        $clientLogosRow1 = ClientLogo::getRow1();
        $clientLogosRow2 = ClientLogo::getRow2();

        $events = Event::with('eventimages')
        ->where('available', 1)
        ->where('organizer_id', 1)
        ->orderBy('created_at', 'desc')
        ->get();
    
        return view('/welcome', compact('events','clientLogosRow1', 'clientLogosRow2',)); // replace 'your-view-name' with actual Blade view
    }
    

}
