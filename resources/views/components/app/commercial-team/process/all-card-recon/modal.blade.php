<div class="modal fade" id="Main_{{ $data->DateID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;">
        <x-app.store-user.process.all-card-recon.popup-model :data="$data">
            <div x-data="allCard" class="modal-body">

                <x-app.store-user.process.all-card-recon.popup-headers :data="$data" />
                <br>

                <h5>Reconciliation Window </h5>
                <x-app.store-user.process.all-card-recon.recon-window :data="$data" />
                <br>

                <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">Store Response</h4>

                <div>
                    {{-- Add Process --}}
                    {{-- <x-app.store-user.process.all-card-recon.add-recon-button ::recons="recons" />
                    <x-app.store-user.process.all-card-recon.manual-entry :data="$data">
                        <template x-for="recon in recons">
                            <x-app.store-user.process.all-card-recon.cash-process-entry ::recon="recon" :data="$data" :remarks="$remarks" />
                        </template>
                    </x-app.store-user.process.all-card-recon.manual-entry>
                    <x-app.store-user.process.all-card-recon.get-amount-totals :data="$data" /> --}}

                    {{-- total --}}
                    <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                        {{-- save form --}}
                        {{-- <template x-if="'{{ $data->reconStatus }}' != 'Pending for Approval'">
                        <button @click="submit($event.target.dataset.id)" data-primary-id="{{ $data->cardSalesRecoUID }}" data-id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" type="submit" class="btn btn-success green">Submit</button>
                        </template> --}}
                    </div>
                </div>
                <br />

                <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                {{-- <x-app.store-user.process.all-card-recon.history :data="$data" /> --}}
                <br />
            </div>

    </div>
    {{-- modal footer --}}
    <x-app.store-user.process.all-card-recon.popup-model-footer :data="$data">
        <div x-show="loading" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span>Loading ...</span>
        </div>
    </x-app.store-user.process.all-card-recon.popup-model-footer>
    </x-app.store-user.process.all-card-recon.popup-model>
</div>
</div>
