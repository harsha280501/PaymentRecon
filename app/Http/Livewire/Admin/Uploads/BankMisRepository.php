<?php

namespace App\Http\Livewire\Admin\Uploads;

use App\Traits\HasInfinityScroll;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class BankMisRepository extends Component {
    use HasInfinityScroll;

    protected $repos;

    public $order = 'DESC';

    public $column = "ID";

    public $searchingFor = "order";

    public $searchString = "";

    protected $queryString = ['searchString' => ['except' => '']];



    public function mount() {
        Cache::forget('search-string-for-search-filter-on-bank-mis-repository');
    }



    public function render() {

        $this->repos = $this->repos();
        $searchString = !Cache::get('search-string-for-search-filter-on-bank-mis-repository') ?: Cache::get('search-string-for-search-filter-on-bank-mis-repository');

        return view('livewire.admin.uploads.bank-mis-repository', [
            'repos' => $this->repos,
            'searchString' => $searchString
        ]);
    }


    public function updating($item) {
        if ($item == "order" || $item == "column") {
            $this->searchingFor = 'order';
            $this->searchString = '';
            Cache::forget('search-string-for-search-filter-on-bank-mis-repository');
        }
    }


    public function searchFilter($item) {
        $this->searchingFor = 'search';
        $this->searchString = $item;

        Cache::put('search-string-for-search-filter-on-bank-mis-repository', $item, 5000);
    }


    public function back() {
        $this->searchingFor = 'order';
        $this->searchString = '';
    }

    /**
     * Get the aMain repos
     * @return LengthAwarePaginator
     */
    public function repos() {

        return DB::infinite('PaymentMIS_PROC_SELECT_REPOSITORY_Filters :procType, :column, :order, :searchKeyword', [
            'procType' => $this->searchingFor,
            'column' => $this->column,
            'order' => $this->order,
            'searchKeyword' => $this->searchString
        ], $this->perPage);
    }
}