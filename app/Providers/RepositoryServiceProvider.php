<?php

namespace App\Providers;

use App\Interface\BankStatementReadLogsInterface;
use App\Interface\MisReadLogsInterface;
use App\Interface\Excel\SpreadSheet;
use App\Repositories\BankStatementReadLogs;
use App\Repositories\Excel\Excel;
use App\Repositories\MisReadLogs;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {

        /**
         * Binding the MIS Upload repository with the interface
         * not to get inteactive with the parameters (which sould be passed)
         */
        $this->app->bind(
            MisReadLogsInterface::class,
            MisReadLogs::class
        );


        /**
         * Binding the Bank statement Upload repository with the interface
         * not to get inteactive with the parameters (which sould be passed)
         */
        $this->app->bind(
            BankStatementReadLogsInterface::class,
            BankStatementReadLogs::class
        );


        /**
         * Binding the Excel Repository to the SpreadSheet Interface
         */
        $this->app->bind(
            SpreadSheet::class,
            Excel::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        //
    }
}
