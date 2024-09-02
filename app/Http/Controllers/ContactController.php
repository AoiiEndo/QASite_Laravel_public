<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'inquiry_type' => 'required|integer|in:0,1,2',
            'message' => 'required|string',
        ]);

        Inquiry::create($validated);

        return redirect('/contact')->with('success', 'お問い合わせありがとうございました。');
    }
}
