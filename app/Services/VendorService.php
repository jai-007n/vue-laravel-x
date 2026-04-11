<?php

namespace App\Services;

use App\Data\VendorData;
use App\Repositories\DataInterface\VendorRepositoryInterface;
use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VendorService
{
    public function __construct(
        protected VendorRepositoryInterface $vendorRepository
    ) {}

    public function create(VendorData $data): Vendor
    {
        return $this->vendorRepository->create($data->all());
    }

    public function fetchData($search, $perPage = 10): LengthAwarePaginator
    {
        return $this->vendorRepository->fetchData($search, $perPage);
    }
}
