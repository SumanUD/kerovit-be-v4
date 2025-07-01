<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerCarePage;

class CustomerCarePageController extends Controller
{
    public function edit()
    {
        $care = CustomerCarePage::first();

        if (!$care) {
            $care = CustomerCarePage::create(); // Create empty default row
        }

        return view('admin.customer-care.edit', compact('care'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
            'below_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10000',
            'service_query_email' => 'required|email',
            'info_email' => 'required|email',
            'call_number' => 'required|string|max:20',
            'tollfree_number' => 'required|string|max:20',
            'whatsapp_chat' => 'required|url',
        ]);

        $care = CustomerCarePage::first();

        if ($request->hasFile('banner_image')) {
            $care->banner_image = $request->file('banner_image')->store('customer-care/banner', 'public');
        }

        if ($request->hasFile('below_banner_image')) {
            $care->below_banner_image = $request->file('below_banner_image')->store('customer-care/below-banner', 'public');
        }

        $care->service_query_email = $request->service_query_email;
        $care->info_email = $request->info_email;
        $care->call_number = $request->call_number;
        $care->tollfree_number = $request->tollfree_number;
        $care->whatsapp_chat = $request->whatsapp_chat;

        $care->save();

        return redirect()->back()->with('success', 'Customer Care page updated successfully!');
    }

    public function getCustomerData()
    {
        $data = CustomerCarePage::first();

        return response()->json([
            'success' => true,
            'data' => [
                'banner_image' => asset('storage/' . $data->banner_image),
                'below_banner_image' => asset('storage/' . $data->below_banner_image),
                'emails' => [
                    'service_query' => $data->service_query_email,
                    'info_email' => $data->info_email,
                ],
                'customer_care' => [
                    'call' => $data->call_number,
                    'toll_free' => $data->toll_free_number,
                    'whatsapp' => $data->whatsapp_link,
                ]
            ]
        ]);
    }

}
