<!-- Upload CSV Modal -->
<div class="modal fade" id="WorkOrderDetailsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Work Order Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_id">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Machine No. : </label>
              <span id="u_machine_no"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Equipment No. : </label>
              <span id="u_equipment_no"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Machine Name : </label>
              <span id="u_machine_name"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Process : </label>
              <span id="u_process"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Uploaded Work Order Filename : </label>
              <span id="u_file_name"></span>
              <input type="hidden" id="u_file_url">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>WO ID : </label>
              <span id="u_wo_id"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" onclick="download_work_order()">Download Work Order</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->