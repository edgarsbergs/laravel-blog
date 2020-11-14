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
        $validated = $request->validate([
            'email' => 'required|unique:subscribers|email',
        ]);
        Subscriber::create($validated);

        return redirect('/')->withMessage(__('messages.subscribed'));
    }
}
