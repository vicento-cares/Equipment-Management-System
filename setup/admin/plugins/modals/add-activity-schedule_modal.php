<!-- Data Info Modal -->
<div class="modal fade" id="AddActSchedModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Add Set Up Activity Schedule</h4>
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
                <label>Date of Activity</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="i_activity_date">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Activity Schedule Details</label>
                <textarea id="i_act_sched_details" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your activity schedule details here" onkeyup="count_act_sched_details_char_insert()" required></textarea>
                <span id="i_act_sched_details_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lime" id="btnSaveActSched" onclick="save_act_sched()" disabled>Add Activity</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->