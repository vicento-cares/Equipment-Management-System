<!-- Data Info Modal -->
<div class="modal fade" id="MstprcSetupFatModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Setup Checksheet - Fixed Asset Transfer Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="mstprc_setup_fat_no">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Item Name / Parts Name</label>
                <input type="text" class="form-control" id="mstprc_setup_item_name" maxlength="255">
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Item Description</label>
                <input type="text" class="form-control" id="mstprc_setup_item_description" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Machine No.</label>
                <input type="text" class="form-control" id="mstprc_setup_fat_machine_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Equipment No.</label>
                <input type="text" class="form-control" id="mstprc_setup_fat_equipment_no" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No.</label>
                <input type="text" class="form-control" id="mstprc_setup_fat_asset_tag_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Previous Location</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Group</label>
                <input type="text" class="form-control" id="mstprc_setup_previous_group" maxlength="255" disabled>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <input type="text" class="form-control" id="mstprc_setup_previous_location" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_setup_previous_grid" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>New Location</label><label style="color: red;">*</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Group</label>
                <input list="mstprc_setup_new_groups" class="form-control" id="mstprc_setup_new_group" maxlength="255">
                <datalist id="mstprc_setup_new_groups"></datalist>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Location</label>
                <select class="form-control" id="mstprc_setup_new_location" style="width: 100%;" required></select>
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>Grid</label>
                <input type="text" class="form-control" id="mstprc_setup_new_grid" maxlength="10">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Date Transferred</label><label style="color: red;">*</label>
                <input type="date" class="form-control" id="mstprc_setup_date_transfer" required>
              </div>
            </div>
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Reason For Transfer</label><label style="color: red;">*</label>
                <textarea id="mstprc_setup_fat_reason" class="form-control" style="resize: none;" rows="2" maxlength="255" required></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal" onclick="setTimeout(() => {$('#MstprcSetupStep2Modal').modal('show');}, 400);">Back</button>
        <button type="button" class="btn bg-gray" onclick="clear_mstprc_setup_fat_fields()">Clear</button>
        <button type="button" class="btn bg-lime" onclick="goto_mstprc_setup_sou()" id="btnGoMstprcSetupFat">Next</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->