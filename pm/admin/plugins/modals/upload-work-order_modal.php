<!-- Upload CSV Modal -->
<div class="modal fade" id="UploadWorkOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Upload Work Order</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label><label style="color: red;">*</label>
                <input list="work_order_machines_no" class="form-control" id="work_order_machine_no" maxlength="255">
                <datalist id="work_order_machines_no"></datalist>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label><label style="color: red;">*</label>
                <input list="work_order_equipments_no" class="form-control" id="work_order_equipment_no" maxlength="255">
                <datalist id="work_order_equipments_no"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label>
                <input type="text" class="form-control" id="work_order_machine_name" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <input type="text" class="form-control" id="work_order_process" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Upload Work Order Here</label><label style="color: red;">*</label><br>
                <input type="file" id="work_order_file" name="work_order_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lime" onclick="upload_work_order()">Upload Work Order</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->