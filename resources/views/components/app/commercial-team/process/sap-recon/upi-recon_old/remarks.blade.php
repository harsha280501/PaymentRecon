<div class="w-100" style="flex: 1 !important" x-data="{
    show: true
}">
    <label for="">Reason / Remarks</label>
    <template x-if="show == false">
        <div style="display: flex; justify-content: flex-start; align-items: center; padding-left: 5px !important; padding-right: 0 !important" class="form-control">
            <input style="width: 95%; height: inherit; background: transparent; border: none; outline: none; flex: 1" x-model="recon.remarks" type="text" data-name="remarks" id="exampleInputConfirmPassword1" placeholder="Remarks">
            <button style="background: lightgray; width: 5%; border: none; font-size: 1.2em; height: inherit; border-bottom-right-radius: inherit; border-top-right-radius: inherit" @click="show = true"><i class="fa fa-close"></i></button>
        </div>
    </template>

    <template x-if="show == true">
        <div x-show="show" style="width: inherit !important" class="my-1" x-model="recon.remarks">
            <select style="width: inherit !important" x-on:change="(e) => {
                console.log('Changed');
                if (e.target.value != 'Others') {                   
                    recon['remarks'] = e.target.value
                } else {
                    show = false
                }
            }" class="form-control ">
                <option value="">SELECT REMARKS</option>
                @foreach ($remarks as $remark)
                <option value="{{ $remark }}">{{ $remark }}</option>
                @endforeach
                <option value="Others">Others</option>
            </select>
        </div>
    </template>
</div>
