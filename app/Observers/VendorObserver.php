<?php

namespace App\Observers;

use App\Events\SendVendorEmailEvent;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     */
    public function created(Vendor $vendor): void
    {
        event(new SendVendorEmailEvent($vendor));
        Log::info('Vendor event created dispatched!');
    }

    /**
     * Handle the Vendor "updated" event.
     */
    public function updated(Vendor $vendor): void
    {
        //Cache::forget('vendors_list');
        if ($vendor->wasChanged('email')) {
            event(new SendVendorEmailEvent($vendor));
            Log::info('Vendor udapted event dispatched!');
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
