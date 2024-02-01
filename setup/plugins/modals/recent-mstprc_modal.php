<!-- Data Info Modal -->
<div class="modal fade" id="MachineChecksheetInfoModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Recent Machine Checksheet</h4>
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
              <label>MSTPRC No. : </label>
              <span id="recent_mstprc_no"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Checksheet Type : </label>
              <span id="recent_mstprc_type"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine Name : </label>
              <span id="recent_mstprc_machine_name"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Machine No. : </label>
              <span id="recent_mstprc_machine_no"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Line / Car Model : </label>
              <span id="recent_mstprc_line_car_model"></span>
              <input type="hidden" id="recent_mstprc_car_model">
              <input type="hidden" id="recent_mstprc_location">
              <input type="hidden" id="recent_mstprc_grid">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Equipment No. : </label>
              <span id="recent_mstprc_equipment_no"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Date Setup / Transfer / Pullout / Relayout : </label>
              <span id="recent_mstprc_date"></span>
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
              <label>Person In-charge (Equipment Member) : </label>
              <span id="recent_mstprc_eq_member"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Checked By (Safety Officer) : </label>
              <span id="recent_mstprc_safety_officer"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Confirmed By (Equipment Group Leader) : </label>
              <span id="recent_mstprc_eq_g_leader"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Approved By (Production Engineering Manager) : </label>
              <span id="recent_mstprc_prod_engr_manager"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Recorded By (Spare Parts Personnnel) : </label>
              <span id="recent_mstprc_eq_sp_personnel"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Noted By (Equipment Manager) : </label>
              <span id="recent_mstprc_eq_manager"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Received By (INITIAL) (Production Supervisor / Production Manager) : </label>
              <span id="recent_mstprc_prod_supervisor_manager"></span>
              <input type="hidden" id="recent_mstprc_prod_supervisor">
              <input type="hidden" id="recent_mstprc_prod_manager">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Received By (FINAL) (QA Supervisor / QA Manager) : </label>
              <span id="recent_mstprc_qa_supervisor_manager"></span>
              <input type="hidden" id="recent_mstprc_qa_supervisor">
              <input type="hidden" id="recent_mstprc_qa_manager">
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>MACHINE TRANSFER</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Transfer From </label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Transfer To </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>From Line / Car Model : </label>
              <span id="recent_mstprc_from_line_car_model"></span>
              <input type="hidden" id="recent_mstprc_from_car_model">
              <input type="hidden" id="recent_mstprc_from_location">
              <input type="hidden" id="recent_mstprc_from_grid">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>To Line / Car Model : </label>
              <span id="recent_mstprc_to_line_car_model"></span>
              <input type="hidden" id="recent_mstprc_to_car_model">
              <input type="hidden" id="recent_mstprc_to_location">
              <input type="hidden" id="recent_mstprc_to_grid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Transfer Reason : </label>
              <span id="recent_mstprc_transfer_reason"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>MACHINE PULLOUT</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Pullout Location : </label>
              <span id="recent_mstprc_pullout_location"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Pullout Reason : </label>
              <span id="recent_mstprc_pullout_reason"></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Uploaded MSTPRC Filename</label><br>
              <span id="recent_mstprc_file_name"></span>
              <input type="hidden" id="recent_mstprc_file_url">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gray" id="btnDownloadRecentMstprc" onclick="download_mstprc()">Download Checksheet</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->