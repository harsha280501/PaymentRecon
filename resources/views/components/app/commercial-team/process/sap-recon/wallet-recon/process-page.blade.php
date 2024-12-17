<div class="row">
    <div class="col-lg-12">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>
                    <th>Deposit Date</th>

                    <th>Store ID</th>
                    <th>Retek Code</th>
                    <th>Brand</th>
                    <th>ColBank</th>
                    <th style="text-align: right !important">Wallet Sale</th>
                    <th style="text-align: right !important">Deposit Amount</th>
                    <th style="text-align: right !important">Difference[Sales - Deposit]</th>
                    <th style="text-align: right !important">Pending Difference</th>
                    <th style="text-align: right !important">Reconcilied Difference</th>
                    <th>Status</th>
                    <th>Reconciliation Status</th>
                    <th>Submit Recon</th>
                </tr>
            </x-scrollable.scroll-head>
            {{ $slot }}
        </x-scrollable.scrollable>
    </div>
</div>
