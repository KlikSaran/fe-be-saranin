<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function preview(Request $request)
    {
        $categories = Product::whereNotNull('category')
            ->select('category')
            ->distinct()
            ->limit(5)
            ->get();

        $productIds = explode(',', $request->product_id); // untuk beli langsung
        $detailIds = explode(',', $request->detail_transaction_id); // untuk dari keranjang
        $quantities = explode(',', $request->quantity);
        $subtotals = explode(',', $request->subtotals);
        $total = $request->total_price;

        $items = collect();

        if (!empty($productIds[0])) {
            foreach ($productIds as $index => $productId) {
                $product = Product::findOrFail($productId);
                $qty = isset($quantities[$index]) ? (int) $quantities[$index] : 1;

                $items->push((object)[
                    'product' => $product,
                    'quantity' => max(1, $qty),
                    'total_price' => $product->price * $qty,
                ]);
            }
        } else {
            foreach ($detailIds as $index => $id) {
                $detail = DetailTransaction::with('product')->find($id);
                if ($detail) {
                    $newQty = isset($quantities[$index]) ? (int) $quantities[$index] : $detail->quantity;
                    $detail->quantity = max(1, $newQty);
                    $detail->total_price = $detail->product->price * $detail->quantity;
                    $detail->save();

                    $items->push($detail);
                }
            }
        }

        if (!$total || $total == 0) {
            $total = 0;
            foreach ($items as $item) {
                $total += $item->total_price;
            }
        }

        return view('public.checkout.index', compact('items', 'categories', 'total', 'subtotals'));
    }



    public function submit(Request $request)
    {
        $request->validate([
            'detail_transaction_ids' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'total_price' => 'nullable|integer|min:0',
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
        ]);

        // Mode keranjang
        if ($request->filled('detail_transaction_ids')) {
            $ids = explode(',', $request->detail_transaction_ids);

            DetailTransaction::whereIn('id', $ids)->update([
                'transaction_id' => $transaction->id
            ]);
        }
        // Mode beli langsung
        else if ($request->filled('product_id')) {
            $product = Product::findOrFail($request->product_id);

            DetailTransaction::create([
                'product_id' => $product->id,
                'transaction_id' => $transaction->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total_price' => $request->total_price,
            ]);
        }

        return redirect()->route('transactions-public.index')->with('checkoutSuccessAlert', 'Pembayaran berhasil diproses!');
    }
}
