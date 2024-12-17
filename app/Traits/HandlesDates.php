<?php


namespace App\Traits;

use Carbon\Carbon;

/**
 * Livewire Page with Tabs
 */
trait HandlesDates {


    public static function isGreaterThan(string $date, string|null $dateToCompare): bool {

        $date_ = Carbon::parse($date);
        $compare_dt_ = Carbon::parse($dateToCompare);

        if ($date_->greaterThan($compare_dt_)) { // new retek code
            // $date1 is greater than $date2
            return true;
        } elseif ($date_->lessThan($compare_dt_)) { // old retek code
            // $date1 is less than $date2
            return false;
        } else {
            // $date1 is equal to $date2
            return true;
        }
    }


    public static function parseRelativeDate($dateString) {
        $now = \Illuminate\Support\Carbon::now();

        switch (strtolower($dateString)) {
            case 'yesterday':
                return $now->subDay();
            case 'thisweek':
                return $now->startOfWeek();
            case 'lastweek':
                return $now->subWeek()->startOfWeek();
            case 'thismonth':
                return $now->startOfMonth();
            case 'lastmonth':
                return $now->subMonth()->startOfMonth();
            case 'thisyear':
                return $now->startOfYear();
            case 'sixmonths':
                return $now->addMonths(6)->format('d_m_Y');
            default:
                return Carbon::parse($dateString);
        }
    }




}