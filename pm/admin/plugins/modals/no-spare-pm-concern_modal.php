<!-- Data Info Modal -->
<div class="modal fade" id="NoSparePmConcernModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">No Spare PM Concern</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_no_spare_pending_id">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>PM Concern ID : </label>
              <span id="u_no_spare_pm_concern_id"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Date & Time : </label>
              <span id="u_no_spare_concern_date_time"></span>
            </div>
          </div>
        </div>
        <div class="table-responsive" style="max-height: 175px; overflow: auto; display:inline-block;">
          <table id="NoSparePmConcernPartsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
            <thead style="text-align: center;">
              <tr>
                <th>No.</th>
                <th>PM Concern ID</th>
                <th>Machine Line</th>
                <th>Problem</th>
                <th>Request By</th>
                <th>Confirm By</th>
                <th>Comment</th>
                <th>Parts Code</th>
                <th>Quantity</th>
                <th>PO Date</th>
                <th>PO Number</th>
                <th>No Spare Status</th>
                <th>Date Arrived</th>
                <th>Date & Time</th>
              </tr>
            </thead>
            <tbody id="NoSparePmConcernPartsData" style="text-align: center;"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnSetDoneNoSparePmConcern" onclick="set_done_no_spare_pm_concern()" disabled>Set as Done</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->