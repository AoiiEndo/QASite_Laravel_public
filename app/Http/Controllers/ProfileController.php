<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $questions = $user->questions()->latest()->get();
        return view('profile.index', compact('user', 'questions'));
    }
}
