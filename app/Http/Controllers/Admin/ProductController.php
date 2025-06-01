<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);

        if ($products->isEmpty()) {
            return redirect()->route('products.create')->with('productAlert', 'Silakan tambahkan produk baru.');
        }

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::latest()->get();
        return view('admin.product.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|string|min:0',
            'stock' => 'nullable|in:True,False',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'category.required' => 'Category is required.',
            'category.string' => 'Category must be a string.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price cannot be negative.',
            'descripton.string' => 'Description must be a string.',
            'image.required' => 'Image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Image size must not exceed 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $cleanedOriginalName = Str::slug($originalFilename, '_');
            $filenameToStore = $cleanedOriginalName . '.' . $extension;
            $counter = 1;

            while (Storage::disk('public')->exists('images/' . $filenameToStore)) {
                $filenameToStore = $cleanedOriginalName . '_' . $counter . '.' . $extension;
                $counter++;
            }
            $imagePath = $file->storeAs('images', $filenameToStore, 'public');
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        session()->flash('productSuccessAlert', "Data produk berhasil ditambahkan.");

        return redirect()->route('products.index')->with('productSuccessAlert', 'Data produk berhasil ditambahkan.');
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
    public function update(Request $request, Product $products)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|string|min:0',
            'stock' => 'nullable|in:True,False',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'category.required' => 'Category is required.',
            'category.string' => 'Category must be a string.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price cannot be negative.',
            'description.string' => 'Description must be a string.',
            'image.required' => 'Image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Image size must not exceed 2MB.',
        ]);

        $imagePath = $products->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $cleanedOriginalName = Str::slug($originalFilename, '_');
            $filenameToStore = $cleanedOriginalName . '.' . $extension;
            $counter = 1;

            while (Storage::disk('public')->exists('images/' . $filenameToStore)) {
                $filenameToStore = $cleanedOriginalName . '_' . $counter . '.' . $extension;
                $counter++;
            }

            $imagePath = $file->storeAs('images', $filenameToStore, 'public');
        }

        $products->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('productUpdateSuccessAlert', 'Data produk berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('productDeleteSuccessAlert', 'Produk berhasil dihapus.');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.product.index', [
            'products' => $products,
            'searchQuery' => $query
        ]);
    }
}
