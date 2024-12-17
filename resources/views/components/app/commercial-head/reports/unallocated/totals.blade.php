<div class="d-flex justify-content-center mt-3" style="flex-direction: column;">
    <div class="d-flex flex-column flex-md-row justify-content-center gap-4 align-items-center mb-2"
        style="margin-top: -10px">
        {{-- Total Count --}}
        <div class="flex-main">
            <p class="text-primary mainheadtext">Total Amount: </p>
            <span
                style="color: black; font-weight: 900;">{{ isset($dataset->totalAmount) ? $dataset->totalAmount : 0 }}</span>
        </div>
        @if ($activeTab == 'cash')
            <div class="flex-main">
                <p class="text-primary mainheadtext">HDFC: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->HDFC) ? $dataset->HDFC : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">AXIS: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->AXIS) ? $dataset->AXIS : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">ICICI: </p>
                <span
                    style="color: black; font-weight: 900;">{{ isset($dataset->ICICI) ? $dataset->ICICI : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">IDFC: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->IDFC) ? $dataset->IDFC : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">SBI: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->SBI) ? $dataset->SBI : 0 }}</span>
            </div>
        @elseif($activeTab == 'card')
            <div class="flex-main">
                <p class="text-primary mainheadtext">HDFC: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->HDFC) ? $dataset->HDFC : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">AMEX: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->AMEX) ? $dataset->AMEX : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">ICICI: </p>
                <span
                    style="color: black; font-weight: 900;">{{ isset($dataset->ICICI) ? $dataset->ICICI : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">SBI: </p>
                <span style="color: black; font-weight: 900;">{{ isset($dataset->SBI) ? $dataset->SBI : 0 }}</span>
            </div>
        @elseif($activeTab == 'wallet')
            <div class="flex-main">
                <p class="text-primary mainheadtext">PhonePe: </p>
                <span
                    style="color: black; font-weight: 900;">{{ isset($dataset->PhonePe) ? $dataset->PhonePe : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="text-primary mainheadtext">PayTM: </p>
                <span
                    style="color: black; font-weight: 900;">{{ isset($dataset->PayTM) ? $dataset->PayTM : 0 }}</span>
            </div>
        @endif

    </div>
</div>
