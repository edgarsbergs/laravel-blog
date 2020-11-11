<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        Subscriber::create([
            'email' => $request->email,
         ]);

        return redirect('/')->withMessage('subscribed!');
    }
}
