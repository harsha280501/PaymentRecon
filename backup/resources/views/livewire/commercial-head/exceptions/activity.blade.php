<div x-data>


    <div class="col-lg-12 mb-3" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}">
        <div class="d-flex gap-2 d-flex-mob mt-2">

            <div style="display:@if ($filtering) unset @else none @endif" class="">
                <button @click="() => {
                $wire.back()
                reset()    
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>

            <div wire:ignore>
                <select id="status" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                    <option selected disabled value="" class="dropdown-item">SELECT ACTIVITY STATUS</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach(['LOGIN', 'LOGOUT'] as $item)
                    <option class="dropdown-list" value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <x-filters.dropdown :dataset="$locations" keys="location" initialValue="SELECT A LOCATION" />

            <x-filters.months :months="$_months" />
            <div>
                <x-filters.date-filter />
            </div>

            <x-filters.simple-export />
        </div>
    </div>




    <x-scrollable.scrollable :dataset="$dataset">
        <x-scrollable.scroll-head>
            <tr>
                <th class="left first-col sticky-col bggrey">
                    <div class="d-flex align-items-center gap-2">
                        <span>Date / Time</span>
                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy('mposDate')" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                    </div>
                </th>

                <td class="left">Type</td>
                <td class="left">Store ID</td>
                <td class="left">Store Name</td>
                <td class="left">Login Email</td>
                <td class="left">IP Address</td>
                <td class="left">Location</td>

            </tr>
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td class="left">{{ !$data->logTime ? '' : Carbon\Carbon::parse($data->logTime)->tz('Asia/Kolkata')->format('d-m-Y h:i:s A') }}</td>
                <td class="left">{{ $data->type }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->name }}</td>
                <td class="left">{{ $data->email }}</td>
                <td class="left">{{ $data->ipAddress }}</td>
                <td class="left">{{ $data->location }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#status').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });
        });

    </script>


</div>
