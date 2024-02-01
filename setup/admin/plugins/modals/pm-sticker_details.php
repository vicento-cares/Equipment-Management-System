<!-- Data Info Modal -->
<div class="modal fade" id="PmStickerContentModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">PM Sticker Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>PM Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="u_ww_start_date" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Next PM Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="u_ww_next_date" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label>
                <input type="text" class="form-control" id="u_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label>
                <input type="text" class="form-control" id="u_equipment_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="u_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <!-- <div class="col-sm-4">
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="u_process" maxlength="10" disabled>
              </div>
            </div> -->
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Manpower</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_manpower" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Shift Engineer</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_shift_engineer" maxlength="255" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#RsirStep2Modal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-lime" onclick="print_single_pm_sticker()">Print PM Sticker</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->