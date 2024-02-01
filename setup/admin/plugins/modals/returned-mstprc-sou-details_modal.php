<!-- Data Info Modal -->
<div class="modal fade" id="ReturnedSouInfoModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Start of Utilization (SOU)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="setTimeout(() => {$('#ReturnedMachineChecksheetInfoModal').modal('show');}, 400);">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="returned_sou_info_id">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>SOU No. : </label>
                <span id="returned_sou_info_no"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Kigyo No. : </label>
                <span id="returned_sou_info_kigyo_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Asset Name : </label>
                <span id="returned_sou_info_asset_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Supplementary Asset Name : </label>
                <span id="returned_sou_info_sup_asset_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Original Asset No. : </label>
                <span id="returned_sou_info_orig_asset_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Start of Utilization Date : </label>
                <span id="returned_sou_info_date"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Quantity : </label>
                <span id="returned_sou_info_quantity"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Managing Department</label>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Installation Area</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Code : </label>
                <span id="returned_sou_info_managing_dept_code"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name : </label>
                <span id="returned_sou_info_managing_dept_name"></span>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Code : </label>
                <span id="returned_sou_info_install_area_code"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name : </label>
                <span id="returned_sou_info_install_area_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Machine No. : </label>
                <span id="returned_sou_info_machine_no"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Equipment No. : </label>
                <span id="returned_sou_info_equipment_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>No. of Units : </label>
                <span id="returned_sou_info_no_of_units"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Need to Convert or Standalone : </label>
                <span id="returned_sou_info_ntc_or_sa"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Use Purpose : </label>
                <span id="returned_sou_info_use_purpose"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#ReturnedMachineChecksheetInfoModal').modal('show');}, 400);">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->