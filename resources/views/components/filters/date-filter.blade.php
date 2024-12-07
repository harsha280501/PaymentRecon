<div x-init="() => {
    Livewire.on('resets:dates', () => {
        start = null;
        end = null
    })
}">
    <div>
        <form @submit.prevent="() => {
            $wire.emit('resets:months');
            $wire.filterDate({start, end})  
        }" class="d-flex d-flex-mob gap-1 ">
            <div>
                <input x-model="start" id="startDate" class="date-filter w-mob-100" type="date">
            </div>
            <div>
                <input x-model="end" id="endDate" class="date-filter w-mob-100" type="date">
            </div>

            <button class="btn-mob w-mob-100 p-md-2 px-2 py-1" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
</div>
