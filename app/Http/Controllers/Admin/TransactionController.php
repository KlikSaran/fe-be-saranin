<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = DetailTransaction::with(['product', 'transaction.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($transactions->isEmpty()) {
            return redirect()->route('transactions.create')->with('transactionAlert', 'Silakan tambahkan transaksi baru.');
        }

        return view('admin.transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

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
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $transactions = DetailTransaction::with('product')
            ->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.transaction.index', [
            'transactions' => $transactions,
            'searchQuery' => $query
        ]);
    }

    // public function getTransaction(Request $request)
    // {
    //     // $user = Auth::user();
    //     $transactions = DetailTransaction::where('product_id', 1) // Operator '=' diasumsikan, dan value sebagai integer
    //         ->with('product') // Eager load relasi 'product'
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return response()->json([
    //         'transactions' => $transactions,
    //         'message' => 'Transactions retrieved successfully.'
    //     ]);
    // }
}
