<!-- Data Info Modal -->
<div class="modal fade" id="PmConcernUpdateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">PM Concern Details</h4>
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
                <label>Machine Line</label><label style="color: red;">*</label>
                <select class="form-control" id="u_machine_line" style="width: 100%;" required></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Problem</label><label style="color: red;">*</label>
                <textarea id="u_problem" class="form-control" style="resize: none;" rows="3" maxlength="255" onkeyup="count_u_problem_char()" required></textarea>
                <span id="u_problem_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnSavePmConcern" onclick="update_pm_concern()" disabled>Save PM Concern</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->