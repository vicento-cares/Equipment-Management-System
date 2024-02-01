<!-- Upload CSV Modal -->
<div class="modal fade" id="UploadPmPlanCsvModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Upload PM Plan CSV</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Upload CSV Here</label><br>
                <input type="file" id="pm_plan_file" name="pm_plan_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lime" onclick="upload_pm_plan_csv()">Upload CSV</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->