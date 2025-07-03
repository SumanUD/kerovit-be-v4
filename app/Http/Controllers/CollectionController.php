<?php
// app/Http/Controllers/CollectionController.php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index() {
        $collections = Collection::latest()->paginate(10);
        return view('product.collections.index', compact('collections'));
    }

    public function create() {
        return view('product.collections.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|max:10048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        $data = $request->except('thumbnail_image');
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('collections', 'public');
        }

        Collection::create($data);

        return redirect()->route('collections.index')->with('success', 'Collection created successfully.');
    }

    public function edit(Collection $collection) {
        return view('product.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection) {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug,' . $collection->id,
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $data = $request->except('thumbnail_image');
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('collections', 'public');
        }

        $collection->update($data);

        return redirect()->route('collections.index')->with('success', 'Collection updated successfully.');
    }

    public function destroy(Collection $collection) {
        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted successfully.');
    }
}
