<div class="d-flex justify-content-start align-items-center p-3 gap-3" x-data="{
    sales() {
        const amounts = recons.map(item => item.amount || 0)
        const sum = amounts.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
        return isNaN(sum) ? 0 : parseFloat(sum)
    }
}">
    <div class="d-flex w-50 justify-content-start align-items-center gap-2">
        <h5 class="text-black">Total Amount</h5>
        <input disabled :value="sales()" type="text" class="form-control w-50">
    </div>
</div>
