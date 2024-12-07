<?php


namespace App\Traits;

use Carbon\Carbon;

/**
 * Livewire Page with Tabs
 */
trait WithExportDate {


    public function parseRelativeDate($dateString) {
        $now = Carbon::now();

        switch (strtolower($dateString)) {
            case 'yesterday':
                return $now->subDay()->format('d_m_Y');
            case 'thisweek':
                return $now->startOfWeek()->format('d_m_Y');
            case 'lastweek':
                return $now->subWeek()->startOfWeek()->format('d_m_Y');
            case 'thismonth':
                return $now->startOfMonth()->format('d_m_Y');
            case 'lastmonth':
                return $now->subMonth()->startOfMonth()->format('d_m_Y');
            case 'thisquarter':
                return $now->startOfQuarter()->format('d_m_Y');
            case 'lastquarter':
                return $now->subQuarter()->startOfQuarter()->format('d_m_Y');
            case 'thisyear':
                return $now->startOfYear()->format('d_m_Y');
            case 'sixmonths':
                return $now->addMonths(6)->format('d_m_Y');
            default:
                return Carbon::parse($dateString)->format('d_m_Y');
        }
    }

    public function create_(string $filename, string $timeline) {
        return "$filename" . '_' . strtolower($timeline) . '_from_' . $this->parseRelativeDate($timeline) . '.xlsx';
    }

    public function _useToday(string $filename, string $timeline) {
        return "$filename" . '_' . 'at_' . now()->format('Y_m_d') . '.xlsx';
    }

}