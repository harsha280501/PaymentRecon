<?php


namespace App\Traits;

use App\Models\Masters\Remarks;

/**
 * Livewire Page with Tabs
 */
trait UseRemarks {

    public static function remarks(string $type): array {
        return Remarks::where('roleUID', auth()->user()->roleUID)
            ->where('remarkType', $type)
            ->pluck('remarks')
            ->toArray();
    }

}