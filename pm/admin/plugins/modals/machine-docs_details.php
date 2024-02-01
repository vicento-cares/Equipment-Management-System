<!-- Data Info Modal -->
<div class="modal fade" id="MachineDocsDetailsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Machine Document Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Machine Name</label><label style="color: red;">*</label>
                <select class="form-control" id="u_machine_name" style="width: 100%;" onchange="get_machine_details('update')" required></select>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label>
                <select class="form-control" id="u_process" style="width: 100%;" disabled>
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
                <label>Uploaded Machine Docs Filename</label><br>
                <span id="u_file_name"></span>
                <input type="hidden" id="u_file_url">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" id="u_machine_docs_type" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Type</option>
                  <option value="WI">WI</option>
                  <option value="OP-014">OP-014</option>
                  <option value="RSIR">RSIR</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Re-Upload Document Here</label><label style="color: red;">*</label><br>
                <input type="file" id="u_machine_docs_file" name="u_machine_docs_file" accept=".pdf, application/pdf" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-gray" onclick="download_machine_docs()">Download Docs</button>
        <button type="button" class="btn bg-lime" id="btnUpdateMachineDocs" onclick="update_machine_docs()">Update Docs</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteMachineDocsModal" id="btnGoDeleteMachineDocs">Delete Docs</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->