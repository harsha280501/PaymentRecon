<tr>
    <th>
        <div class="d-flex align-items-center gap-2 left">
            <span>Credit Date</span>
            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
        </div>
    </th>
    <th class="left">Deposit Date</th>
    <th class="left">Store ID</th>
    <th class="left">Retek Code</th>
    <th class="left">Col Bank</th>
    <th class="left">Status</th>
    <th class="left">Reference Number</th>
    <th class="right">Net MIS Amount</th>
    <th class="right">Credit Amount</th>
    <th class="right">Store Response Entry</th>
    <th class="right">Difference [Net Amt - Cr Amt  <br/> - Store Response]</th>
    <th class="left">Store Gouping Remarks</th>
</tr>
