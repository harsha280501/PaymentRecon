<div class="mt-3">
    <div class="d-flex d-flex-mob gap-2 flex-wrap">
        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div>
            <x-filters.dropdown :dataset="$accountNo" keys="acctNo" initialValue="SELECT AN ACCOUNT" />
        </div>

        <div class="w-mob-100">
            <div class="w-mob-100" wire:ignore>
                <select id="select1-dropdown" class="custom-select select2 form-control searchField w-mob-100" style="width: 220px" data-live-search="true" data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item">SELECT A BRANCH</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach($branches as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['branch'] != '')
                    <option class="dropdown-list" value="{{ $item['branch'] }}">{{ $item["branch"] }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <x-filters.months :months="$months" />
        </div>

        <x-filters.date-filter />

        <div class="d-flex justify-content-end align-item-center" style="flex: 1;">
            <button data-bs-toggle="modal" data-bs-target="#import-cash-deposit-modal" class="bg-success btn mb-1 w-mob-100 py-2 mt-1" style="background: #3682cd; color: #fcf8f8; width: 140px; font-size: 17px !important;">Import</button>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 1em; padding-right: 3em">
                    <div style="flex: 1"></div>
                    <div x-data="{ show: false, timeout: null }" class="d-flex align-items-center gap-2 w-mob-100" style="width: 100px; " x-init="@this.on('no-data', () => {
                            clearTimeout(timeout); show = true; timeout = setTimeout(() => { show = false }, 3000);
                        })" style="position: relative">
                        <p class="alert alert-sm alert-info" x-show="show" style="padding: .5em 1em; margin-top: 11px; position: absolute; z-index: 9999; width: 200px; right:10%">
                            No
                            Data
                            to Export</p>

                        <template x-if="!selection.length">
                            <div class="w-mob-100">
                                <button type="button" class="btn mb-1 w-mob-100 py-2 mt-1" style="background: #3682cd; color: #fcf8f8;width:140px; font-size: 17px !important;" @click.prevent="() => {
                                            $wire.export()
                                        }">
                                    Export Excel </button>
                            </div>
                        </template>

                        <template x-if="selection.length">
                            <div class="w-mob-100">
                                <button type="button" class="btn mb-1 w-mob-100 py-2 mt-1" style="background: #3682cd; color: #fcf8f8;width:140px; font-size: 15px !important;" @click.prevent="() => {
                                            $wire.export(Array.from(new Set(selection)), checkedAll)
                                        }">
                                    Export Selection</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
