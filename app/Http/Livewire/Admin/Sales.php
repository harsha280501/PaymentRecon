<?php

namespace App\Http\Livewire\Admin;

use App\Models\BankMSI;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    // use WithPagination;

    public $loading;

    public $perPage = 10;

    public $dropdownFilter = "0";

    public $paginationEnabled = false;


    public function paginate()
    {
        $collection = collect([...BankMSI::all()]);

        $currentPage = request()->get('page', 1);

        $paginatedData = new LengthAwarePaginator(
            $collection->forPage($currentPage, $this->perPage),
            $collection->count(),
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedData;
    }

    public function render()
    {
        return view('livewire.admin.sales', [
            'msi' => BankMSI::simplePaginate()
        ]);
    }
}
