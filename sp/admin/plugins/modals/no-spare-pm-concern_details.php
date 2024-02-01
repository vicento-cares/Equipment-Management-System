<!-- Approver Modal -->
<div class="modal fade" id="NoSparePmConcernInfoModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">No Spare PM Concern Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="setTimeout(() => {$('#NoSparePmConcernModal').modal('show');}, 400);">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_no_spare_id">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Machine Line : </label>
              <span id="u_no_spare_machine_line"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>PM Concern ID : </label>
              <span id="u_no_spare_pm_concern_id2"></span>
            </div>
            <div class="form-group mb-0">
              <label>Date & Time : </label>
              <span id="u_no_spare_concern_date_time2"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group mb-0">
              <label>Request By : </label>
              <span id="u_no_spare_request_by"></span>
            </div>
            <div class="form-group mb-0">
              <label>Confirm By : </label>
              <span id="u_no_spare_confirm_by"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Problem : </label>
              <span id="u_no_spare_problem"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group mb-0">
              <label>Comment : </label>
              <span id="u_no_spare_comment_view"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Parts Code : </label>
              <span id="u_no_spare_parts_code"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Quantity : </label>
              <span id="u_no_spare_quantity"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>PO Date</label>
              <input type="date" class="form-control" id="u_no_spare_po_date" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>PO No.</label>
              <input type="text" class="form-control" id="u_no_spare_po_no" maxlength="255" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>No Spare Status</label>
              <input type="text" class="form-control" id="u_no_spare_status" maxlength="255" disabled>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Date Arrived</label>
              <input type="date" class="form-control" id="u_no_spare_date_arrived" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#NoSparePmConcernModal').modal('show');}, 400);">Close</button>
        <button type="button" class="btn bg-lime" onclick="save_no_spare_details()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->