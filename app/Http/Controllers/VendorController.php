<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorFormRequest;
use App\Http\Resources\VendorResource;
use App\Services\VendorService;
use App\Models\Vendor;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    //
    public function __construct(
        protected VendorService $vendorService
    ) {}
    public function index(Request $request): Response
    {
        // Cache::forget('vendors_list');
        // $vendors = Cache::remember('vendors_list', 3600, function () {
        //     return Vendor::latest()->paginate(10)->withQueryString();
        // });
        // $vendors = Vendor::latest()->paginate(10)->withQueryString();

        $search = $request->search;

        // $vendors = Vendor::when($search, function ($query, $search) {
        //     $query->where('name', 'like', "%{$search}%");
        // })
        //     ->latest()
        //     ->orderBy('id','desc')
        //     ->paginate(10)
        //     ->withQueryString();
        $perPage = $request->offset ?? 10;
        $vendors = $this->vendorService->fetchData($search, $perPage);

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

        $vendor = new VendorResource($vendor)->toArray($request);
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
        DB::beginTransaction();
        try {
            $this->vendorService->create($request->toData());
            DB::commit();
            return Redirect::route('vendor.list')
                ->with('success', 'Vendor created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()
                ->withInput()
                ->with('error', 'Something went wrong while creating vendor');
        }
    }

    public function update(Vendor $vendor, VendorFormRequest $request)
    {

        $short = "Something went wrong while creating vendor";
        DB::beginTransaction();
        try {
            $vendor = Vendor::where('id', $vendor->id)
                ->lock('FOR UPDATE NOWAIT')
                ->first();
            $vendor->touch();
            $this->vendorService->update($vendor, $request->toData());
            DB::commit();
            return Redirect::route('vendor.list')
                ->with('success', 'Vendor updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            if (app()->environment('local')) {
                $short = Str::limit($e->getMessage(), 100, '...');
            }
            return Redirect::back()
                ->withInput()
                ->with('error', $short);
        }
    }
}
