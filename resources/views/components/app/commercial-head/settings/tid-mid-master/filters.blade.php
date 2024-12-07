<div class="row mt-2" wire:key="bb699d3062e269c634fee7a63ad8ce67317883f1ef7d74b5b2d33fa123c3fe4c145c27575d3a9b3f07f859711b44145a344c9b5d902ac6cdabeda0395567d49a">
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
                @if($activeTab !== 'unallocated')

                <x-filters.dropdown initialValue="SELECT A BRAND" keys="Brand" :dataset="$brands" />



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

                <div class="w-mob-100">
                    <x-filters._filter data="tids" arr="tid" key="SGVsbG9rbmRrbmNkYw" update="tid" initialValue="SELECT TID/MID" />
                </div>

                @endif

              
                <div style="flex:1;">
                    <x-filters.months :months="$months" />
                </div>
            </div>
        </div>
    </div>
</div>
