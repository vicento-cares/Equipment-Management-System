<!-- Data Info Modal -->
<div class="modal fade" id="WWUpdateContentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Update Work Week Manpower</h4>
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
                <label>Manpower</label>
                <select class="form-control" id="u_manpower_update" style="width: 100%;"></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <label>Checked Rows : </label>
              <span id="rows_selected"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-lime" id="btnUpdateWWManpower" onclick="update_ww_manpower()">Update WW Manpower</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->