<div x-data="{
    search: '' ,
    isSearchNull () {
        return this.search != ''
    }
}" class="ms-auto d-flex align-items-center gap-2 " style="width: fit-content" x-init="() => {
    Livewire.on('resetAll', () => {
        search = ''
    })
}">
    <div style="border: 1px solid #0000004b; border-radius: 4px; overflow: hidden;">

        <form x-on:submit="(e) => {
            e.preventDefault();
            Livewire.emit('searchUpdated', search);
            $wire.filtering = true;
        }" class="btn-group w-mob-100">

            <input placeholder="{{ $placeHolder }}" style="background: transparent; color: #000; border: none; outline: none; padding: .3em .5em; height: 100%; width: 85%;" type="text" x-model="search">

            <template x-if="isSearchNull() == true">
                <button type="submit" style="
                background: transparent;
                color: #0000007a; 
                border: none; 
                outline: none;
                padding: 0 .4em;
                width: 15%
                " id="dropdownMenuButton1">
                    <i class="fa fa-search"></i>
                </button>
            </template>
        </form>
    </div>
</div>
