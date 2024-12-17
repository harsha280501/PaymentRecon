<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}"
    wire:key="ecc7198bab69a022feed8661d3719b34376f8f62166cad88cbf05233d3016cc8c7f4844b57168e847583e888f72f1640a382b41381584b230f462964a66f1f4f">
    <div class="row mb-1"
        wire:key="b7e817db68d62c4ddc57eaa5e724aa532ed938b7b2b5d2ba66f8b658433bd0ea609a2c72b2b731e6ffe3f53fa375db1825b8906eb75dad7e08asddddsdsdf0b4d803d37afb">
        <div class="col-lg-6"
            wire:key="b7e817db68d62c4ddc57eaa5e724aa532ed938b7b2b5d2ba66f8b658433bd0ea609a2c72b2b731e6ffe3f53fa375db1825b8906eb75asdassqwqddfdfvdad7e08asddddsdsdf0b4d803d37afb">
            <ul class="nav nav-tabs justify-content-start" role="tablist"
                wire:key="63dde8e69467423423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00">

                <div x-data="{
                    selectedTid: localStorage.getItem('selectedTid') || 'Select TID Type', // Get from localStorage or default
                    reset() {
                        this.selectedTid = 'Select TID Type'; // Reset the selection
                        localStorage.removeItem('selectedTid'); // Remove the value from localStorage
                    },
                    updateTid(tid) {
                        this.selectedTid = tid; // Update the selected TID
                        localStorage.setItem('selectedTid', tid); // Save the value to localStorage
                    }
                }">
                    <div class="dropdown mb-3">
                        <button class="btn btn-secondary dropdown-toggle"
                            style="background-color: #d3d3d3; color: black;" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span x-text="selectedTid"></span> <!-- Dynamically display the selected TID -->
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item @tab('amexmid')
active
@endtab"
                                    style="color: black;"
                                    @click.prevent="updateTid('AMEX TID'); window.location.href = '{{ url('/') }}/chead/settings/tid-mid-master?t=amexmid'">
                                    AMEX TID
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item @tab('icicimid')
active
@endtab"
                                    style="color: black;"
                                    @click.prevent="updateTid('ICICI TID'); window.location.href = '{{ url('/') }}/chead/settings/tid-mid-master?t=icicimid'">
                                    ICICI TID
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item @tab('sbimis')
active
@endtab"
                                    style="color: black;"
                                    @click.prevent="updateTid('SBI TID'); window.location.href = '{{ url('/') }}/chead/settings/tid-mid-master?t=sbimis'">
                                    SBI TID
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item @tab('hdfctid')
active
@endtab"
                                    style="color: black;"
                                    @click.prevent="updateTid('HDFC TID'); window.location.href = '{{ url('/') }}/chead/settings/tid-mid-master?t=hdfctid'">
                                    HDFC TID
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>





                <li class="nav-item"
                    wire:key="63dde128e6946gf45447423123423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00">
                    <a @click.pervent="() => {
                        reset()
                        window.location.href = '{{ url('/') }}/chead/settings/tid-mid-master' + '?t=unallocated'
                    }"
                        class="nav-link @tab('unallocated')
