<!-- Delete Data Modal -->
<div class="modal fade" id="MachineChecksheetDisapproveModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Disapprove Checksheet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="setTimeout(() => {$('#PendingMachineChecksheetInfoModal').modal('show');}, 400);">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-4">
            <div class="col-sm-12">
              <label>Disapprove Comment</label><label style="color: red;">*</label>
              <textarea id="u_disapproved_comment" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your disapprove comment here" onkeyup="count_disapproved_comment_char()" required></textarea>
                <span id="u_disapproved_comment_count"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#PendingMachineChecksheetInfoModal').modal('show');}, 400);">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnDisapproveCMstprc" onclick="disapprove_pending_rsir()" disabled>Disapprove Checksheet</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->