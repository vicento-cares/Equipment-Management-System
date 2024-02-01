<!-- Data Info Modal -->
<div class="modal fade" id="PmStickerUpdateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Update PM Sticker Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-6">
              <label>Next PM Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="u_ww_next_date_update" required>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Shift Engineer</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_shift_engineer_update" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <label>Checked Rows : </label>
              <span id="rows_selected"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnUpdatePmStickerContent" onclick="update_pm_sticker_content()">Update PM Sticker Content</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->