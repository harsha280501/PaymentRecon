<div>
    @if($activeTab !== 'processed' && $activeTab !== 'wallet-bank-process')
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em;">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
        <p style="font-size: 1em;">Matched: <span style="color: teal; font-weight: 900;">{{ isset($cashRecons[0]->matchedCount) ? $cashRecons[0]->matchedCount : 0 }}</span></p>
        <p style="font-size: 1em;">Not Matched: <span style="color: lightcoral; font-weight: 900;">{{ isset($cashRecons[0]->notMatchedCount) ? $cashRecons[0]->notMatchedCount : 0 }}</span></p>
    </div>
    @endtab

    @tab('processed')
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em;">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
    </div>
    @endtab

    @tab('wallet-bank-process')
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em;">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
    </div>
    @endtab
</div>
