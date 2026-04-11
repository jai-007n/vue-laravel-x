<?php

namespace App\Repositories\DataInterface;

use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VendorRepositoryInterface
{
    public function create(array $data): Vendor;

    public function fetchData(?string $search,int $perPage = 10): LengthAwarePaginator;
}
