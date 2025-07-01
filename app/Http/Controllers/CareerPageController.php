<?php

// app/Http/Controllers/CareerPageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerPage;

class CareerPageController extends Controller
{
    public function edit()
    {
        $career = CareerPage::firstOrCreate([]);
        return view('admin.career.edit', compact('career'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
            'banner_description' => 'required|string',
            'below_banner_description' => 'required|string',
            'below_description_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
            'apply_link' => 'nullable|url',
        ]);

        $career = CareerPage::first();

        if ($request->hasFile('banner_image')) {
            $career->banner_image = $request->file('banner_image')->store('career/banner', 'public');
        }

        if ($request->hasFile('below_description_image')) {
            $career->below_description_image = $request->file('below_description_image')->store('career/below', 'public');
        }

        $career->banner_description = $request->banner_description;
        $career->below_banner_description = $request->below_banner_description;
        $career->apply_link = $request->apply_link;
        $career->save();

        return redirect()->back()->with('success', 'Career page updated successfully!');
    }

    public function getCareerData()
{
    $career = CareerPage::first();

    return response()->json([
        'success' => true,
        'data' => [
            'banner_image' => asset('storage/' . $career->banner_image),
            'banner_description' => $career->banner_description,
            'below_description' => $career->below_description,
            'below_image' => asset('storage/' . $career->below_image),
            'apply_link' => $career->apply_link
        ]
    ]);
}

}
