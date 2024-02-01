<!-- Data Info Modal -->
<div class="modal fade" id="ExportPmPlanModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Export Pm Plan CSV</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <label>Export PM Plan CSV Filters</label>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <label>PM Plan Year</label><label style="color: red;">*</label>
              <input list="export_pm_plan_years" class="form-control" id="export_pm_plan_year" maxlength="4">
              <datalist id="export_pm_plan_years"></datalist>
            </div>
            <div class="col-sm-6">
              <label>Work Week No.</label><label style="color: red;">*</label>
              <input list="export_all_ww_no" class="form-control" id="export_ww_no" maxlength="4">
              <datalist id="export_all_ww_no"></datalist>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" onclick="export_pm_plan()">Export</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->