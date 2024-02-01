<!-- Data Info Modal -->
<div class="modal fade" id="MachineChecksheetInfoHistoryModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Machine Checksheet History</h4>
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
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>RSIR No. : </label>
              <span id="history_rsir_no2" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Kind of Inspection : </label>
              <span id="history_rsir_type2" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine Name : </label>
              <span id="history_rsir_machine_name2" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine No. : </label>
              <span id="history_rsir_machine_no2" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Equipment No. : </label>
              <span id="history_rsir_equipment_no2" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Implementation / Execution Date : </label>
              <span id="history_rsir_date2" class="ml-2"></span>
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
              <span id="history_rsir_judgement_of_eq" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Judgement of Product : </label>
              <span id="history_rsir_judgement_of_prod" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Detail of Repair : </label>
              <span id="history_rsir_repair_details" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Inspected By : </label>
              <span id="history_rsir_inspected_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Repair Date : </label>
              <span id="history_rsir_repair_date" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Confirmed By : </label>
              <span id="history_rsir_confirmed_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Repaired By : </label>
              <span id="history_rsir_repaired_by" class="ml-2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Judgement By : </label>
              <span id="history_rsir_judgement_by" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Next PM Date : </label>
              <span id="history_rsir_next_pm_date" class="ml-2"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Uploaded RSIR Filename</label><br>
              <span id="history_rsir_file_name"></span>
              <input type="hidden" id="history_rsir_file_url">
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Disapproval Information</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Disappproved By : </label>
              <span id="history_rsir_disapproved_by"></span>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Disapproved Role : </label>
              <span id="history_rsir_disapproved_by_role"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Disapproved Comment : </label><br>
              <span id="history_rsir_disapproved_comment"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gray" id="btnDownloadRsirHistory" onclick="download_rsir_history()">Download Checksheet</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->