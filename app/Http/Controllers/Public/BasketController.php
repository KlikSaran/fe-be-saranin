<?php

namespace App\Http\Controllers\Public;

use App\Models\DetailTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Product::select('category', 'image')->get()->unique('category');

        $getBasket = DetailTransaction::whereHas('transaction.user', function ($query) {
            $query->where('id', auth()->id());
        })
            ->with(['product', 'transaction.user'])
            ->latest()
            ->limit(10)
            ->get();

        $basketIds = $getBasket->pluck('id')->implode(',');
        $basketQuantities = $getBasket->pluck('quantity', 'id')->toArray();
        $basketSubtotals = [];

        foreach ($getBasket as $item) {
            $subtotal = $item->product ? $item->product->price * $item->quantity : 0;
            $basketSubtotals[$item->id] = $subtotal;
        }

        return view('public.basket.index', compact(
            'categories',
            'getBasket',
            'basketIds',
            'basketQuantities',
            'basketSubtotals'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'detail_transaction_id' => 'required|string',
        //     'total_price' => 'required|string',
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        try {
            $item = DetailTransaction::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Item berhasil dihapus dari keranjang.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus item: ' . $e->getMessage()
            ], 500);
        }
    }
}
