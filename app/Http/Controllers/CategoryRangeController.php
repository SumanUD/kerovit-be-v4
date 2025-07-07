<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Range;
use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Str;


class CategoryRangeController extends Controller
{
    public function index(Category $category)
    {
        $ranges = $category->ranges()->orderBy('order')->get();
        return view('product.ranges.index', compact('category', 'ranges'));
    }
    public function reorder(Request $request, Category $category)
    {
        $order = $request->input('order');
        foreach ($order as $index => $rangeId) {
            Range::where('id', $rangeId)
                ->where('category_id', $category->id) // scoped correctly
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
    public function create(Category $category)
    {
        $collection = $category->collection; // assumes Category belongsTo Collection
        return view('product.ranges.create', compact('category', 'collection'));
    }

    public function store(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:ranges,slug',
            'thumnbnail_image' => 'required|image',
            'description' => 'nullable|string',
            'collection_id' => 'required|exists:collections,id'
        ]);

        if ($request->hasFile('thumnbnail_image')) {
            $validated['thumnbnail_image'] = $request->file('thumnbnail_image')->store('range', 'public');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['category_id'] = $category->id;
        $validated['order'] = Range::where('category_id', $category->id)->max('order') + 1;

        Range::create($validated);

        return redirect()->route('categories.ranges.index', $category)->with('success', 'Range created successfully.');
    }

    public function edit(Category $category, Range $range)
    {
        // Ensure the range belongs to the category
        if ($range->category_id !== $category->id) {
            abort(404);
        }

        $collections = Collection::all();
        return view('product.ranges.edit', compact('category', 'range', 'collections'));
    }

    public function update(Request $request, Category $category, Range $range)
    {
        if ($range->category_id !== $category->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:ranges,slug,' . $range->id,
            'thumnbnail_image' => 'required|image',
            'description' => 'nullable|string',
            'collection_id' => 'required|exists:collections,id'
        ]);

        if ($request->hasFile('thumnbnail_image')) {
            $validated['thumnbnail_image'] = $request->file('thumnbnail_image')->store('range', 'public');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $range->update($validated);

        return redirect()->route('categories.ranges.index', $category->id)->with('success', 'Range updated successfully.');
    }

    public function getRanges()
    {
        $collections = Collection::with([
            'categories.ranges' => function ($query) {
                $query->orderBy('order');
            },
            'categories.ranges.products' => function ($query) {
                $query->orderBy('order');
            },
            'categories.ranges.products.variants'
        ])->get();

        return response()->json([
            'status' => true,
            'data' => $collections->map(function ($collection) {
                return [
                    'id' => $collection->id,
                    'name' => $collection->name,
                    'categories' => $collection->categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'ranges' => $category->ranges->map(function ($range) {
                                return [
                                    'id' => $range->id,
                                    'name' => $range->name,
                                    'description' => $range->description,
                                    'thumbnail' => $range->thumnbnail_image ? asset('storage/' . $range->thumnbnail_image) : null,
                                ];
                            })
                        ];
                    })
                ];
            })
        ]);
    }

}
