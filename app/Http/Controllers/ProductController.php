<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Range;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Range $range)
    {
        $products = $range->products()->with(['category', 'collection'])->get();
        return view('product.products.index', compact('range', 'products'));
    }

    public function create(Range $range)
    {
        $collection = $range->collection;
        $category = $range->category;
        return view('product.products.create', compact('range', 'collection', 'category'));
    }

    public function store(Request $request, Range $range)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code',
            'product_title' => 'required|string|max:255',
            'product_picture' => 'nullable|image',
            'series' => 'nullable|string',
            'shape' => 'nullable|string',
            'spray' => 'nullable|string',
            'product_description' => 'nullable|string',
            'product_color_code' => 'nullable|string',
            'product_feature' => 'nullable|string',
            'product_installation_service_parts' => 'nullable|string',
            'design_files' => 'nullable|file',
            'additional_information' => 'nullable|string',
        ]);

        if ($request->hasFile('product_picture')) {
            $validated['product_picture'] = $request->file('product_picture')->store('product_pictures', 'public');
        }

        if ($request->hasFile('design_files')) {
            $validated['design_files'] = $request->file('design_files')->store('design_files', 'public');
        }

        $validated['range_id'] = $range->id;
        $validated['category_id'] = $range->category_id;
        $validated['collection_id'] = $range->collection_id;
        $validated['order'] = Product::where('range_id', $range->id)->max('order') + 1;

        Product::create($validated);

        return redirect()->route('ranges.products.index', $range->id)->with('success', 'Product created successfully.');
    }

    public function edit(Range $range, Product $product)
    {
        if ($product->range_id !== $range->id) {
            abort(404);
        }

        $collection = $range->collection;
        $category = $range->category;

        return view('product.products.edit', compact('range', 'product', 'collection', 'category'));
    }

    public function update(Request $request, Range $range, Product $product)
    {
        if ($product->range_id !== $range->id) {
            abort(404);
        }

        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'product_title' => 'required|string|max:255',
            'product_picture' => 'nullable|image',
            'series' => 'nullable|string',
            'shape' => 'nullable|string',
            'spray' => 'nullable|string',
            'product_description' => 'nullable|string',
            'product_color_code' => 'nullable|string',
            'product_feature' => 'nullable|string',
            'product_installation_service_parts' => 'nullable|string',
            'design_files' => 'nullable|file',
            'additional_information' => 'nullable|string',
        ]);

        if ($request->hasFile('product_picture')) {
            $validated['product_picture'] = $request->file('product_picture')->store('product_pictures', 'public');
        }

        if ($request->hasFile('design_files')) {
            $validated['design_files'] = $request->file('design_files')->store('design_files', 'public');
        }

        $product->update($validated);

        return redirect()->route('ranges.products.index', $range->id)->with('success', 'Product updated successfully.');
    }

    public function destroy(Range $range, Product $product)
    {
        if ($product->range_id !== $range->id) {
            abort(404);
        }

        $product->delete();

        return redirect()->route('ranges.products.index', $range->id)->with('success', 'Product deleted successfully.');
    }

    public function reorder(Request $request, Range $range)
    {
        $order = $request->input('order');
        foreach ($order as $index => $productId) {
            Product::where('id', $productId)
                ->where('range_id', $range->id)
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }



public function getProductsByRange(Range $range)
{
    $products = $range->products()
        ->with(['variants'])
        ->orderBy('order')
        ->get();

    $formatted = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'collection_id' => $product->collection_id,
            'category_id' => $product->category_id,
            'range_id' => $product->range_id,
            'order' => $product->order,
            'product_code' => $product->product_code,
            'product_picture' => $product->product_picture ? asset('storage/' . $product->product_picture) : null,
            'product_title' => $product->product_title,
            'series' => $product->series,
            'shape' => $product->shape,
            'spray' => $product->spray,
            'product_description' => $product->product_description,
            'product_color_code' => $product->product_color_code,
            'product_feature' => $product->product_feature,
            'product_installation_service_parts' => $product->product_installation_service_parts,
            'design_files' => $product->design_files ? asset('storage/' . $product->design_files) : null,
            'additional_information' => $product->additional_information,
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'product_code' => $variant->product_code,
                    'product_picture' => $variant->product_picture ? asset('storage/' . $variant->product_picture) : null,
                    'product_title' => $variant->product_title,
                    'series' => $variant->series,
                    'shape' => $variant->shape,
                    'spray' => $variant->spray,
                    'product_description' => $variant->product_description,
                    'product_color_code' => $variant->product_color_code,
                    'product_feature' => $variant->product_feature,
                    'product_installation_service_parts' => $variant->product_installation_service_parts,
                    'design_files' => $variant->design_files ? asset('storage/' . $variant->design_files) : null,
                    'additional_information' => $variant->additional_information,
                ];
            })
        ];
    });

    return response()->json([
        'status' => true,
        'range' => [
            'id' => $range->id,
            'name' => $range->name,
            'description' => $range->description,
            'products' => $formatted
        ]
    ]);
}

}
