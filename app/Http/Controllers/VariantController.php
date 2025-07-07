<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants;
        return view('product.variants.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        return view('product.variants.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:255',
            'product_title' => 'required|string|max:255',
            'product_picture' => 'nullable|image',
            'series' => 'nullable|string|max:255',
            'shape' => 'nullable|string|max:255',
            'spray' => 'nullable|string|max:255',
            'product_description' => 'nullable|string',
            'product_color_code' => 'nullable|string|max:255',
            'product_feature' => 'nullable|string',
            'product_installation_service_parts' => 'nullable|string',
            'design_files' => 'nullable|file',
            'additional_information' => 'nullable|string'
        ]);

        if ($request->hasFile('product_picture')) {
            $validated['product_picture'] = $request->file('product_picture')->store('product_pictures', 'public');
        }

        if ($request->hasFile('design_files')) {
            $validated['design_files'] = $request->file('design_files')->store('design_files', 'public');
        }

        $validated['product_id'] = $product->id;

        ProductVariant::create($validated);

        return redirect()->route('products.variants.index', $product)->with('success', 'Variant created successfully.');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        return view('product.variants.edit', compact('product', 'variant'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $validated = $request->validate([
            'product_code' => 'required|string|max:255',
            'product_title' => 'required|string|max:255',
            'product_picture' => 'nullable|image',
            'series' => 'nullable|string|max:255',
            'shape' => 'nullable|string|max:255',
            'spray' => 'nullable|string|max:255',
            'product_description' => 'nullable|string',
            'product_color_code' => 'nullable|string|max:255',
            'product_feature' => 'nullable|string',
            'product_installation_service_parts' => 'nullable|string',
            'design_files' => 'nullable|file',
            'additional_information' => 'nullable|string'
        ]);

        if ($request->hasFile('product_picture')) {
            Storage::disk('public')->delete($variant->product_picture);
            $validated['product_picture'] = $request->file('product_picture')->store('product_pictures', 'public');
        }

        if ($request->hasFile('design_files')) {
            Storage::disk('public')->delete($variant->design_files);
            $validated['design_files'] = $request->file('design_files')->store('design_files', 'public');
        }

        $variant->update($validated);

        return redirect()->route('products.variants.index', $product)->with('success', 'Variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        if ($variant->product_picture) {
            Storage::disk('public')->delete($variant->product_picture);
        }

        if ($variant->design_files) {
            Storage::disk('public')->delete($variant->design_files);
        }

        $variant->delete();

        return redirect()->route('products.variants.index', $product)->with('success', 'Variant deleted successfully.');
    }
}
