<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VendorController extends Controller
{
    //
    public function index(Request $request): Response
    {
        return Inertia::render('Vendor/List', [
            'vendors' => Vendor::all()
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Vendor/Create', ['vendor' => false]);
    }

    public function edit(Request $request, Vendor $vendor): Response
    {
        return Inertia::render('Vendor/Create', ['vendor' => $vendor, 'edit' => true]);
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();
        return Redirect::route('vendor.list');
    }

    public function list() {}

    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'nullable|max:100|unique:vendors',
            'mobile' => 'sometimes|nullable|max:13',
             'address' => 'sometimes|nullable|max:255',
        ]);

        Vendor::create($data);

        return Redirect::route('vendor.list');
    }

    public function update(Vendor $vendor, Request $request)
    {

        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'nullable|max:100|unique:vendors,email,' . $vendor->id,
            'mobile' => 'sometimes|nullable|max:13',
            'address' => 'sometimes|nullable|max:255',
        ]);

        $vendor->update($data);
        return Redirect::route('vendor.list');
    }
}
