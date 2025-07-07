<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DealerController extends Controller
{
    /**
     * Display a listing of the dealers.
     */
// DealerController.php


public function index(Request $request)
{
    if ($request->ajax()) {
        $dealers = Dealer::select(['id', 'dealername', 'pincode', 'city', 'phone', 'contactperson']);

        return DataTables::of($dealers)
            ->addColumn('actions', function ($dealer) {
                return '<a href="' . route('dealers.edit', $dealer->id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('dealers.destroy', $dealer->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('admin.dealers.index');
}


    /**
     * Show the form for creating a new dealer.
     */
    public function create()
    {
        return view('admin.dealers.create');
    }

    /**
     * Store a newly created dealer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dealercode' => 'required|string|max:255',
            'dealername' => 'required|string|max:150',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:150',
            'state' => 'required|string|max:150',
            'pincode' => 'required|string|max:25',
            'phone' => 'required|string|digits:10',
            'fax' => 'required|string|max:50',
            'contactnumber' => 'required|string|digits:10',
            'contactperson' => 'required|string|max:200',
            'dealertype' => 'required|string|max:100',
            'google_link' => 'required|string|max:10000',
            'date_of_updation' => 'required|date',
        ]);

        Dealer::create($request->all());

        return redirect()->route('dealers.index')->with('success', 'Dealer created successfully.');
    }


    /**
     * Show the form for editing the specified dealer.
     */
    public function edit(Dealer $dealer)
    {
        return view('admin.dealers.edit', compact('dealer'));
    }

    /**
     * Update the specified dealer in storage.
     */
public function update(Request $request, Dealer $dealer)
{
    $request->validate([
        'dealercode' => 'required|string|max:255',
        'dealername' => 'required|string|max:150',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:150',
        'state' => 'required|string|max:150',
        'pincode' => 'required|string|max:25',
        'phone' => 'required|string|digits:10',
        'fax' => 'required|string|max:50',
        'contactnumber' => 'required|string|max:200',
        'contactperson' => 'required|string',
        'dealertype' => 'required|string|max:100',
        'google_link' => 'required|string|max:10000',
        'date_of_updation' => 'nullable|date',
    ]);

    // Ensure date_of_updation is updated
    $dealer->update($request->all());
    return redirect()->route('dealers.index')->with('success', 'Dealer updated successfully.');
}

    /**
     * Remove the specified dealer from storage.
     */
    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->route('dealers.index')->with('success', 'Dealer deleted successfully.');
    }
    
    public function apiIndex()
    {
        $dealers = Dealer::select([
            'id',
            'dealercode',
            'dealername',
            'address',
            'city',
            'state',
            'pincode',
            'phone',
            'fax',
            'contactnumber',
            'contactperson',
            'dealertype',
            'google_link',
            'date_of_updation'
        ])->orderBy('dealername')->get();
    
        return response()->json([
            'success' => true,
            'data' => $dealers
        ]);
    }

}
