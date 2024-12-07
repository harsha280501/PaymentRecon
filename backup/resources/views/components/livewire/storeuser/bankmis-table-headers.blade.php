<table class="table table-responsive table-info">
    <thead>
        <tr>
            <th class="left">Bank name</th>
            <th class="right">Transaction Type</th>
            <th class="right">Customer Code</th>
            <th class="left">Location Name</th>
            <th class="right">Deposit Date</th>
            <th class="right">Adjustment Date</th>
            <th>
                <div class="d-flex align-items-center gap-2">
                    <span>Credit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="right">Deposit Slip No</th>
            <th class="right">Deposit Amount</th>
            <th class="right">Actions</th>
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>

</table>