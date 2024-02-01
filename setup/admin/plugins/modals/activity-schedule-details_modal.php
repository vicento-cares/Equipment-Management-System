<!-- Data Info Modal -->
<div class="modal fade" id="ActSchedInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Set Up Activity Schedule Info</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="u_id">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Date of Activity</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="u_activity_date">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Activity Schedule Details</label>
                <textarea id="u_act_sched_details" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your activity schedule details here" onkeyup="count_act_sched_details_char_update()" required></textarea>
                <span id="u_act_sched_details_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lime" id="btnUpdateActSched" onclick="update_act_sched()">Update Activity</button>
        <button type="button" class="btn btn-danger" id="btnDeleteActSched" data-dismiss="modal" data-toggle="modal" data-target="#deleteActSchedModal">Delete Activity</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->