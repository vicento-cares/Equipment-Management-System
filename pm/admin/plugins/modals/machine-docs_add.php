<!-- Data Info Modal -->
<div class="modal fade" id="AddMachineDocsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Add New Machine Docs</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label><label style="color: red;">*</label>
                <select class="form-control" id="i_machine_name" style="width: 100%;" onchange="get_machine_details('insert')" required></select>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label><label style="color: red;">*</label>
                <select class="form-control" id="i_process" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Process</option>
                  <option value="Initial">Initial</option>
                  <option value="Final">Final</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Upload Document Here</label><label style="color: red;">*</label><br>
                <input type="file" id="i_machine_docs_file" name="i_machine_docs_file" accept=".pdf, application/pdf" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Type</label><label style="color: red;">*</label>
                <select class="form-control" id="i_machine_docs_type" style="width: 100%;">
                  <option disabled selected value="">Select Type</option>
                  <option value="WI">WI</option>
                  <option value="OP-014">OP-014</option>
                  <option value="RSIR">RSIR</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" id="btnAddMachineDocs" onclick="save_machine_docs()">Add Docs</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->