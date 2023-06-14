<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class FrontEndController extends Controller
{
    public function index()
    {
        //memanggil category untuk navbar
        $nameCategory = Category::latest()->get();

        //memanggil data product dengan galeri
        $product = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index', compact(
            'nameCategory',
            'product'
        ));
    }

    public function detailProduct($slug)
    {
        $nameCategory = Category::latest()->get();

        //get data detail product
        $product = Product::with(['galleries'])
            ->where('slug', $slug)->firstOrFail();

        //get data category with slug
        $category = Category::where('id', $product->category_id)
            ->firstOrFail();

        $recommendation = Product::with(['galleries'])
            ->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.detail_product', compact(
            'nameCategory',
            'product',
            'recommendation',
            'category'
        ));

        // Route::get('/detail-product/{slug}',
        // [FrontEndController::class, 'detailProduct'])->name('detailProduct');
    }

    public function detailCategory($slug)
    {
        $nameCategory = Category::latest()->get();

        //get data category
        $category = Category::where('slug', $slug)->firstOrFail();
        //get data product
        $product = Product::with(['galleries'])
            ->where('category_id', $category->id)->latest()->get();


        return view('pages.frontend.detail_category', compact(
            'nameCategory',
            'category',
            'product'
        ));
    }

    public function cart(Request $request)
    {
        $nameCategory = Category::latest()->get();

        $cart = Cart::with(['product.galleries'])
            ->where('users_id', Auth::user()->id)->get();

        // dd($cart);

        return view('pages.frontend.cart', compact(
            'nameCategory',
            'cart'
        ));
    }

    public function cartStore(Request $request, $id)
    {
        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id
        ]);

        return redirect('cart');
    }

    public function cartDelete($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect('cart');
    }

    public function checkout(CheckoutRequest $request)
    {

        //request data
        $data = $request->all();

        //get carts data
        $carts = Cart::with(['product'])
            ->where('users_id', Auth::user()->id)->get();

        //add to transaction data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('product.price');

        //create transaction
        $transaction = Transaction::create($data);

        //create transaction item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'users_id'          => $cart->users_id,
                'products_id'       => $cart->products_id,
                'transactions_id'   => $transaction->id,
            ]);
        }

        //delete cart
        Cart::where('users_id', Auth::user()->id)->delete();

        //Configuration Midtrans
        // use Midtrans/Config;
        // use Midtrans/Snap;
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //setup variable for midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id'      => 'FARDAN-' . $transaction->id,
                'gross_amount'  => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name'    => $transaction->name,
                'email'         => $transaction->email,
                'phone'         => $transaction->phone,
                'address'       => $transaction->address,
            ],
            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        //payment proses midtrans
        try {
            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($midtrans)->redirect_url;

            //save to database
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            //redirect to midtrans payment page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
