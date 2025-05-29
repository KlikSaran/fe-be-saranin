<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTransactions = User::withCount('transactions')
            ->whereHas('transactions')
            ->orderBy('transactions_count', 'desc')
            ->paginate(10);

        return view('admin.consumer.index', compact('userTransactions'));
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
        //
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
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $usersQueryBuilder = User::withCount('transactions')
            ->whereHas('transactions');

        $usersQueryBuilder->where(function ($q) use ($query) {
            $q->where('fullname', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        });

        $userTransactions = $usersQueryBuilder->orderBy('transactions_count', 'desc')
            ->orderBy('fullname', 'asc')
            ->paginate(10);

        return view('admin.consumer.index', [
            'userTransactions' => $userTransactions,
            'searchQuery' => $query
        ]);
    }
}
