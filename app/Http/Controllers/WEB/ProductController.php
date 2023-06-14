<?php

namespace App\Http\Controllers\WEB;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product  = Product::latest()->get();
        $category = Category::all();

        return view('pages.admin.product.index', compact(
            'product',
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
        $category = Category::all();

        return view('pages.admin.product.create', compact(
            'category'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //! Fungsi Store yang digunakan untuk insert data
        //request validation
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|integer',
            'description' => 'required|string',
        ]);

        //insert data ke database
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        if ($product) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.product.index')->with([
                'success' => 'Data Berhasil Ditambahkan!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.product.index')->with([
                'error' => 'Data Gagal Ditambahkan!'
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
        //! Fungsi Show yang digunakan untuk menampilkan detail data
        //cari data berdasarkan id
        $product = Product::findOrFail($id);
        $category = Category::all();
        
        return view('pages.admin.product.show', compact(
            'product',
            'category'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //! Fungsi Edit yang digunakan untuk ke halaman edit data
        //cari data berdasarkan id
        $product = Product::findOrFail($id);
        //orderBy ASC digunakan untuk mengurutkan data berdasarkan nama A-Z
        $category = Category::orderBy('name', 'ASC')->get();

        return view('pages.admin.product.edit', compact(
            'product',
            'category'
        ));
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
        //! Fungsi Update yang digunakan untuk update data
        //request validation
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|integer|min:1000',
            'description' => 'required|string',
        ]);

        //get data by id
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description
        ]);
        
        //redirect dengan pesan
        if($product){
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.product.index')->with([
                'success' => 'Data Berhasil Diupdate!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.product.index')->with([
                'error' => 'Data Gagal Diupdate!'
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
        //! Fungsi Destroy yang digunakan untuk menghapus data
        //get data by id
        $product = Product::findOrFail($id);
        //delete data
        $product->delete();

        if($product){
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.product.index')->with([
                'success' => 'Data Berhasil Dihapus!'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.product.index')->with([
                'error' => 'Data Gagal Dihapus!'
            ]);
        }
    }

}
