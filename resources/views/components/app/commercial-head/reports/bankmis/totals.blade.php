<div class="d-flex justify-content-center mt-3" style="flex-direction: column;">
    <div class="d-flex justify-content-evenly gap-2 align-items-center mb-2"
        style="margin-top: -10px">
        {{-- Total Count --}}
        <div class="">
            <p class="text-primary mainheadtext text-center" style="font-size: .9em">Total Amount: </p>
            <span
                style="color: black; font-weight: 900; font-size: .97em; text-align: center">{{ isset($dataset[0]->totalAmount) ? $dataset[0]->totalAmount : 0 }}</span>
        </div>

        @foreach($dataset as $data)
        <div class="">
                <p class="text-primary mainheadtext text-center" style="font-size: .9em">{{ $data->colBank }}: </p>
                <span style="color: black; font-weight: 900; font-size: .97em; text-align: center">{{ isset($data->depositAmount) ? $data->depositAmount : 0 }}</span>
        </div>
        @endforeach
    </div>
</div>
