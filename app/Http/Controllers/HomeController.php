<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function admin()
    {
        return view(
            'pages.dashboard_admin.index',
            [
                'title' => 'Dashboard Admin',
                'active' => 'dashboard',
                'breadcumb' => [
                    'links' => [
                        [
                            'name' => 'Dashboard',
                            'url' => route('dashboard.admin')
                        ]
                    ]
                ]

            ]
        );
    }

    public function user()
    {
        return view(
            'pages.dashboard_user.index',
            [
                'title' => 'Dashboard User',
                'active' => 'dashboard',
                'breadcumb' => [
                    'links' => [
                        [
                            'name' => 'Dashboard',
                            'url' => route('dashboard.user')
                        ]
                    ]
                ]
            ]
        );
    }
}
