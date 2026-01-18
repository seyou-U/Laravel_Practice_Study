<?php

namespace App\Http\Controllers;

use App\Mail\ContactCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validated([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        Mail::to($request->email)->send(new ContactCompleted($request->name));
        return back()->with('status', '送信しました');
    }
}
