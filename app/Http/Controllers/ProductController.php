<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSortBy = ['name', 'description', 'price', 'stock'];

        if (in_array($sortBy, $allowedSortBy) && in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products', 'sortBy', 'sortDirection'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function exportPdf()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('products.pdf', compact('products'));
        return $pdf->download('products.pdf');
    }
}
