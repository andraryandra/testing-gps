<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoriesRequest;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    // Deklarasikan properti kelas untuk menyimpan middleware
    protected $CategoriList;

    public function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('category-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $data = [
            'categories' => Categories::select(['id', 'name', 'detail', 'created_at'])
                ->orderByDesc('created_at')
                ->paginate(5),
        ];

        return view('pages.dashboard_admin.categories.index', $data, [
            'title' => 'Categories',
            'active' => 'categories',
            'i' => ($data['categories']->currentPage() - 1) * $data['categories']->perPage() + 1,
            'breadcumb' => [
                'links' => [
                    [
                        'name' => 'Categories',
                        'url' => route('dashboard.categories.index')
                    ]
                ]
            ]
        ]);
    }
    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        if (Gate::denies('category-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        return view('pages.dashboard_admin.categories.create', [
            'title' => 'Create Category',
            'active' => 'categories',
            'breadcumb' => [
                'links' => [
                    [
                        'name' => 'Categories',
                        'url' => route('dashboard.categories.index')
                    ],
                    [
                        'name' => 'Create Category',
                        'url' => route('dashboard.categories.create')
                    ]
                ]
            ]
        ]);
    }
    /**
     * Store the newly created resource in storage.
     */
    public function store(Categories $categories, CategoriesRequest $request)
    {
        $categories->create([
            'name' => $request->name,
            'detail' => $request->detail,

        ]);

        // return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
        return to_route('dashboard.categories.index', ['success' => 'Category created successfully']);
    }

    /**
     * Display the resource.
     */
    public function show(): never
    {
        abort(404);
    }
    /**
     * Show the form for editing the resource.
     */
    public function edit($id)
    {
        if (Gate::denies('category-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $category = Categories::findOrfail($id);

        return view('pages.dashboard_admin.categories.edit', [
            'category' => $category,
            'title' => 'Edit Category',
            'active' => 'categories',
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(CategoriesRequest $request)
    {
        if (Gate::denies('category-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $category = Categories::find($request->id);
        $category->name = $request->name;
        $category->detail = $request->detail;
        $category->save();

        // return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully');
        return to_route('dashboard.categories.index', ['success' => 'Category updated successfully']);
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy($id)
    {
        if (Gate::denies('category-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $category = Categories::find($id);
        $category->delete();

        // return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
        return to_route('dashboard.categories.index', ['success' => 'Category deleted successfully']);
    }
}
