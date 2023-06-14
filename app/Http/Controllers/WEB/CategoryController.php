<?php

namespace App\Http\Controllers\WEB;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::latest()->get();

        return view('pages.admin.category.index', compact(
            'category'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //fungsi yang digunakan untuk menambahkan data

        //request validation
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        //insert data ke database
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        //redirect dengan pesan
        if ($category) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.category.index')->with([
                'success' => 'Data Berhasil Disimpan!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.category.index')->with([
                'error' => 'Data Gagal Disimpan!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //cari data by id
        $category = Category::findOrFail($id);

        return view('pages.admin.category.show', compact([
            'category'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //cari data by id
        $category = Category::findOrFail($id);

        return view('pages.admin.category.edit', compact([
            'category'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //fungsi yang digunakan untuk mengupdate data

        //request validation
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        //cari data by id
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        //redirect dengan pesan
        if ($category) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.category.index')->with([
                'success' => 'Data Berhasil Diubah!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.category.index')->with([
                'error' => 'Data Gagal Diubah!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //cari id datanya
        $category = Category::findOrFail($id);
        //hapus data
        $category->delete();

        //redirect dengan pesan
        if ($category) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.category.index')->with([
                'success' => 'Data Berhasil Dihapus!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.category.index')->with([
                'error' => 'Data Gagal Dihapus!'
            ]);
        }
    }
}
