<div class="modal fade" id="exampleModalCenter" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:500px;">
        <div class="modal-content" style="height: 200px;">
            <div class="modal-header">
                <h5 class="modal-title">Axis Bank</h5>
                <div class="right">
                    <button type="button" class="btn btn-success green" onclick="adddata();">Save</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 center">
                        <div class="form-group">
                            <label class="form-control-label" for="input-phone">Upload Excel</label>
                            <form>
                                <fieldset class="form-group">
                                    <input style="width:100%" type="file" class="form-control-file" id="excel_file"
                                        name="excel_file">
                                    <span class="alignmentcss" id="excel_fileerror"></span>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <button type="button" class="btn btn-success green" onclick="adddata();">Save</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>