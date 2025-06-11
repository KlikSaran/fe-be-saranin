<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();

            return response()->json([
                'message' => 'Data produk berhasil diambil.',
                'data'    => $products,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data produk.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'        => 'required|string|max:255',
                'category'    => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'required|numeric|min:0',
            ]);

            $product = Product::create($validatedData);

            return response()->json([
                'message' => 'Produk berhasil dibuat.',
                'data'    => $product,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data yang diberikan tidak valid.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                'message' => "Data detail produk dengan ID: {$id} berhasil ditemukan.",
                'data'    => $product,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Produk dengan ID: {$id} tidak ditemukan.",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validate([
                'name'        => 'required|string|max:255',
                'category'    => 'required|string|max:255',
                'description' => 'nullable|string',
                'price'       => 'required|numeric|min:0',
            ]);

            $product->update($validatedData);

            return response()->json([
                'message' => "Produk dengan ID: {$id} berhasil diperbarui.",
                'data'    => $product,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Produk dengan ID: {$id} tidak ditemukan."
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data yang diberikan tidak valid.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $productDeleted = $product->delete();

            return response()->json([
                'message' => "Produk dengan ID: {$id}, berhasil dihapus.",
                'data' => $productDeleted,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Produk dengan ID: {$id} tidak ditemukan."
            ], 404);
        }
    }
}
