<?php

namespace App\Http\Livewire\CommercialTeam\Settings;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class StoreMaster extends Component {

    use WithPagination;
    public $storemasterUID;
    public $userUID;

    /**
     * Data for pagination
     * @var int
     */
    public $perPage = 10;

    /**
     * Data for pagination
     * @var int
     */
    public $page = 1;

    public $dates;

    protected $datas;

    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->storemasterUID = 24;
        $this->userUID = auth()->user()->userUID;

    }



    public function render() {

        $this->datas = $this->datas();

        // getting the main data
        return view('livewire.commercial-team.settings.store-master', [
            'datas' => $this->datas,
            'dates' => $this->dates
        ]);
    }


    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function datas() {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreMaster :PROC_TYPE', [
            'PROC_TYPE' => 'NEWSTOREMASTER',
        ]));

        return $this->paginate($collection, $this->perPage, $this->page);
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
