<?php

namespace App\Http\Controllers;

use App\Models\AboutUsPage;
use App\Models\ManufacturingPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsPageController extends Controller
{
    public function index()
    {
        $about = AboutUsPage::firstOrCreate([]);
        $about->load('plants');
        return view('admin.about.index', compact('about'));
    }

public function update(Request $request)
{
    $request->validate([
        'banner_video' => 'nullable|file|mimes:mp4,webm|max:70480',
        'below_banner_description' => 'required|string',
        'director_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
        'director_description' => 'required|string',
        'certification_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
        'plants' => 'required|array',
        'plants.*.plant_title' => 'required|string|max:255',
        'plants.*.plant_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
        'plants.*.plant_description' => 'required|string',
    ]);

    $about = AboutUsPage::first();

    // Handle banner video
    if ($request->hasFile('banner_video')) {
        $about->banner_video = $request->file('banner_video')->store('about/banner', 'public');
    }

    // Handle director image
    if ($request->hasFile('director_image')) {
        $about->director_image = $request->file('director_image')->store('about/director', 'public');
    }

    // Handle multiple certification images
    $certificationImages = [];
    if ($request->hasFile('certification_images')) {
        foreach ($request->file('certification_images') as $file) {
            $certificationImages[] = $file->store('about/certifications', 'public');
        }
        $about->certification_images = $certificationImages;
    }

    // Save other fields
    $about->below_banner_description = $request->below_banner_description;
    $about->director_description = $request->director_description;
    $about->save();

    // Update manufacturing plants
    $existingIds = [];
    foreach ($request->plants as $index => $data) {
        $plant = null;

        if (!empty($data['id'])) {
            $plant = ManufacturingPlant::find($data['id']);
        }

        if (!$plant) {
            $plant = new ManufacturingPlant();
            $plant->about_us_page_id = $about->id;
        }

        $plant->plant_title = $data['plant_title'];
        $plant->plant_description = $data['plant_description'];

        if (isset($data['plant_image']) && $data['plant_image'] instanceof \Illuminate\Http\UploadedFile) {
            $plant->plant_image = $data['plant_image']->store('about/plants', 'public');
        }

        $plant->save();
        $existingIds[] = $plant->id;
    }

    // Delete removed plants
    $about->plants()->whereNotIn('id', $existingIds)->delete();

    return redirect()->back()->with('success', 'About Us page updated successfully!');
}

public function getAboutData()
{
    $about = AboutUsPage::with('plants')->first();

    return response()->json([
        'success' => true,
        'data' => [
            'banner_video' => asset('storage/' . $about->banner_video),
            'below_banner_description' => $about->below_banner_description,
            'director_image' => asset('storage/' . $about->director_image),
            'director_description' => $about->director_description,
            'certification_images' => collect($about->certification_images)->map(fn($img) => asset('storage/' . $img)),
            'plants' => $about->plants->map(fn($p) => [
                'title' => $p->plant_title,
                'image' => asset('storage/' . $p->plant_image),
                'description' => $p->plant_description
            ])
        ]
    ]);
}


}
