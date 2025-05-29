<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public.product.detail');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('public.product.search');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
            'price' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|string',
        ]);

        DetailTransaction::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total_price' => $request->total_price
        ]);

        return redirect()->back()->with('productSuccessAlert', 'Produk berhasil ditambahkan ke keranjang.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productDetail = Product::findOrFail($id);
        $productSimilar = Product::where('category', $productDetail->category)
            ->where('id', '!=', $id)
            ->take(20)
            ->get();
        $categories = Product::where('category', "!=", null)->limit(5)->get();

        return view('public.product.detail', compact('productDetail', 'productSimilar', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
