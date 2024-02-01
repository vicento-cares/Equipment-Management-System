<!-- Data Info Modal -->
<div class="modal fade" id="ReqActSchedInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Requested Set Up Activity Schedule Info</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_req_id">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Date of Activity</label>
                <input type="date" class="form-control" id="u_req_activity_date" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_req_car_model" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Requestor Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_req_requestor_name" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Activity Schedule Details</label>
                <textarea id="u_req_act_sched_details" class="form-control" style="resize: none;" rows="3" maxlength="255" disabled></textarea>
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