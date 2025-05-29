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

        $detailIds = explode(',', $request->detail_transaction_id);
        $quantities = explode(',', $request->quantity);
        $subtotals = explode(',', $request->subtotals);
        $total = $request->total_price;

        foreach ($detailIds as $index => $id) {
            $detail = DetailTransaction::with('product')->find($id);
            if ($detail) {
                $newQty = isset($quantities[$index]) ? (int) $quantities[$index] : $detail->quantity;
                $detail->quantity = max(1, $newQty);

                // Update total_price sementara jika ingin disimpan, atau bisa dilewati jika hanya ditampilkan
                $detail->total_price = $detail->product->price * $detail->quantity;

                $detail->save();
            }
        }

        // Ambil ulang item yang sudah di-update
        $items = DetailTransaction::with('product')->whereIn('id', $detailIds)->get();

        return view('public.checkout.index', compact('items', 'categories', 'total', 'subtotals'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'detail_transaction_ids' => 'required|string'
        ]);

        $ids = explode(',', $request->detail_transaction_ids);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
        ]);

        DetailTransaction::whereIn('id', $ids)->update([
            'transaction_id' => $transaction->id
        ]);

        return redirect()->back()->with('checkoutSuccessAlert', 'Pembayaran berhasil diproses!');
    }
}
