<!-- Data Info Modal -->
<div class="modal fade" id="AddAccountModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Add New Account</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Username</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_username" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_name" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Password</label><label style="color: red;">*</label>
                <input type="password" class="form-control" id="i_password" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Role</label><label style="color: red;">*</label>
                <select class="form-control" id="i_role" style="width: 100%;" required>
                  <option disabled selected value="">Select Role</option>
                  <option value="Admin">Admin</option>
                  <option value="PM">PM</option>
                  <option value="QA">QA</option>
                  <option value="Prod">Prod</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Process</label><label style="color: red;">*</label>
                <select class="form-control" id="i_process" style="width: 100%;" required>
                  <option disabled selected value="">Select Process</option>
                  <option value="N/A">N/A</option>
                  <option value="Initial">Initial</option>
                  <option value="Final">Final</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn bg-lime" onclick="save_data()">Add Account</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->