<?php

namespace App\Observers;

use App\Models\Vendor;
use Illuminate\Support\Facades\Cache;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     */
    public function created(Vendor $vendor): void
    {
        //
        Cache::forget('vendors_list');
    }

    /**
     * Handle the Vendor "updated" event.
     */
    public function updated(Vendor $vendor): void
    {
        //
        Cache::forget('vendors_list');
        if ($vendor->wasChanged('email')) {
        }
    }

    /**
     * Handle the Vendor "deleted" event.
     */
    public function deleted(Vendor $vendor): void
    {
        //
        Cache::forget('vendors_list');
    }

    /**
     * Handle the Vendor "restored" event.
     */
    public function restored(Vendor $vendor): void
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     */
    public function forceDeleted(Vendor $vendor): void
    {
        //
    }
}
