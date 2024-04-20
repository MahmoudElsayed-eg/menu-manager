<?php

namespace App\Listeners;

use App\Events\TableStatusChanged;
use App\Models\Zone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateZone
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TableStatusChanged $event): void
    {
        $zones = Zone::orderBy('position', 'asc')->get();
        $zones->load('tables');
    }
}
