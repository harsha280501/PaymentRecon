<div class="row mt-2" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null,
        this.end =  null
    }

}">
    <div class="col-lg-12">
        <div>
            <div class="d-flex d-flex-mob d-flex-tab gap-2">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>


                <div style="display: flex; justify-content: space-between; align-items: center; height: fit-content; gap: .4em; ">
                    <div x-init="_selectFilterExtOne" wire:ignore>
                        <select x-ref="selectFilterOne" data-placeholder="SELECT A STORE FROM" class="w-mob-100" style="width: 200px">
                            <option></option>
                            <option value=" ">All</option>
                            @foreach($stores as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div x-init="_selectFilterExtFive" wire:ignore>
                        <select x-ref="selectFilterFive" data-placeholder="SELECT A STORE TO" class="w-mob-100" style="width: 200px">
                            <option></option>
                            <option value=" ">All</option>
                            @foreach($stores as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <x-filters.months :months="$months" />

                <div style="flex:1;">
                    <x-filters.date-filter />
                </div>


                <div>
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="btn-group">
                            <div class="mb-0" style="float: right;">
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModalCenterCreate">Create
                                    Store Master</button>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#storemasterUpload">Import
                                    Store Master</button>
                                <button class="btn btn-primary" @click="() => {
                        $wire.export();
                    }">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
