<!-- Delete Data Modal -->
<div class="modal fade" id="DisposeMachineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Dispose Machine</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-4">
            <div class="col-sm-12">
              <label>Disposed Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="disposed_date" required>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you will mark this as disposed?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="dispose_machine()">Mark as Disposed</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Delete Data Modal -->
<div class="modal fade" id="BorrowedMachineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Mark as Borrowed Machine</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-4">
            <div class="col-sm-12">
              <label>Borrowed Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="borrowed_date" required>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you will mark this as borrowed?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning" onclick="borrowed_machine()">Mark as Borrowed</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Delete Data Modal -->
<div class="modal fade" id="SoldMachineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Mark as Sold Machine</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-4">
            <div class="col-sm-12">
              <label>Sold Date</label><label style="color: red;">*</label>
              <input type="date" class="form-control" id="sold_date" required>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you will mark this as sold?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="sold_machine()">Mark as Sold</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Delete Data Modal -->
<div class="modal fade" id="ResetBorrowedMachineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Reset Borrowed Machine</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you will change borrowed to unused machine again?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning" onclick="reset_unused_machine()">Mark as Borrowed</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->