<table class="table table-responsive table-info">
    <thead>
        <tr>
            <th>
                <div class="d-flex align-items-center gap-2">
                    <span>Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="right">RETEK Code</th>
            <th class="right">Store Name</th>
            <th class="left">Tender Value</th>
            <th class="right">TENDERTYPE</th>
            <th class="right">Tender Description</th>
            <th class="right">Transaction Type</th>

        </tr>
    </thead>
    {{ $slot }}
</table>