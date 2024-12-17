<?php

namespace App\Http\Livewire\CommercialHead\Uploads;

use App\Traits\HasInfinityScroll;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('livewire.commercial-head.uploads.bank-mis-repository', [
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

        // return $this->paginate($collection, $this->perPage, $this->page);
    }


    /**
     * Paginating the Data
     * @param mixed $items
     * @param mixed $perPage
     * @param mixed $page
     * @param mixed $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage, $page, $options = []) {
        // getting the default page
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        // paginating the data
        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
        // return panigated data
        return $paginator;
    }


    /**
     * Using simple bootstrap pagination
     * @return string
     */
    public function paginationView() {
        return 'vendor.livewire.bootstrap'; // Replace with your custom pagination view
    }
}