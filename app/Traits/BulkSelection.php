<?php


namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Livewire Page with Tabs
 */
trait BulkSelection {

    public function emitSelection() {
        return false;
    }
}