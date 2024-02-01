<!-- Data Info Modal -->
<div class="modal fade" id="SouInfoHistoryModal" data-backdrop="static" data-keyboard="false">
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
          <input type="hidden" id="sou_id">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>SOU No. : </label>
                <span id="sou_no"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Kigyo No. : </label>
                <span id="sou_kigyo_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Asset Name : </label>
                <span id="sou_asset_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Supplementary Asset Name : </label>
                <span id="sou_sup_asset_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Original Asset No. : </label>
                <span id="sou_orig_asset_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Start of Utilization Date : </label>
                <span id="sou_date"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Quantity : </label>
                <span id="sou_quantity"></span>
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
                <span id="sou_managing_dept_code"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name : </label>
                <span id="sou_managing_dept_name"></span>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Code : </label>
                <span id="sou_install_area_code"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Name : </label>
                <span id="sou_install_area_name"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Machine No. : </label>
                <span id="sou_machine_no"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Equipment No. : </label>
                <span id="sou_equipment_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>No. of Units : </label>
                <span id="sou_no_of_units"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Need to Convert or Standalone : </label>
                <span id="sou_ntc_or_sa"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Use Purpose : </label>
                <span id="sou_use_purpose"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->