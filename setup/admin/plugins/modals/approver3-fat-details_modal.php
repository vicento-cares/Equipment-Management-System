<!-- Data Info Modal -->
<div class="modal fade" id="FatInfoHistoryModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Fixed Asset Transfer Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="fat_id">
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>FAT No. : </label>
                <span id="fat_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Item Name / Parts Name : </label>
                <span id="fat_item_name"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Item Description : </label>
                <span id="fat_item_description"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Machine No. : </label>
                <span id="fat_machine_no"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Equipment No. : </label>
                <span id="fat_equipment_no"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Asset Tag No. : </label>
                <span id="fat_asset_tag_no"></span>
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
                <label>Group : </label>
                <span id="fat_prev_location_group"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Location : </label>
                <span id="fat_prev_location_loc"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Grid : </label>
                <span id="fat_prev_location_grid"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>New Location</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Group : </label>
                <span id="fat_new_location_group"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Location : </label>
                <span id="fat_new_location_loc"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Grid : </label>
                <span id="fat_new_location_grid"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Date Transferred : </label>
                <span id="fat_date_transfer"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group mb-0">
                <label>Reason For Transfer : </label>
                <span id="fat_reason"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-gray" data-dismiss="modal">Back</button>
        <button type="button" class="btn bg-gray" onclick="export_fat()">Export</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->