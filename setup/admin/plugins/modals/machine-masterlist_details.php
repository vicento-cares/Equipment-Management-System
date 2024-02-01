<!-- Data Info Modal -->
<div class="modal fade" id="MachineInfoModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Machine Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <select class="form-control" id="u_machine_name" style="width: 100%;" onchange="get_machine_details('update')" disabled></select>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Number</label>
                <input type="number" class="form-control" id="u_number" min="1" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <select class="form-control" id="u_process" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Process</option>
                  <option value="Initial">Initial</option>
                  <option value="Final">Final</option>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>New Machine</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="0" id="u_is_new" disabled>
                  <label class="form-check-label" for="u_is_new">
                    New Machine
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Specification</label>
                <input type="text" class="form-control" id="u_machine_spec" maxlength="255" disabled>
              </div>
            </div>
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
          </div>
          <div class="row">
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label><label style="color: red;">*</label>
                <select class="form-control" id="u_location" style="width: 100%;" required></select>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="u_grid" maxlength="10">
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <input list="u_car_models" class="form-control" id="u_car_model" maxlength="255" onchange="get_car_model_details('update')" required>
                <datalist id="u_car_models"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_asset_tag_no" maxlength="255">
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>TRD No.</label>
                <input type="text" class="form-control" id="u_trd_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>NS-IV No.</label>
                <input type="text" class="form-control" id="u_ns-iv_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
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
        <button type="button" class="btn bg-lime" id="btnUpdateMachine" onclick="update_data()">Update Machine</button>
        <!-- <button type="button" class="btn bg-lime" id="btnUpdateAssetTagNo" onclick="update_asset_tag_no()">Update Asset Tag No.</button> -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->