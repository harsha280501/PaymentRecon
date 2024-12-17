<div x-data="{
    start: null,
    end: null,
    minDate: '{{ getReconStartingDate() }}', // Injected min date
    maxDate: '{{ getReconClosingDate() }}', // Injected max date
    resetDates() {
        this.start = null;
        this.end = null;
    },
    validateDates() {
        // Check if start date is earlier than the minDate
        if (this.start && this.start < this.minDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date',
                text: `Start date cannot be earlier than ${this.minDate}.`,
            });
            this.start = null;
        }

        // Check if end date is later than the maxDate
        if (this.end && this.end > this.maxDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid End Date',
                text: `End date cannot be later than ${this.maxDate}.`,
            });
            this.end = null;
        }
    }
}" x-init="Livewire.on('resets:dates', () => resetDates())">

    <div>
        <form
            @submit.prevent="() => {
                validateDates();
                if (start && end) {
                    $wire.emit('resets:months');
                    $wire.filterDate({ start, end });
                }
            }"
            class="d-flex d-flex-mob gap-1 ">

            <!-- Start Date -->
            <div>
                <input x-model="start" id="startDate" class="date-filter w-mob-100" type="date" :min="minDate"
                    :max="maxDate" placeholder="Select start date">
            </div>

            <!-- End Date -->
            <div>
                <input x-model="end" id="endDate" class="date-filter w-mob-100" type="date" :min="minDate"
                    :max="maxDate" placeholder="Select end date">
            </div>

            <button class="btn-mob w-mob-100 p-md-2 px-2 py-1"
                style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
</div>
