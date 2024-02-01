<!-- Data Info Modal -->
<div class="modal fade" id="MstprcTransferStep1Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Transfer Checksheet Step 1</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="mstprc_transfer_no">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input list="mstprc_transfer_machines_no" class="form-control" id="mstprc_transfer_machine_no" maxlength="255">
                <datalist id="mstprc_transfer_machines_no"></datalist>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input list="mstprc_transfer_equipments_no" class="form-control" id="mstprc_transfer_equipment_no" maxlength="255">
                <datalist id="mstprc_transfer_equipments_no"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="mstprc_transfer_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="mstprc_transfer_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="mstprc_transfer_car_model" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="mstprc_transfer_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_transfer_grid" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No.</label>
                <input type="text" class="form-control" id="mstprc_transfer_asset_tag_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>TRD No.</label>
                <input type="text" class="form-control" id="mstprc_transfer_trd_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>NS-IV No.</label>
                <input type="text" class="form-control" id="mstprc_transfer_ns-iv_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Transfer Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="mstprc_transfer_date" required>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Transfer Reason</label>
                <textarea id="mstprc_transfer_reason" class="form-control" style="resize: none;" rows="2" maxlength="255" required></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Transfer From : </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label>
                <input type="text" class="form-control" id="mstprc_transfer_from_car_model" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="mstprc_transfer_from_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_transfer_from_grid" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Transfer To : </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <input list="mstprc_transfer_to_car_models" class="form-control" id="mstprc_transfer_to_car_model" maxlength="255" disabled>
                <datalist id="mstprc_transfer_to_car_models"></datalist>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label><label style="color: red;">*</label>
                <select class="form-control" id="mstprc_transfer_to_location" style="width: 100%;" required></select>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_transfer_to_grid" maxlength="10">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-gray" onclick="clear_mstprc_transfer_step1_fields()">Clear</button>
        <button type="button" class="btn bg-lime" onclick="goto_mstprc_transfer_step2()" id="btnGoMstprcTransferStep2">Next</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->