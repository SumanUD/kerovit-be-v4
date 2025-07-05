<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function manage(Blog $blog = null)
    {
        return view('admin.blogs.manage', compact('blog'));
    }

    public function storeOrUpdate(Request $request, Blog $blog = null)
    {
        $request->merge([
        'is_popular' => $request->has('is_popular')
    ]);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'banner_image' => $blog ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'published_date' => 'required|date',
            // 'is_popular' => 'required',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($blog && $blog->banner_image && Storage::disk('public')->exists($blog->banner_image)) {
                Storage::disk('public')->delete($blog->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('blog_banners', 'public');
        }

        if ($blog) {
            $blog->update($validated);
            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
        } else {
            Blog::create($validated);
            return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
        }
    }

    public function destroy(Blog $blog)
    {
        if ($blog->banner_image && Storage::disk('public')->exists($blog->banner_image)) {
            Storage::disk('public')->delete($blog->banner_image);
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function apiIndex(): JsonResponse
    {
        $blogs = Blog::latest()->get()->map(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'banner_image' => $blog->banner_image ? asset('storage/' . $blog->banner_image) : null,
                'published_date' => $blog->published_date->format('Y-m-d'),
                'is_popular' => (bool) $blog->is_popular,
                'description' => $blog->description,
                'meta_title' => $blog->meta_title,
                'meta_description' => $blog->meta_description,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $blogs
        ]);
    }

}
