<!-- Approver Modal -->
<div class="modal fade" id="RecentPmConcernHistoryInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">PM Concern History Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_history_id">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Machine Line : </label>
              <span id="u_history_machine_line"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>PM Concern ID : </label>
              <span id="u_history_pm_concern_id"></span>
            </div>
            <div class="form-group">
              <label>Date & Time : </label>
              <span id="u_history_concern_date_time"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Request By : </label>
              <span id="u_history_request_by"></span>
            </div>
            <div class="form-group">
              <label>Confirm By : </label>
              <span id="u_history_confirm_by"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Problem : </label>
              <span id="u_history_problem"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Comment : </label>
              <span id="u_history_comment"></span>
            </div>
          </div>
        </div>
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