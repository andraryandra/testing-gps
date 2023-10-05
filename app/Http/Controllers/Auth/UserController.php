<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $users = User::select('name', 'email', 'id')->orderByDesc('created_at')->get();
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return view(
            'pages.dashboard_admin.users.index',
            [
                'data' => $users,
                'roles' => $roles, // Tambahkan data roles ke tampilan
                'title' => 'User Management',
                'active' => 'users',
                'breadcumb' => [
                    'links' => [
                        [
                            'name' => 'User Management',
                            'url' => route('dashboard.users.index')
                        ]
                    ]
                ]
            ]
        )->with('i', ($request->input('page', 1) - 1) * 5);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create(): View
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $roles = Role::pluck('name', 'name')->all();
        return view('pages.dashboard_admin.users.create', [
            'roles' => $roles,
            'active' => 'users',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request): RedirectResponse
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function show($id): View
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $user = User::find($id);
        return view('pages.dashboard_admin.users.show', [
            'user' => $user,
            'active' => 'users',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id): View
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('pages.dashboard_admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
            'active' => 'users',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, $id): RedirectResponse
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function destroy($id): RedirectResponse
    {
        if (Gate::denies('users-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        User::find($id)->delete();
        return redirect()->route('dashboard.users.index')
            ->with('success', 'User deleted successfully');
    }
}
