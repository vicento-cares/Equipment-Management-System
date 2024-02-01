<!-- Data Info Modal -->
<div class="modal fade" id="MstprcPulloutStep1Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Pullout Checksheet Step 1</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="mstprc_pullout_no">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input list="mstprc_pullout_machines_no" class="form-control" id="mstprc_pullout_machine_no" maxlength="255">
                <datalist id="mstprc_pullout_machines_no"></datalist>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input list="mstprc_pullout_equipments_no" class="form-control" id="mstprc_pullout_equipment_no" maxlength="255">
                <datalist id="mstprc_pullout_equipments_no"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="mstprc_pullout_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="mstprc_pullout_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="mstprc_pullout_car_model" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="mstprc_pullout_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_pullout_grid" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No.</label>
                <input type="text" class="form-control" id="mstprc_pullout_asset_tag_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>TRD No.</label>
                <input type="text" class="form-control" id="mstprc_pullout_trd_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>NS-IV No.</label>
                <input type="text" class="form-control" id="mstprc_pullout_ns-iv_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Pullout Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="mstprc_pullout_date" required>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Pullout Reason</label>
                <textarea id="mstprc_pullout_reason" class="form-control" style="resize: none;" rows="2" maxlength="255" required></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Location</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="mstprc_pullout_machine_location" maxlength="255" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-gray" onclick="clear_mstprc_pullout_step1_fields()">Clear</button>
        <button type="button" class="btn bg-lime" onclick="goto_mstprc_pullout_step2()" id="btnGoMstprcPulloutStep2">Next</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->