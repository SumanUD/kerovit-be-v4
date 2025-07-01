<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CataloguePage;
use App\Models\CatalogueCategory;
use Illuminate\Support\Facades\Storage;

class CataloguePageController extends Controller
{
    public function index()
    {
        $catalogue = CataloguePage::with('categories')->first();

        if (!$catalogue) {
            $catalogue = CataloguePage::create(['description' => '']);
        }

        return view('admin.catalogue.index', compact('catalogue'));
    }

public function update(Request $request)
{
    $request->validate([
        'description' => 'required',
        'categories' => 'required|array',
        'categories.*.title' => 'required|string|max:255',
        'categories.*.thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'categories.*.pdf_link' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $catalogue = CataloguePage::firstOrFail();
    $catalogue->update(['description' => $request->description]);

    $existingCategoryIds = [];

    foreach ($request->categories as $index => $data) {
        $category = null;

        // Check if existing category id is provided
        if (!empty($data['id'])) {
            $category = CatalogueCategory::find($data['id']);
        }

        if (!$category) {
            $category = new CatalogueCategory();
            $category->catalogue_page_id = $catalogue->id;
        }

        $category->title = $data['title'];

        // Image upload only if new file provided
        if (isset($data['thumbnail_image'])) {
            $category->thumbnail_image = $data['thumbnail_image']->store('catalogue/thumbnails', 'public');
        }

        if (isset($data['pdf_link'])) {
            $category->pdf_link = $data['pdf_link']->store('catalogue/pdfs', 'public');
        }

        $category->save();
        $existingCategoryIds[] = $category->id;
    }

    // Delete categories not in current request
    $catalogue->categories()->whereNotIn('id', $existingCategoryIds)->delete();

    return redirect()->back()->with('success', 'Catalogue page updated successfully!');
}

public function getCataData()
{
    $catalogue = CataloguePage::with('categories')->first();

    return response()->json([
        'success' => true,
        'data' => [
            'description' => $catalogue->description,
            'categories' => $catalogue->categories->map(function ($cat) {
                return [
                    'title' => $cat->title,
                    'thumbnail_image' => asset('storage/' . $cat->thumbnail_image),
                    'pdf_link' => asset('storage/' . $cat->pdf_link),
                ];
            })
        ]
    ]);
}


}
