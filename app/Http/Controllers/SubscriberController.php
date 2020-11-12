<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Saves new subscriber
     *
     * @param object $request
     * @return resource
     */
    public function store(Request $request)
    {
        Subscriber::create([
            'email' => $request->email,
         ]);

        return redirect('/')->withMessage(__('messages.subscribed'));
    }
}
