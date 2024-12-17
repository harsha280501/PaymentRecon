<div class="d-flex justify-content-start align-items-center p-3 gap-3" x-data="{
    sales() {
        const amounts = recons.map(item => item.amount || 0)
        const sum = amounts.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
        return isNaN(sum) ? 0 : sum
    }

    // deposit() {
    //     const amounts = recons.map(item => item.amount || 0)
    //     const sum = amounts.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
    //     return isNaN(sum) ? 0 : sum
    // },
}">
    {{-- <template x-if="'{{ $data->diffSaleDeposit }}' < 0"> --}}
        <div class="d-flex w-50 justify-content-start align-items-center gap-2">
            <h5 class="text-black">Total Amount</h5>
            <input disabled :value="sales()" type="text" class="form-control w-50">
        </div>
        {{-- </template> --}}
        {{-- <template x-if="'{{ $data->diffSaleDeposit }}' > 0">
        <div class="d-flex w-50 justify-content-start align-items-center gap-2">
            <h5 class="text-black">Total Amount</h5>
            <input disabled :value="deposit()" type="text" class="form-control w-50">
        </div>
        </template> --}}
</div>
