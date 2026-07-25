<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function nosotros()
    {
        return view('nosotros');
    }

    public function cuenta()
    {
        if (auth()->check()) {
            return redirect()->route('profile.edit');
        }

        return view('cuenta');
    }
}
