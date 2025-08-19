<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePageSection;
use Illuminate\Support\Facades\Storage;


class HomePageSectionController extends Controller
{
    public function edit()
    {
        $section = HomePageSection::firstOrCreate([]);
        return view('admin.homepage.edit', compact('section'));
    }

    public function update(Request $request)
    {

        $request->validate([
                    // SECTION 1: Banner Videos
                    'banner_videos.*' => 'nullable|mimes:mp4,webm,mov,avi|max:51200',

                    // SECTION 2: Categories
                    'categories_description' => 'required|string|max:2000',

                    'category_faucet_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'category_showers_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'category_basin_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'category_toilet_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'category_furniture_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'category_accessories_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',

                    // SECTION 3: Collections
                    'collections_description' => 'required|string|max:2000',
                    'aurum_description' => 'required|string|max:2000',
                    'aurum_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'klassic_description' => 'required|string|max:2000',
                    'klassic_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',

                    // SECTION 4: Locate Our Store
                    'store_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                    'store_header' => 'required|string|max:255',
                    'store_description' => 'required|string|max:2000',

                    // SECTION 5: Homepage About Us
                    'about_banner_video' => 'nullable|mimes:mp4,webm,mov,avi|max:51200',
                    'about_description' => 'required|string|max:2000',
                ]);

        $section = HomePageSection::first();

        $data = $request->except('_token');

        // Upload Banner Videos (Multiple)
        if ($request->hasFile('banner_videos')) {
            $videos = [];
            foreach ($request->file('banner_videos') as $video) {
                $videos[] = $video->store('uploads/home/banner_videos', 'public');
            }
            $data['banner_videos'] = $videos;
        }

        // Upload images one by one (if changed)
        foreach ([
            'category_faucet_image', 'category_showers_image', 'category_basin_image',
            'category_toilet_image', 'category_furniture_image', 'category_accessories_image',
            'aurum_image', 'klassic_image', 'store_banner_image', 'about_banner_video'
        ] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store("uploads/home/{$field}", 'public');
            }
        }

        $section->update($data);

        return redirect()->back()->with('success', 'Homepage updated successfully.');
    }

     public function getHomeData()
    {
        $data = HomePageSection::first();

        return response()->json([
            'success' => true,
            'data' => [
                'banner_videos' => collect($data->banner_videos)->map(fn($v) => asset('storage/' . $v)),
                'categories_description' => $data->categories_description,
                'categories_images' => [
                    'faucet' => asset('storage/' . $data->category_faucet_image),
                    'showers' => asset('storage/' . $data->category_showers_image),
                    'basin' => asset('storage/' . $data->category_basin_image),
                    'toilet' => asset('storage/' . $data->category_toilet_image),
                    'furniture' => asset('storage/' . $data->category_furniture_image),
                    'accessories' => asset('storage/' . $data->category_accessories_image),
                ],
                'collections' => [
                    'description' => $data->collections_description,
                    'aurum' => [
                        'description' => $data->aurum_description,
                        'image' => asset('storage/' . $data->aurum_image),
                    ],
                    'klassic' => [
                        'description' => $data->klassic_description,
                        'image' => asset('storage/' . $data->klassic_image),
                    ]
                ],
                'store' => [
                    'banner_image' => asset('storage/' . $data->store_banner_image),
                    'header' => $data->store_header,
                    'description' => $data->store_description,
                ],
                'about_us' => [
                    'video' => asset('storage/' . $data->about_banner_video),
                    'description' => $data->about_description,
                ]
            ]
        ]);
    }
}
