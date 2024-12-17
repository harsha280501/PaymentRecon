<?php

namespace App\Http\Livewire\AreaManager\Dashboard;

use App\Services\GeneralService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component {



    public $brandsAndStores = [];

    public $dateWiseFilter = 'ThisYear';


    public $from = null;
    public $to = null;



    public $stores = [];

    public $store = '';

    /**
     * Get the main brand and store
     * @return void
     */
    public function mount() {
        $this->stores = $this->stores();
        $this->filterDate($this->thisYear());
    }


    /**
     * FIlter date
     * @param mixed $item
     * @return void
     */
    public function filterDate($item) {
        $this->from = $item['from'];
        $this->to = $item['to'];
    }




    public function back() {
        $this->reset();
        $this->emit('resetAll');
        $this->filterDate($this->thisYear());
    }



    /**
     * Filtering items
     * @param mixed $item
     * @return void
     */
    public function datewise($item) {
        switch ($item) {
            case 'yesterday':
                $this->filterDate($this->yesterday());
                break;
            case 'ThisWeek':
                $this->filterDate($this->thisWeek());
                break;
            case 'LastWeek':
                $this->filterDate($this->lastWeek());
                break;
            case 'ThisMonth':
                $this->filterDate($this->thisMonth());
                break;
            case 'ThisYear':
                $this->filterDate($this->thisYear());
                break;
            default:
                $this->filterDate($this->lastMonth());
                break;
        }
    }


    /**
     * getting yesterdays date
     * @return array
     */
    public function yesterday() {
        return [
            'from' => Carbon::now()->subDay()->format('Y-m-d'),
            'to' => Carbon::now()->format('Y-m-d')
        ];
    }

    /**
     * Getting this week
     * @return array
     */
    public function thisWeek() {
        return [
            'from' => Carbon::now()->startOfWeek()->format('Y-m-d'),
            'to' => Carbon::now()->endOfWeek()->format('Y-m-d')
        ];
    }

    /**
     * Getting last week
     * @return array
     */
    public function lastWeek() {

        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        return [
            'from' => $endOfLastWeek->copy()->startOfWeek()->format('Y-m-d'),
            'to' => $endOfLastWeek->format('Y-m-d')
        ];
    }

    /**
     * Getting this month
     * @return array
     */
    public function thisMonth() {
        return [
            'from' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            'to' => Carbon::now()->endOfMonth()->format('Y-m-d')
        ];
    }

    /**
     * Getting last month
     * @return array
     */
    public function lastMonth() {
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        return [
            'from' => $endOfLastMonth->copy()->startOfMonth()->format('Y-m-d'),
            'to' => $endOfLastMonth->format('Y-m-d')
        ];
    }


    /**
     * Getting current Financial Year
     * @return array
     */
    public function thisYear() {

        $date = Carbon::now();

        // Determine the financial year
        if ($date->month >= 4 && $date->month <= 12) {
            // current year is the financial year
            return [
                'from' => Carbon::createFromDate($date->year, 4, 1)->format('Y-m-d'),
                'to' => Carbon::createFromDate($date->year + 1, 3, 31)->format('Y-m-d')
            ];
        } else {
            // previous year is the financial hear
            return [
                'from' => Carbon::createFromDate($date->year - 1, 4, 1)->format('Y-m-d'),
                'to' => Carbon::createFromDate($date->year, 3, 31)->format('Y-m-d')
            ];
        }
    }



    public function stores() {
        return DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'retekCodes'
        ]);
    }


    /**
     * Fetch main Dataset
     * @param string $procType
     * @return mixed
     */
    public function changeMainCashStats(string $procType = 'tile') {
        return Arr::first(DB::select('PaymentMIS_PROC_AREA_MANAGER_SELECT_DashboardSales :store, :from, :to, :procType', [
            'store' => $this->store,
            'from' => $this->from,
            'to' => $this->to,
            'procType' => $procType,
        ]));
    }

    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $this->emit('render:all');


        $dataset = [
            'tile' => $this->changeMainCashStats('tile'),
            'tender' => $this->changeMainCashStats('tender'),
            'june' => $this->changeMainCashStats('month-june'),
            'july' => $this->changeMainCashStats('month-july'),
            'august' => $this->changeMainCashStats('month-august'),
            'september' => $this->changeMainCashStats('month-september'),
            'card_june' => $this->changeMainCashStats('month-card-june'),
            'card_july' => $this->changeMainCashStats('month-card-july'),
            'card_august' => $this->changeMainCashStats('month-card-august'),
            'card_september' => $this->changeMainCashStats('month-card-september'),
            'collections' => [
                'august' => $this->changeMainCashStats('month-collection-august'),
                'july' => $this->changeMainCashStats('month-collection-july'),
                'june' => $this->changeMainCashStats('month-collection-june'),
            ]
        ];

        return view('livewire.area-manager.dashboard.dashboard', $dataset);
    }
}