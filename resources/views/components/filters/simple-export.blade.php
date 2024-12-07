<div style="
flex: 1
"></div>
<div>

    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1em; padding-right: 3em">
        <div style="flex: 1"></div>
        <div x-data="{ show: false, timeout: null }" class="d-flex align-items-center gap-2 w-mob-100"
            style="width: 100px; " x-init="@this.on('no-data', () => {
            clearTimeout(timeout); show = true; timeout = setTimeout(() => { show = false }, 3000);
        })" style="position: relative">
            <p class="alert alert-sm alert-info" x-show="show"
                style="padding: .5em 1em; margin-top: 11px; position: absolute; z-index: 9999; width: 200px; right:10%">
                No
                Data
                to Export</p>

            <div class="w-mob-100">
                <button type="button" class="btn mb-1 w-mob-100 py-2 mt-1"
                    style="background: #3682cd; color: #fcf8f8;width:140px; font-size: 17px !important;"
                    wire:click.prevent="export">
                    Export Excel </button>
            </div>
        </div>

    </div>
</div>