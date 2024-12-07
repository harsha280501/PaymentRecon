<div>
    @if(in_array($activeTab, ['cash', 'card', 'wallet', 'upi']))
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em;">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
    </div>
    @endtab
</div>
