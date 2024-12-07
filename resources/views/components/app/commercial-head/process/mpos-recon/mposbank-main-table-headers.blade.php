<tr>
    <th>
        <div class="d-flex align-items-center gap-2">
            <span>Sales Date</span>
            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
        </div>
    </th>
    <th>Deposit Date</th>
    <th>Store ID</th>
    <th>Retek Code</th>
    <th>Brand Name</th>
    <th>Col Bank</th>
    <th>Status</th>
    <th>Bank Drop ID</th>
    <th style="text-align: right !important">BankDrop Amount</th>
    <th style="text-align: right !important">Tender Amount</th>
    <th style="text-align: right !important">Deposit Amount</th>
    <th style="text-align: right !important">Tender Difference [Tender - Deposit]</th>
    <th style="text-align: right !important">Pending Difference</th>
    <th style="text-align: right !important">Reconcilied Difference</th>
    <th>Reconciliation Status</th>
    <th>Submit Recon</th>
</tr>
