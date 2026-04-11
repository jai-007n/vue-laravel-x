<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class VendorData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $mobile = null,
        public ?string $address = null

    ) {}
}
