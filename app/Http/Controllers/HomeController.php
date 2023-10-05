<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Toko\OfficialStore;
use Illuminate\Support\Facades\DB;

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
        $total_user = User::count();
        // $total_sales = User::count();
        $total_sales = DB::table('model_has_roles')->where('role_id', 2)->count();
        $total_categori = Categories::count();
        $total_official = OfficialStore::count();
        return view(
            'pages.dashboard_admin.index',
            compact('total_user', 'total_categori', 'total_official', 'total_sales'),
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
