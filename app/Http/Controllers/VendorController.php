<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorFormRequest;
use App\Models\Vendor;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

class VendorController extends Controller
{
    //
    public function index(Request $request): Response
    {
        // Cache::forget('vendors_list');
        // $vendors = Cache::remember('vendors_list', 3600, function () {
        //     return Vendor::latest()->paginate(10)->withQueryString();
        // });
        // $vendors = Vendor::latest()->paginate(10)->withQueryString();

        $search = $request->search;

        $vendors = Vendor::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Vendor/List', [
            'vendors' => $vendors,
            'filters' => [
                'search' => $search
            ]
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

    public function store(VendorFormRequest $request): RedirectResponse
    {

        Vendor::create($request->validated());
        return Redirect::route('vendor.list');
    }

    public function update(Vendor $vendor, VendorFormRequest $request)
    {

        $vendor->update($request->validated());
        return Redirect::route('vendor.list');
    }
}
