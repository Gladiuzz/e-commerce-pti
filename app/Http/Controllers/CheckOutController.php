<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        $driver = User::where('role', 'driver')
        ->get();

        $data = array(
            'contact' => $contact,
            'driver' => $driver,
        );

        return view('landing-page.checkout', $data);
    }
}
