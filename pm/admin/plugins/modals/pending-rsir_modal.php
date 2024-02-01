<!-- Data Info Modal -->
<div class="modal fade" id="PendingMachineChecksheetInfoModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Pending Machine Checksheet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>GENERAL DETAILS</label>
            </div>
          </div>
        </div>
        <div class="row">
          <input type="hidden" id="pending_rsir_approver_role">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>RSIR No. : </label>
              <span id="pending_rsir_no" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Kind of Inspection : </label>
              <span id="pending_rsir_type" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine Name : </label>
              <span id="pending_rsir_machine_name" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine No. : </label>
              <span id="pending_rsir_machine_no" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Equipment No. : </label>
              <span id="pending_rsir_equipment_no" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Implementation / Execution Date : </label>
              <span id="pending_rsir_date" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>APPROVERS</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Judgement of Equipment : </label>
              <span id="pending_rsir_judgement_of_eq" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Judgement of Product : </label>
              <span id="pending_rsir_judgement_of_prod" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Detail of Repair : </label>
              <span id="pending_rsir_repair_details" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Inspected By : </label>
              <span id="pending_rsir_inspected_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Repair Date : </label>
              <span id="pending_rsir_repair_date" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Confirmed By : </label>
              <span id="pending_rsir_confirmed_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Repaired By : </label>
              <span id="pending_rsir_repaired_by" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Judgement By : </label>
              <span id="pending_rsir_judgement_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Next PM Date : </label>
              <span id="pending_rsir_next_pm_date" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Uploaded RSIR Filename</label><br>
              <span id="pending_rsir_file_name"></span>
              <input type="hidden" id="pending_rsir_file_url">
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <div class="form-group mb-0">
              <label id="legend_rsir_judgement_of_eq">Judgement of Equipment - Describing Symbols</label><label style="color: red;">*</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-sm-12">
            <div class="form-group">
              <label class="h4" for="legend_ok_rsir_judgement_of_eq">◯</label>
              <span>Normal / OK</span>
            </div>
          </div>
          <div class="col-lg-2 col-sm-12">
            <div class="form-group">
              <label class="h4" for="legend_adj_rsir_judgement_of_eq">△</label>
              <span>Adjust, Clean</span>
            </div>
          </div>
          <div class="col-lg-1 col-sm-12">
            <div class="form-group">
              <label class="h4" for="legend_ng_rsir_judgement_of_eq">X</label>
              <span>NG</span>
            </div>
          </div>
          <div class="col-lg-4 col-sm-12">
            <div class="form-group">
              <label class="h4" for="legend_na_rsir_judgement_of_eq">／</label>
              <span>Not applicable</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-sm-12">
            <div class="form-group mb-0">
              <p id="cont_rsir_judgement_of_eq">Judgement of Equipment</p>
            </div>
          </div>
          <div class="col-lg-1 col-sm-12">
            <div class="form-group mb-0">
              <input type="radio" id="ok_rsir_judgement_of_eq" name="rsir_judgement_of_eq" value="◯">
              <label class="h4" for="ok_rsir_judgement_of_eq">◯</label>
            </div>
          </div>
          <div class="col-lg-1 col-sm-12">
            <div class="form-group mb-0">
              <input type="radio" id="adj_rsir_judgement_of_eq" name="rsir_judgement_of_eq" value="△">
              <label class="h4" for="adj_rsir_judgement_of_eq">△</label>
            </div>
          </div>
          <div class="col-lg-1 col-sm-12">
            <div class="form-group mb-0">
              <input type="radio" id="ng_rsir_judgement_of_eq" name="rsir_judgement_of_eq" value="X">
              <label class="h4" for="ng_rsir_judgement_of_eq">X</label>
            </div>
          </div>
          <div class="col-lg-1 col-sm-12">
            <div class="form-group mb-0">
              <input type="radio" id="na_rsir_judgement_of_eq" name="rsir_judgement_of_eq" value="／">
              <label class="h4" for="na_rsir_judgement_of_eq">／</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gray" id="btnDownloadPendingRsir" onclick="download_pending_rsir(1)">Download Checksheet</button>
        <button type="button" class="btn bg-danger" id="btnReturnPendingRsir" onclick="return_pending_rsir()">Return Checksheet</button>
        <button type="button" class="btn bg-warning" id="btnConfirmPendingRsir" onclick="confirm_pending_rsir()" disabled>Confirm Checksheet</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->