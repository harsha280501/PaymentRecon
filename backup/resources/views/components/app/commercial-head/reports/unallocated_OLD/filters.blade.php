{{-- <div class="col-lg-12 mb-3" style="@if($tab!='upi') display: none @endif">
    <div class="d-flex align-items-center gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()    
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div class="w-mob-100" style="margin-top: 7px">
            <x-filters.months :months="$months" />
        </div>

        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div> --}}


<div class="col-lg-12 mb-3">
    <div class="d-flex  gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()    
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div style="@if($tab=='upi') display: none @endif">
            <x-filters._filter data="banks" arr="bank" key="SGVsbG9rbmRrbmNkYwfkod2nm" update="bank" initialValue="SELECT A BANK" />
        </div>

        <x-filters.months :months="$months" />
        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>
