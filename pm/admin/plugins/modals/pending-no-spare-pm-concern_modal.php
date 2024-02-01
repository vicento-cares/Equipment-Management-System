<!-- Data Info Modal -->
<div class="modal fade" id="PendingNoSparePmConcernModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Pending No Spare PM Concern Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Parts Code</label>
              <input type="text" class="form-control" id="i_parts_code" maxlength="255" required>
            </div>
          </div>
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Quantity</label>
              <input type="number" class="form-control" id="i_quantity" min="1" required>
            </div>
          </div>
          <div class="col-sm-4">
            <!-- text input -->
            <div class="form-group">
              <label>Add Parts</label>
              <button type="button" class="btn btn-block bg-lime" id="btnAddNoSpareParts" onclick="add_no_spare_parts()">Add</button>
            </div>
          </div>
        </div>
        <div class="table-responsive" style="max-height: 175px; overflow: auto; display:inline-block;">
          <table id="pendingNoSparePmConcernsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
            <thead style="text-align: center;">
              <tr>
                <th>No.</th>
                <th>Parts Code</th>
                <th>Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="pendingNoSparePmConcernsData" style="text-align: center;"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" id="btnSetPendingNoSparePmConcern" onclick="set_pending_no_spare_pm_concern()" disabled>Set as Pending</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->