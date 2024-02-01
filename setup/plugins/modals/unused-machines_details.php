<!-- Data Info Modal -->
<div class="modal fade" id="UnusedMachineInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Unused Machine Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_id">
        <form>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_equipment_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="u_car_model" maxlength="255" disabled>
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
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No.</label>
                <input type="text" class="form-control" id="u_asset_tag_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Status</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_status" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Reserved For</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_reserved_for" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Remarks</label>
                <input type="text" class="form-control" id="u_remarks" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>PIC</label><label style="color: red;">*</label>
                <select class="form-control" id="u_pic" style="width: 100%;" disabled></select>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Target Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="u_target_date" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Unused Machine Location</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_unused_machine_location" maxlength="255" disabled>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->