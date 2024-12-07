<div class="d-flex justify-content-start align-items-center p-3 gap-3" x-data="{
    sales() {
        const amounts = recons.map(item => item.amount || 0)
        const sum = amounts.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
        return isNaN(sum) ? 0 : sum
    },

    tenderAmount: parseFloat('{{ $data->tenderAmount }}'),
    bankDrop: parseFloat('{{ $data->bankDropAmount }}'),

    calculation() {
        // splitting the manual sale
        const splittedRecons = recons.map(item => {
            if (item.item == 'Manual store sale') { // checking if the item is manual sale
                return {...item, tenderAdj: parseFloat(item.amount)}
            } else {
                return {...item, bankAdj: parseFloat(item.amount)}
            }
        });

        // getting totals
        const tenderAdjs = splittedRecons.map(item => item.tenderAdj || 0)
        const bankAdj = splittedRecons.map(item => item.bankAdj || 0)

        // getting sums
        const tender = tenderAdjs.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
        const bank = bankAdj.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

        return ((this.tenderAmount + tender) - (this.bankDrop + bank)) == '{{ $data->DiffAmount }}' ? 0 : ((this.tenderAmount + tender) - (this.bankDrop + bank))
    },
}">

    <div class="d-flex w-50 justify-content-start align-items-center gap-2">
        <h5 class="text-black">Total Amount</h5>
        <input disabled :value="calculation()" type="text" class="form-control w-50">
    </div>

</div>
