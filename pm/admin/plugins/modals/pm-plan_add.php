<!-- Data Info Modal -->
<div class="modal fade" id="AddSinglePmPlanModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Add Single PM Plan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input list="i_machines_no" class="form-control" id="i_machine_no" maxlength="255">
                <datalist id="i_machines_no"></datalist>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input list="i_equipments_no" class="form-control" id="i_equipment_no" maxlength="255">
                <datalist id="i_equipments_no"></datalist>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>TRD No.</label>
                <input type="text" class="form-control" id="i_trd_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>NS-IV No.</label>
                <input type="text" class="form-control" id="i_ns-iv_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="i_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Specification</label>
                <input type="text" class="form-control" id="i_machine_spec" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="i_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="i_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="i_grid" maxlength="10" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="i_car_model" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label>PM Plan Year</label><label style="color: red;">*</label>
              <input list="i_pm_plan_years" class="form-control" id="i_pm_plan_year" maxlength="4">
              <datalist id="i_pm_plan_years"></datalist>
            </div>
            <div class="col-sm-3">
              <label>Work Week No.</label><label style="color: red;">*</label>
              <input list="i_all_ww_no" class="form-control" id="i_ww_no" maxlength="4">
              <datalist id="i_all_ww_no"></datalist>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Frequency</label><label style="color: red;">*</label>
                <select class="form-control" id="i_frequency" style="width: 100%;">
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
              <input type="date" class="form-control" id="i_ww_start_date">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" onclick="save_single_pm_plan()">Add PM Plan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->