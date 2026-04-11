<?php

namespace App\Repositories;

use App\Repositories\DataInterface\VendorRepositoryInterface;
use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VendorRepository implements VendorRepositoryInterface
{
    public function create(array $data): Vendor
    {
        return Vendor::create($data);
    }

    public function fetchData(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Vendor::searchName($search)
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }
}
