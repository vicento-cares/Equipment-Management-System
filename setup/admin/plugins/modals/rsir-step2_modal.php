<!-- Data Info Modal -->
<div class="modal fade" id="RsirStep2Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">RSIR Step 2</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>RSIR No. : </label>
              <span id="rsir_no2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Kind of Inspection : </label>
              <span id="rsir_type2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine Name : </label>
              <span id="rsir_machine_name2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine No. : </label>
              <span id="rsir_machine_no2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Equipment No. : </label>
              <span id="rsir_equipment_no2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Implementation / Execution Date : </label>
              <span id="rsir_date2"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Approver</label><label style="color: red;">*</label>
              <select class="form-control" id="rsir_approver_role" style="width: 100%;" required>
                <option disabled selected value="">Select Approver</option>
                <option value="Prod">Production</option>
                <option value="QA">QA</option>
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Next PM Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="rsir_next_pm_date">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Detail of Repair</label><label style="color: red;">*</label>
              <input type="text" class="form-control" id="rsir_repair_details" maxlength="255">
            </div>
          </div>
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Repair Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="rsir_repair_date">
            </div>
          </div>
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Repaired by</label><label style="color: red;">*</label>
              <input type="text" class="form-control" id="rsir_repaired_by" maxlength="255">
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Upload RSIR Here</label><label style="color: red;">*</label><br>
              <input type="file" id="rsir_file" name="rsir_file" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#RsirStep1Modal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-warning" id="btnGoPmSticker" onclick="goto_pm_sticker()">Create PM Sticker</button>
        <button type="button" class="btn bg-gray" id="btnDownloadRsirFormat" onclick="download_rsir_format()">Download Checksheet Template</button>
        <button type="button" class="btn bg-lime" id="btnSaveRsir" onclick="save_rsir()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->