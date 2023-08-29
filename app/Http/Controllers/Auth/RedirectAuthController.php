<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirect()
    {
        if (auth()->check() && auth()->user()->roles[0]->name == 'Admin') {
            return redirect()->route('dashboard.admin');
        } elseif (auth()->check() && auth()->user()->roles[0]->name == 'User') {
            return redirect()->route('dashboard.user');
        } else {
            return redirect('/');
        }
    }
}
