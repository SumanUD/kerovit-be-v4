<?php

namespace App\Http\Controllers;

use App\Models\CataloguePage;
use App\Models\CatalogueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CataloguePageController extends Controller
{
    /**
     * Show the catalogue CMS form
     */
    public function index()
    {
        $catalogue = CataloguePage::with('categories')->first();

        if (!$catalogue) {
            $catalogue = CataloguePage::create([
                'description' => '',
                // 'meta_title' => '',
                // 'meta_description' => '',
            ]);
        }

        return view('admin.catalogue.index', compact('catalogue'));
    }

    /**
     * Update catalogue page and categories
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            // 'meta_title' => 'nullable|string|max:255',
            // 'meta_description' => 'nullable|string|max:255',

            'categories' => 'required|array',
            'categories.*.id' => 'nullable|integer|exists:catalogue_categories,id',
            'categories.*.title' => 'required|string|max:255',
            'categories.*.thumbnail_image' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:5120',
            'categories.*.pdf_link' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $catalogue = CataloguePage::firstOrFail();
        $catalogue->update([
            'description' => $validated['description'],
            // 'meta_title' => $validated['meta_title'] ?? '',
            // 'meta_description' => $validated['meta_description'] ?? '',
        ]);

        $existingCategoryIds = [];

        foreach ($validated['categories'] as $index => $data) {
            $category = isset($data['id']) 
                ? CatalogueCategory::find($data['id']) 
                : new CatalogueCategory();

            if (!$category->exists) {
                $category->catalogue_page_id = $catalogue->id;
            }

            $category->title = $data['title'];

            // Thumbnail
            if (request()->hasFile("categories.$index.thumbnail_image")) {
                if ($category->thumbnail_image && Storage::disk('public')->exists($category->thumbnail_image)) {
                    Storage::disk('public')->delete($category->thumbnail_image);
                }
                $category->thumbnail_image = request()->file("categories.$index.thumbnail_image")
                    ->store('catalogue/thumbnails', 'public');
            }

            // PDF
            if (request()->hasFile("categories.$index.pdf_link")) {
                if ($category->pdf_link && Storage::disk('public')->exists($category->pdf_link)) {
                    Storage::disk('public')->delete($category->pdf_link);
                }
                $category->pdf_link = request()->file("categories.$index.pdf_link")
                    ->store('catalogue/pdfs', 'public');
            }

            $category->save();
            $existingCategoryIds[] = $category->id;
        }

        // Delete categories that were removed
        $catalogue->categories()
            ->whereNotIn('id', $existingCategoryIds)
            ->get()
            ->each(function ($cat) {
                if ($cat->thumbnail_image && Storage::disk('public')->exists($cat->thumbnail_image)) {
                    Storage::disk('public')->delete($cat->thumbnail_image);
                }
                if ($cat->pdf_link && Storage::disk('public')->exists($cat->pdf_link)) {
                    Storage::disk('public')->delete($cat->pdf_link);
                }
                $cat->delete();
            });

        return back()->with('success', 'Catalogue page updated successfully!');
    }

    /**
     * Delete a single category
     */
    public function destroyCategory($id)
    {
        $category = CatalogueCategory::findOrFail($id);

        if ($category->thumbnail_image && Storage::disk('public')->exists($category->thumbnail_image)) {
            Storage::disk('public')->delete($category->thumbnail_image);
        }

        if ($category->pdf_link && Storage::disk('public')->exists($category->pdf_link)) {
            Storage::disk('public')->delete($category->pdf_link);
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    /**
     * API endpoint for catalogue JSON
     */
    public function getCataData()
    {
        $catalogue = CataloguePage::with('categories')->first();

        return response()->json([
            'success' => true,
            'data' => [
                'description' => $catalogue->description,
                // 'meta_title' => $catalogue->meta_title,
                // 'meta_description' => $catalogue->meta_description,
                'categories' => $catalogue->categories->map(function ($cat) {
                    return [
                        'id' => $cat->id,
                        'title' => $cat->title,
                        'thumbnail_image' => $cat->thumbnail_image ? asset('storage/' . $cat->thumbnail_image) : null,
                        'pdf_link' => $cat->pdf_link ? asset('storage/' . $cat->pdf_link) : null,
                    ];
                }),
            ]
        ]);
    }
}
