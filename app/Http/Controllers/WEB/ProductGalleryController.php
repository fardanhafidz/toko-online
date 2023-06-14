<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {

        $items = $product->galleries()->get();

        return view('pages.admin.product_gallery.index', compact(
            'product',
            'items'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        // ! Fungsi Create yang digunakan untuk menampilkan halaman create

        return view('pages.admin.product_gallery.create', compact(
            'product'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        //! Fungsi Store yang digunakan untuk insert data

        //file upload
        $files = $request->file('files');

        //looping upload file
        foreach ($files as $file) {
            //upload gambar(url)
            $file->storeAs('public/products/', $file->hashName());

            //insert data ke database
            $product->galleries()->create([
                'products_id' => $product->id,
                'url' => $file->hashName()
            ]);
        }

        //redirect dengan pesan
        if ($product) {
            //redirect dengan pesan sukses
            return redirect()->route('dashboard.product.gallery.index', $product->id)->with([
                'success' => 'Data Berhasil Disimpan'
            ]);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dashboard.product.gallery.index', $product->id)->with([
                'error' => 'Data Gagal Disimpan'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductGallery $gallery)
    {
        //! Fungsi yang digunakan untuk melakukan perintah hapus atau delete
        // get data product
        $product = $product->find($gallery->products_id);

        //get product gallery
        $gallery = $product->galleries->find($gallery->id);

        //delete gambar dari storage
        Storage::delete('public/products/' . basename($gallery->url));
        //delete data product gallery
        $gallery->delete();

        if ($gallery) {
            return redirect()->route(
                'dashboard.product.gallery.index',
                $gallery->products_id
            )->with([
                'success' => 'Data berhasil dihapus'
            ]);
        } else {
            return redirect()->route(
                'dashboard.product.gallery.index',
                $gallery->products_id
            )->with([
                'error' => 'Data gagal dihapus'
            ]);
        }
    }
}
