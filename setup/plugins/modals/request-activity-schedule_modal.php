<!-- Data Info Modal -->
<div class="modal fade" id="ReqActSchedModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Set Up Activity Schedule Request Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Propose Date of Activity</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="i_req_activity_date">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <input list="i_req_car_models" class="form-control" id="i_req_car_model" maxlength="255" required>
                <datalist id="i_req_car_models"></datalist>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Requestor Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_req_requestor_name" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Request Details</label>
                <textarea id="i_req_request_details" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your request details here" onkeyup="count_request_details_char()" required></textarea>
                <span id="i_req_request_details_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lime" id="btnSendReqActSched" onclick="send_req_act_sched()" disabled>Request</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->