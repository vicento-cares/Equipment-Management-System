<!-- Delete Data Modal -->
<div class="modal fade" id="DeclineSchedModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Decline Schedule</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-4">
            <div class="col-sm-12">
              <label>Decline Reason</label><label style="color: red;">*</label>
              <textarea id="u_decline_reason" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your decline reason here" onkeyup="count_decline_reason_char()" required></textarea>
                <span id="u_decline_reason_count"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnDeclineSched" onclick="decline_activity_schedule()" disabled>Decline Schedule</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->