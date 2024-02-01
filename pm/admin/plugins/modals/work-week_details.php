<!-- Data Info Modal -->
<div class="modal fade" id="WWContentModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Work Week Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <label>PM Plan Year</label>
                <input type="text" class="form-control" id="u_pm_plan_year" maxlength="4" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label>Work Week No.</label>
                <input type="text" class="form-control" id="u_ww_no" maxlength="4" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Start Date & Time</label><label style="color: red;">*</label>
                <input type="datetime-local" class="form-control" id="u_sched_start_date_time" required>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>End Date & Time</label><label style="color: red;">*</label>
                <input type="datetime-local" class="form-control" id="u_sched_end_date_time" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label>
                <input type="text" class="form-control" id="u_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label>
                <input type="text" class="form-control" id="u_equipment_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Frequency</label>
                <input type="text" class="form-control" id="u_frequency" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="u_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="u_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="u_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="u_car_model" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Work Week Start Date</label>
                <input type="date" class="form-control" id="u_ww_start_date" disabled>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Manpower</label>
                <select class="form-control" id="u_manpower" style="width: 100%;" disabled></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>PM Status</label>
                <input type="text" class="form-control" id="u_pm_status" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Machine Status</label>
                <input type="text" class="form-control" id="u_machine_status" maxlength="100" disabled>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnUpdateWWContent" onclick="update_ww_content()">Update WW Content</button>
        <button type="button" class="btn bg-lime" id="btnSetAsDoneWW" onclick="set_as_done_ww()" style="display:none;" disabled>Set as Done</button>
        <button type="button" class="btn bg-lime" id="btnConfirmAsDoneWW" onclick="confirm_as_done_ww()">Confirm as Done</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->