<div class="d-flex justify-content-center mt-3" style="flex-direction: column;">
    <div class="d-flex flex-column flex-md-row justify-content-center gap-4 align-items-center mb-2"
        style="margin-top: -10px">
        {{-- Total Count --}}
        <div class="flex-main">
            <p class="text-primary mainheadtext">Total Amount: </p>
            <span
                style="color: black; font-weight: 900;">{{ isset($dataset[0]->totalAmount) ? $dataset[0]->totalAmount : 0 }}</span>
        </div>

        @foreach($dataset as $data)
        <div class="flex-main">
                <p class="text-primary mainheadtext">{{ $data->colBank }}: </p>
                <span style="color: black; font-weight: 900;">{{ isset($data->depositAmount) ? $data->depositAmount : 0 }}</span>
        </div>
        @endforeach
    </div>
</div>
