<?php

namespace App\Http\Controllers;

use App\Mail\ContactCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        Mail::to($validated['email'])->send(new ContactCompleted($validated['name']));

        return back()->with('status', '送信しました');
    }
}
