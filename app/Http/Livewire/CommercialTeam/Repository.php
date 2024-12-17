<?php

namespace App\Http\Livewire\CommercialTeam;

use App\Exports\CommercialTeam\RepositoryExport;
use App\Models\MRepository as CommercialHeadRepository;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CommercialHead\SAPExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use function PHPUnit\Framework\isNull;

class Repository extends Component
{
    use WithPagination;

    protected $repos;


    public function render()
    {
        $this->repos = $this->repos();
        return view('livewire.commercial-team.repository', [
            'repos' => $this->repos,
        ]);
    }

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
       /**
     * Get the aMain repos
     * @return LengthAwarePaginator
     */
    public function repos()
    {



        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_REPOSITORY :PROC_TYPE , :PROC_Date', [
            'PROC_TYPE' => 'Repository',
            'PROC_Date' => null,

        ]));

        //dd($collection);

        return $this->paginate($collection, $this->perPage, $this->page);
    }



    public function exportExcel($data)
    {
        dd($data);
        // return Excel::download(new RepositoryExport($data), $data->fileName);
    }

       /**
     * Paginating the Data
     * @param mixed $items
     * @param mixed $perPage
     * @param mixed $page
     * @param mixed $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage, $page, $options = [])
    {
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
     /**
     * Using simple bootstrap pagination
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap'; // Replace with your custom pagination view
    }
}