active tab-active
@endtab"
                        data-bs-toggle="
                            tab" href="#" role="tab"
                        style="font-size: .8em !important">
                        Un-allocated TID
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-lg-6 d-flex align-items-center justify-content-end"
            wire:key="63dde128e69467423123423rgrkuc87bb10e55a3ajmnhvfcxzaqb4b0f25eb1546da94b5d8288d1990d862ea8b00">
            <div class="btn-group mb-1">
                <div class="mb-2" style="float: right;">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createPopupModal">Add
                        MID/TID</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportedupload">Import
                        Exported MID</button>
                    <button class="btn btn-primary" @click="() => { $wire.export() }">Export</button>
                </div>
            </div>
            @tab('amexmid')
                <x-app.commercial-head.settings.tid-mid-master.amexmid-import-popup id="amexupload" />
            @endtab
            @tab('icicimid')
                <x-app.commercial-head.settings.tid-mid-master.icicimid-create-popup id="iciciCreate" />
                <x-app.commercial-head.settings.tid-mid-master.icicimid-import-popup id="iciciupload" />
            @endtab
            @tab('sbimis')
                <div class="btn-group mb-1"
                    wire:key="63dde128e69467423123423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00ASSDCSXXC">

                </div>
                <x-app.commercial-head.settings.tid-mid-master.sbimid-create-popup id="sbiCreate" />
                <x-app.commercial-head.settings.tid-mid-master.sbimid-import-popup id="sbiupload" />
            @endtab
            @tab('hdfctid')
                <div class="btn-group mb-1"
                    wire:key="63dde128e6946742312342SSDFDFFSDSD3rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00">

                </div>
                <x-app.commercial-head.settings.tid-mid-master.hdfctid-create-popup id="hdfcCreate" />

                <x-app.commercial-head.settings.tid-mid-master.hdfctid-import-popup id="hdfcupload" />
            @endtab

            @tab('unallocated')
                <div class="btn-group mb-1" wire:ignore
                    wire:key="63dsdccscscxcxcxznmn1211de128e69467423123423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00">
                    <div class="mb-2" style="float: right;">
                        <button class="btn btn-primary"
                            @click="() => {
                        $wire.export()
                    }">Export
                        </button>
                    </div>
                </div>
            @endtab
        </div>
    </div>

    <div class="mt-2 mb-2">
        <x-app.commercial-head.settings.tid-mid-master.filters :banks="$banks" :months="$_months" :activeTab="$activeTab"
            :filtering="$filtering" :brands="$brands" :stores="$stores" />
    </div>

    <div class="col-lg-12"
        wire:key="b7e817db68d62c4ddc57eaa5e724aa532ed938b7b2b5d2ba66f8b658433bd0ea609a2c72b2b731e6ffe3f53fa375db1825b8906eb75dad7e08f0b4d803d37afb">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                @tab('amexmid')
                    <tr wire:key="38310841c9660680df5ec1a599a139b2fa591cbb966f38f4e0060dbc17f6a4a6">
                        <th class="">TID</th>
                        <th class="">Bank</th>
                        <th class="">Store ID</th>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Store Opening Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="
                                fa-solid @if ($orderBy == 'asc') fa-caret-up
                                @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>

                        <th class="">New Retek Code</th>
                        <th class="">Old Retek Code</th>
                        <th class="">Brand Name</th>
                        <th class="">Status</th>
                        <th class="">Date of Conversion</th>
                        {{-- <th class="">POS</th>
                    <th class="">Relevance</th>
                    <th class="">EDC Service Provider</th> --}}
                        <th class="">Closure Date</th>
                        <th class="">Action</th>
                    </tr>
                @endtab

                @tab('icicimid')
                    <tr wire:key="da11a97fc116e5b45a00967c8ac709acbe7103d10aeadf10bcc44a710f31dafb">
                        <th class="">TID</th>
                        <th class="">Bank</th>
                        <th class="">Store ID</th>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Store Opening Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="
                                fa-solid @if ($orderBy == 'asc') fa-caret-up
                                @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>

                        <th class="">New Retek Code</th>
                        <th class="">Old Retek Code</th>
                        <th class="">Brand Code</th>
                        <th class="">Status</th>
                        {{-- <th class="right">Closure Date</th> --}}
                        <th class="">Date of Conversion</th>
                        {{-- <th class="">POS</th>
                    <th class="">Relevance</th>
                    <th class="">EDC Service Provider</th> --}}
                        <th class="">Closure Date</th>
                        <th class="">Action</th>
                    </tr>
                @endtab

                @tab('sbimis')
                    <tr wire:key="63dde46da94b5d8288d1990d862ea8b00">
                        <th class="">TID</th>
                        <th class="">Bank</th>
                        <th class="">Store ID</th>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Store Opening Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="
                                fa-solid @if ($orderBy == 'asc') fa-caret-up
                                @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>

                        <th class="">New Retek Code</th>
                        <th class="">Old Retek Code</th>
                        <th class="">Brand Name</th>
                        <th class="">Status</th>
                        {{-- <th class="right">Closure Date</th> --}}
                        <th class="">Date of Conversion</th>
                        {{-- <th class="">POS</th>
                    <th class="">Relevance</th>
                    <th class="">EDC Service Provider</th> --}}
                        <th class="">Closure Date</th>
                        <th class="">Action</th>
                    </tr>
                @endtab

                @tab('hdfctid')
                    <tr wire:key="63dde128e69467423123423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990fdds">
                        <th class="">TID</th>
                        <th class="">Bank</th>
                        <th class="">Store ID</th>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Store Opening Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="
                                fa-solid @if ($orderBy == 'asc') fa-caret-up
                                @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>

                        <th class="">New Retek Code</th>
                        <th class="">Old Retek Code</th>
                        <th class="">Brand Name</th>
                        <th class="">Status</th>
                        <th class="">Date of Conversion</th>
                        {{-- <th class="">POS</th>
                    <th class="">Relevance</th>
                    <th class="">EDC Service Provider</th> --}}
                        <th class="">Closure Date</th>
                        <th class="">Action</th>
                    </tr>
                @endtab


                @tab('unallocated')
                    <tr wire:key="63dde128e69467423123423rgrkuc87bb10excvxcvxcvxcvxcvvcveb1546da94b5d8288d1990d862ea8b00">
                        <th class="">TID</th>
                        <th class="">Collection Bank</th>
                    </tr>
                @endtab


            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @tab('amexmid')
                    @foreach ($dataset as $data)
                        <tr
                            wire:key="482cd99224ad64d5e1c02c3d34d895e49850eba237a7ab61d3d401024820dccf_{{ rand() }}">
                            <td class=""> {{ $data->MID }} </td>
                            <td class=""> AMEX </td>
                            <td class=""> {{ $data->storeID }} </td>
                            <td class="">
                                {{ !$data->openingDt ? '' : Carbon\Carbon::parse($data->openingDt)->format('d-m-Y') }} </td>
                            <td class=""> {{ $data->newRetekCode }} </td>
                            <td class=""> {{ $data->oldRetekCode }} </td>
                            <td class=""> {{ $data->brandName }} </td>
                            <td class=""> {{ $data->Status }} </td>
                            {{-- <td class="right"> {{ $data->closureDate }} </td> --}}
                            <td class=""> {{ $data->conversionDt }} </td>
                            {{-- <td class=""> {{ $data->POS }} </td>
                    <td class=""> {{ $data->relevance }} </td>
                    <td class=""> {{ $data->EDCServiceProvider }} </td> --}}
                            {{-- <td class=""> {{ $data->closureDate }} </td> --}}
                            <td class="">
                                {{ !$data->closureDate ? '' : Carbon\Carbon::parse($data->closureDate)->format('d-m-Y') }}
                            </td>
                            <td class=""><a data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter_{{ $data->amexMIDUID }}" href="#">Edit</a>
                            </td>
                            <x-app.commercial-head.settings.tid-mid-master.amexmid-update-popup :data="$data" />
                        </tr>
                    @endforeach
                @endtab

                @tab('icicimid')
                    @foreach ($dataset as $data)
                        <tr
                            wire:key="a7edc2f53c71c389a54be50abb838efac647fedfcdc7fbf203a1652f4aa79e31_{{ rand() }}">
                            <td class=""> {{ $data->MID }} </td>
                            <td class=""> ICICI </td>
                            <td class=""> {{ $data->storeID }} </td>
                            <td class="">
                                {{ !$data->openingDt ? '' : Carbon\Carbon::parse($data->openingDt)->format('d-m-Y') }} </td>
                            <td class=""> {{ $data->newRetekCode }} </td>
                            <td class=""> {{ $data->oldRetekCode }} </td>
                            <td class=""> {{ $data->brandCode }} </td>
                            <td class=""> {{ $data->status }} </td>
                            {{-- <td class="right"> {{ $data->closureDate }} </td> --}}
                            <td class=""> {{ $data->conversionDt }} </td>
                            {{-- <td class=""> {{ $data->POS }} </td>
                    <td class=""> {{ $data->relevance }} </td>
                    <td class=""> {{ $data->EDCServiceProvider }} </td> --}}
                            <td class="">
                                {{ !$data->closureDate ? '' : Carbon\Carbon::parse($data->closureDate)->format('d-m-Y') }}
                            </td>
                            <td>
                                <a href="#" style="font-size: 1.1em"
                                    data-bs-target="#exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}"
                                    data-bs-toggle="modal">Edit</a>
                            </td>
                        </tr>
                        <x-app.commercial-head.settings.tid-mid-master.icicimid-update-popup :data="$data" />
                    @endforeach
                @endtab

                @tab('sbimis')
                    @foreach ($dataset as $data)
                        <tr
                            wire:key="ecf45eac23b75b61379dfd77044759c34bbf8cc28ce8cf1e583cee3c792900e0asksmmdnakj_{{ rand() }}">
                            <td class=""> {{ $data->MID }} </td>
                            <td class=""> SBI </td>
                            <td class=""> {{ $data->storeID }} </td>
                            <td class="">
                                {{ !$data->openingDt ? '' : Carbon\Carbon::parse($data->openingDt)->format('d-m-Y') }} </td>
                            <td class=""> {{ $data->newRetekCode }} </td>
                            <td class=""> {{ $data->oldRetekCode }} </td>
                            <td class=""> {{ $data->brandName }} </td>
                            <td class=""> {{ $data->status }} </td>
                            {{-- <td class="right"> {{ $data->closureDate }} </td> --}}
                            <td class=""> {{ $data->conversionDt }} </td>
                            {{-- <td class=""> {{ $data->POS }} </td>
                    <td class=""> {{ $data->relevance }} </td>
                    <td class=""> {{ $data->EDCServiceProvider }} </td> --}}
                            <td class="">
                                {{ !$data->closureDate ? '' : Carbon\Carbon::parse($data->closureDate)->format('d-m-Y') }}
                            </td>
                            <td>
                                <a href="#" style="font-size: 1.1em"
                                    data-bs-target="#exampleModalCenterThirdTab_{{ $data->sbiMIDUID }}"
                                    data-bs-toggle="modal">Edit</a>
                            </td>
                        </tr>
                        <x-app.commercial-head.settings.tid-mid-master.sbimid-update-popup :data="$data" />
                    @endforeach
                @endtab

                @tab('hdfctid')
                    @foreach ($dataset as $data)
                        <tr
                            wire:key="b1fcb71916f621168d9a4ca7d8ba397d991861ee274007e867d9a0ab7f222zxxczxczxb2a_{{ rand() }}">
                            <td class=""> {{ number_format($data->TID, 0, '', '') }} </td>
                            <td class=""> HDFC </td>
                            <td class=""> {{ $data->storeID }} </td>
                            <td class="">
                                {{ !$data->openingDt ? '' : Carbon\Carbon::parse($data->openingDt)->format('d-m-Y') }} </td>
                            <td class=""> {{ $data->newRetekCode }} </td>
                            <td class=""> {{ $data->oldRetekCode }} </td>
                            <td class=""> {{ $data->brandName }} </td>
                            <td class=""> {{ $data->status }} </td>
                            <td class="">{{ $data->conversionDt }}</td>

                            <td class="">
                                {{ !$data->closureDate ? '' : Carbon\Carbon::parse($data->closureDate)->format('d-m-Y') }}
                            </td>
                            <td>
                                <a href="#" style="font-size: 1.1em"
                                    data-bs-target="#exampleModalCenterFourthTab_{{ $data->hdfcTIDUID }}"
                                    data-bs-toggle="modal">Edit</a>
                            </td>
                        </tr>

                        <x-app.commercial-head.settings.tid-mid-master.hdfctid-update-popup :data="$data" />
                    @endforeach
                @endtab

                @tab('unallocated')
                    @foreach ($dataset as $data)
                        <tr
                            wire:key="63dde128e69467423123423rgrkuc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00_{{ rand() }}">
                            <td class=""> {{ $data->tid }} </td>
                            <td class=""> {{ $data->colBank }} </td>
                        </tr>
                    @endforeach
                @endtab
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
        <div wire:key="d7914fe546b684688bb95f4f888a92dfc680603a75f23eb823658031fff766d9">
            <x-app.commercial-head.settings.tid-mid-master.partials.import-popup id="exportedupload"
                :message="$message" />
            <x-app.commercial-head.settings.tid-mid-master.partials.create-popup id="createPopupModal" />
        </div>

    </div>

    <script>
        var $j = jQuery.noConflict();

        function _selectFilterExtOne() {

            this.selectFilterOne = $j(this.$refs.selectFilterOne).select2();

            this.selectFilterOne.on("select2:select", (event) => {
                this.$wire.storeFrom = event.target.value;
                this.$wire.filtering = true;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterOne.val("").trigger("change");
            })
        }


        function _selectFilterExtFive() {

            this.selectFilterFive = $j(this.$refs.selectFilterFive).select2();

            this.selectFilterFive.on("select2:select", (event) => {
                this.$wire.storeTo = event.target.value;
                this.$wire.filtering = true;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterFive.val("").trigger("change");
            })
        }
    </script>


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#bankFIlter').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
        });
    </script>

</div>
