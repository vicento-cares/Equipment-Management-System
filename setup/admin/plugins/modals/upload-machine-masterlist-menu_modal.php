<!-- Upload CSV Modal -->
<div class="modal fade" id="UploadMachineMasterlistMenuModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title">Upload Machine Masterlist Menu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div class="row">
          <div class="col-sm-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner mb-3">
                <h4>New Machines</h4>
                <p>Machine Masterlist</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-list"></i>
              </div>
              <a data-dismiss="modal" class="small-box-footer" style="cursor:pointer;" onclick="setTimeout(() => {$('#UploadMachineMasterlistCsvModal').modal('show');}, 400);">Upload New Machines <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-sm-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner mb-3">
                <h4>Unused Machines</h4>
                <p>Machine Masterlist</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-list"></i>
              </div>
              <a data-dismiss="modal" class="small-box-footer" style="cursor:pointer;" onclick="setTimeout(() => {$('#UploadUnusedMachineMasterlistCsvModal').modal('show');}, 400);">Upload Unused Machines <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->