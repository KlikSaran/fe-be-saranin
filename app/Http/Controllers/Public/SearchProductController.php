<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SearchProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id) {}

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
        $categoryInput = $request->input('category');

        $productsQuery = Product::query();

        if ($query) {
            $productsQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($categoryInput) {
            $productsQuery->where('category', 'LIKE', "%{$categoryInput}%");
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());

        $displayedCategoryName = $categoryInput ?: 'Semua Kategori';

        $allUniqueCategories = Product::select('category')->distinct()->orderBy('category')->get();
        $categories = Product::select('category')->distinct()->get();

        return view('public.product.search', [
            'products' => $products,
            'searchQuery' => $query,
            'allCategories' => $allUniqueCategories,
            'currentCategoryName' => $displayedCategoryName,
            'categories' => $categories
        ]);
    }
}
