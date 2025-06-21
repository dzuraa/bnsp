<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'created_at'); // default: created_at
        $direction = $request->get('direction', 'desc'); // default: descending

        // Validate sort and direction
        $allowedSorts = ['id', 'product_name', 'description', 'created_at', 'updated_at', 'price', 'stock']; // tambahkan kolom sesuai tabel
        $allowedDirections = ['asc', 'desc'];

        if (in_array($sort, $allowedSorts) && in_array($direction, $allowedDirections)) {
            $query->orderBy($sort, $direction);
        }

        // Paginate
        $products = $query->paginate(3)->withQueryString();

        return view('products.index', compact('products', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Draft,Active,Inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('product_image')) {
            $data['product_image'] = $request->file('product_image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Draft,Active,Inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('product_image')) {
            $data['product_image'] = $request->file('product_image')->store('products', 'public');
        }


        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
