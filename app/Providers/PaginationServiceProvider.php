<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {

        DB::macro('paginate', function (string $storedProcedure, array $params, int $pageNumber, int $perPage = 10): LengthAwarePaginator {
            // Executing the Stored Procedure
            $collection = collect(DB::select($storedProcedure, $params));
            // get a default page number
            $page = $pageNumber ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
            // Getting the total pages
            $total = $collection?->first()?->TotalCount
                ? $collection?->first()?->TotalCount
                : 0;

            // paginatior instance
            return new LengthAwarePaginator($collection, $total, $perPage, $page);
        });


        DB::macro('infinite', function (string $storedProcedure, array $params, int $perPage = 10): Collection {
            // adding the perPage to the procedure
            $procedure = $storedProcedure . ', :PageSize';
            $addedPageSizeParam = [...$params, 'PageSize' => $perPage];

            // array instance
            return collect(DB::select($procedure, $addedPageSizeParam));
        });


        DB::macro('withOrderBySelect', function (string $storedProcedure, array $params, int $perPage = 10, $orderBy = "desc"): Collection {
            // adding the perPage to the procedure
            $procedure = $storedProcedure . ', :PageSize, :OrderBy';
            $addedPageSizeParam = [...$params, 'PageSize' => $perPage, 'OrderBy' => $orderBy];

            // array instance
            return collect(DB::select($procedure, $addedPageSizeParam));
        });
    }
}