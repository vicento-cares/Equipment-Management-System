<!-- Data Info Modal -->
<div class="modal fade" id="SinglePmPlanInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Single PM Plan Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_machine_no" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_equipment_no" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>TRD No.</label>
                <input type="text" class="form-control" id="u_trd_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>NS-IV No.</label>
                <input type="text" class="form-control" id="u_ns-iv_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="u_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Specification</label>
                <input type="text" class="form-control" id="u_machine_spec" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="u_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="u_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="u_grid" maxlength="10" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="u_car_model" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label>PM Plan Year</label><label style="color: red;">*</label>
              <input list="u_pm_plan_years" class="form-control" id="u_pm_plan_year" maxlength="4">
              <datalist id="u_pm_plan_years"></datalist>
            </div>
            <div class="col-sm-3">
              <label>Work Week No.</label><label style="color: red;">*</label>
              <input list="u_all_ww_no" class="form-control" id="u_ww_no" maxlength="4">
              <datalist id="u_all_ww_no"></datalist>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Frequency</label><label style="color: red;">*</label>
                <select class="form-control" id="u_frequency" style="width: 100%;">
                  <option disabled selected value="">Select Frequency</option>
                  <option value="W">Weekly</option>
                  <option value="M">Monthly</option>
                  <option value="2">2 Months</option>
                  <option value="3">3 Months</option>
                  <option value="6">6 Months</option>
                  <option value="Y">Yearly</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <label>Work Week Start Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="u_ww_start_date">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Status</label>
                <select class="form-control" id="u_machine_status" style="width: 100%;">
                  <option selected value="">None</option>
                  <option value="SETUP">SETUP</option>
                  <option value="PULLED-OUT">PULLED-OUT</option>
                  <option value="UNUSED">UNUSED</option>
                  <option value="DISPOSED">DISPOSED / DISMANTLED</option>
                  <option value="BORROWED">BORROWED</option>
                  <option value="SOLD">SOLD</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>PM Status</label>
                <input type="text" class="form-control" id="u_pm_status" maxlength="100" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <label>Internal Comment</label>
              <textarea id="u_internal_comment" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your internal comment here" onkeyup="count_internal_comment_char()" required></textarea>
                <span id="u_internal_comment_count"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnUpdateSinglePmPlan" onclick="update_single_pm_plan()">Update PM Plan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->