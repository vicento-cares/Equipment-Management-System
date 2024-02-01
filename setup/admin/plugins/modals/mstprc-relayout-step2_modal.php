<!-- Data Info Modal -->
<div class="modal fade" id="MstprcRelayoutStep2Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Re-layout Checksheet Step 2</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>MSTPRC No. : </label>
              <span id="mstprc_relayout_no2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Re-layout Date : </label>
              <span id="mstprc_relayout_date2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine Name : </label>
              <span id="mstprc_relayout_machine_name2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine No. : </label>
              <span id="mstprc_relayout_machine_no2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Car Model : </label>
              <span id="mstprc_relayout_car_model2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Equipment No. : </label>
              <span id="mstprc_relayout_equipment_no2"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Upload MSTPRC Here</label><label style="color: red;">*</label><br>
              <input type="file" id="mstprc_relayout_file" name="mstprc_relayout_file" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#MstprcRelayoutStep1Modal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-gray" id="btnDownloadMstprcRelayoutFormat" onclick="download_mstprc_relayout_format()">Download Checksheet Template</button>
        <button type="button" class="btn bg-lime" id="btnSaveMstprcRelayout" onclick="check_mstprc_relayout_file()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->