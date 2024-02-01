<!-- Data Info Modal -->
<div class="modal fade" id="MstprcSetupSouModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Set Up Checksheet - Start of Utilization (SOU)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="mstprc_setup_sou_no">
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Kigyo No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="mstprc_setup_kigyo_no" maxlength="255">
              </div>
            </div>
            <div class="col-sm-5">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Name</label>
                <input type="text" class="form-control" id="mstprc_setup_asset_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Supplementary Asset Name</label>
                <input type="text" class="form-control" id="mstprc_setup_sup_asset_name" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Original Asset No.</label>
                <input type="text" class="form-control" id="mstprc_setup_orig_asset_no" maxlength="255">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Start of Utilization Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="mstprc_setup_sou_date" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Quantity</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="mstprc_setup_sou_quantity" min="1">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Managing Department</label><label style="color: red;">*</label>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Installation Area</label><label style="color: red;">*</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Code</label>
                <input type="text" class="form-control" id="mstprc_setup_managing_dept_code" maxlength="255">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="mstprc_setup_managing_dept_name" maxlength="255">
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Code</label>
                <input type="text" class="form-control" id="mstprc_setup_install_area_code" maxlength="255">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="mstprc_setup_install_area_name" maxlength="255">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label>
                <input type="text" class="form-control" id="mstprc_setup_sou_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label>
                <input type="text" class="form-control" id="mstprc_setup_sou_equipment_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>No. of Units</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="mstprc_setup_no_of_units" min="1">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Need to Convert or Standalone</label><label style="color: red;">*</label>
                <select class="form-control" id="mstprc_setup_ntc_or_sa" style="width: 100%;" required>
                  <option disabled selected value="">Select Options</option>
                  <option value="Need To Convert">Need To Convert</option>
                  <option value="Standalone">Standalone</option>
                </select>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Use Purpose</label><label style="color: red;">*</label>
                <textarea id="mstprc_setup_use_purpose" class="form-control" style="resize: none;" rows="2" maxlength="255" required></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#MstprcSetupFatModal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-gray" onclick="clear_mstprc_setup_sou_fields()">Clear</button>
        <button type="button" class="btn bg-lime" onclick="save_mstprc_setup_2()" id="btnSaveMstprcSetup">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->