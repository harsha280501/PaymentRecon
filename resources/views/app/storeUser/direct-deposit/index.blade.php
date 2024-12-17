@extends('layouts.store-user')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('store-user.direct-deposit.direct-deposit')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    const create = async (dataset) => {

        const formData = new FormData();

        // If there are errors, prevent form submission
        Object.entries(dataset).map(item => {
            formData.append(item[0], item[1]);
        })

        const data = await request.http({
            url: '/suser/direct-deposit/create'
            , method: "POST"
            , data: formData
            , processData: false
            , contentType: false
        });

        return data;
    }


    function directDepositForm() {
        return {
            showModal: false
            , loading: false
            , depositSlipNo: null
            , amount: null
            , date: null
            , bank: null
            , accountNo: null
            , bankBranch: null
            , location: null
            , city: null
            , state: null
            , salesDateFrom: null
            , salesDateTo: null
            , bankDeposit: null
            , cashDepositBy: null
            , RTGS_NEFT_No: null
            // , otherRemarks: null
            , reason: null
            , depositSlipProof: null
            , salesTender: null
            , errors: {},

            openModal() {
                this.showModal = true;
            },

            async save() {
                console.log()
                this.loading = true

                this.errors = {};
                if (!this.depositSlipNo) {
                    this.errors.depositSlipNo = 'The Deposit Slip No field is required.';
                    this.loading = false;
                }

                if (!this.amount) {
                    this.errors.amount = 'The Amount field is required.';
                    this.loading = false;
                }

                if (!this.date) {
                    this.errors.date = 'The Date field is required.';
                    this.loading = false;
                }
                

                if (!this.bank) {
                    
                    this.errors.bank = 'The Bank field is required.';
                    this.loading = false;
                }

                if (!this.accountNo) {
                    this.errors.accountNo = 'The Account No field is required.';
                    this.loading = false;
                }

                if (!this.bankBranch) {
                    this.errors.bankBranch = 'The Bank Branch field is required.';
                    this.loading = false;
                }

                if (!this.location) {
                    this.errors.location = 'The Location field is required.';
                    this.loading = false;
                }

                if (!this.city) {
                    this.errors.city = 'The City field is required.';
                    this.loading = false;
                }

                if (!this.state) {
                    this.errors.state = 'The State field is required.';
                    this.loading = false;
                }

                if (!this.salesDateFrom) {
                    this.errors.salesDateFrom = 'The Sales Date From field is required.';
                    this.loading = false;
                }

    
                if (!this.bankDeposit) {
                    this.errors.bankDeposit = 'The Bank Deposit To field is required.';
                    this.loading = false;
                }

                if (!this.cashDepositBy) {
                    this.errors.cashDepositBy = 'The Cash Deposit By field is required.';
                    this.loading = false;
                }

                if (!this.RTGS_NEFT_No && this.bankDeposit != 'Cash Deposit') {
                    this.errors.RTGS_NEFT_No = 'The RTGS_NEFT_No By field is required.';
                    this.loading = false;
                }
              


                // if (!this.otherRemarks) {
                //     this.otherRemarks = ''
                //     this.loading = false;
                // }

                

                if (!this.depositSlipProof || !this.depositSlipProof.name.split('.')[1]) {
                    this.errors.depositSlipProof = 'The Deposit Slip Proof field is required.';
                    this.loading = false;
                }


                if (!['png', 'pdf', 'jpg', 'csv', 'xlsx'].includes(this.depositSlipProof.name.split('.')[1])) {
                    this.errors.depositSlipProof = 'Unsupported Mime Type, Supported: png, pdf, jpg, csv, xlsx';
                    this.loading = false;
                }


                // If there are errors, prevent form submission
                if (Object.keys(this.errors).length > 0) {
                    console.log(this.errors)
                    this.loading = false;
                    return;
                }


                
                this.loading = true
                const dataset = {
                    depositSlipNo: this.depositSlipNo
                    , amount: this.amount
                    , directDepositDate: this.date
                    , bank: this.bank
                    , accountNo: this.accountNo
                    , bankBranch: this.bankBranch
                    , location: this.location
                    , city: this.city
                    , state: this.state
                    , salesDateFrom: this.salesDateFrom
                    , salesDateTo: this.salesDateTo
                    , bankDeposit: this.bankDeposit
                    , cashDepositBy: this.cashDepositBy
                    , RTGS_NEFT_No: this.RTGS_NEFT_No
                    , otherRemarks: this.otherRemarks
                    , reason: this.reason
                    , depositSlipProof: this.depositSlipProof
                    , salesTender: this.salesTender
                , }


                this.loading = true
                const data = await create(dataset)

                if (data.isError == true) {
                    errorMessageConfiguration(data.error?.mesage);
                    this.loading = false
                    return false;
                }



                // Reset form fields
                this.depositSlipNo = null;
                this.amount = null;
                this.date = null;
                this.bank = null;
                this.accountNo = null;
                this.bankBranch = null;
                this.location = null;
                this.city = null;
                this.state = null;
                this.salesDateFrom = null;
                this.salesDateTo = null;
                this.cashDepositBy = null;
                this.otherRemarks = null;
                this.reason = null;
                this.depositSlipProof = null;
                this.salesTender = null;



                succesMessageConfiguration("Successfully uploaded");
                window.location.reload(true);
                // this.loading = false
                return true;
            }
        , };
    }

</script>
@endsection
