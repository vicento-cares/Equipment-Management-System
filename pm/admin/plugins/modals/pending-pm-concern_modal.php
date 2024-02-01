<!-- Data Info Modal -->
<div class="modal fade" id="PendingPmConcernModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Pending PM Concern Form</h4>
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
                <label>Comment</label><label style="color: red;">*</label>
                <textarea id="u_pending_comment" class="form-control" style="resize: none;" rows="3" maxlength="255" onkeyup="count_u_pending_comment_char()" required></textarea>
                <span id="u_pending_comment_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" id="btnSetPendingPmConcern" onclick="set_pending_pm_concern()" disabled>Set as Pending</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->