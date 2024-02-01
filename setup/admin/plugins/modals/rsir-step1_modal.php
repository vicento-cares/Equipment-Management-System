<!-- Data Info Modal -->
<div class="modal fade" id="RsirStep1Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">RSIR Step 1</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="rsir_no">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Kind of Inspection</label><label style="color: red;">*</label>
                <select class="form-control" id="rsir_type" style="width: 100%;" required>
                  <option disabled selected value="">Select Option</option>
                  <option value="Regular">Regular</option>
                  <option value="Special">Special</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>RSIR Date</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="rsir_date" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label>
                <input type="text" class="form-control" id="rsir_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label>
                <input type="text" class="form-control" id="rsir_equipment_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="rsir_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="rsir_process" maxlength="10" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>New Machine</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="0" id="rsir_is_new" disabled>
                  <label class="form-check-label" for="rsir_is_new">
                    New Machine
                  </label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#NeedRsirMachineChecksheetInfoModal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-lime" onclick="goto_rsir_step2()" id="btnGoRsirStep2">Next</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->