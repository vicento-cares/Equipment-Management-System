<?php
include('plugins/header.php');
include('plugins/css/approver-3_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/approver-3_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approver 3</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item"><a href="approver-3.php">Approvers</a></li>
              <li class="breadcrumb-item active">Approver 3</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-scroll"></i> Start of Utilization (SOU) Forms Table</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Date Updated From</label>
                    <input type="date" class="form-control" id="sou_history_date_updated_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Date Updated To</label>
                    <input type="date" class="form-control" id="sou_history_date_updated_to">
                  </div>
                  <div class="col-sm-6">
                    <label>Asset Name</label>
                    <input list="sou_history_asset_names" class="form-control" id="sou_history_asset_name" maxlength="255">
                    <datalist id="sou_history_asset_names"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>SOU No.</label>
                    <input type="text" class="form-control" id="sou_history_no" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Kigyo No.</label>
                    <input type="text" class="form-control" id="sou_history_kigyo_no" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Machine No.</label>
                    <input list="sou_history_machines_no" class="form-control" id="sou_history_machine_no" maxlength="255">
                    <datalist id="sou_history_machines_no"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Equipment No.</label>
                    <input list="sou_history_equipments_no" class="form-control" id="sou_history_equipment_no" maxlength="255">
                    <datalist id="sou_history_equipments_no"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>SOU Status</label>
                    <select class="form-control" id="sou_history_status" style="width: 100%;">
                      <option selected value="All">All</option>
                      <option value="Saved">Pending</option>
                      <option value="Returned">Returned</option>
                      <option value="Confirmed">Confirmed</option>
                    </select>
                  </div>
                  <div class="col-sm-3 offset-sm-3">
                    <label>&nbsp;</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_sou_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnExportSou" onclick="export_sou()"><i class="fas fa-download"></i> Export</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="souTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>SOU No.</th>
                        <th>Kigyo No.</th>
                        <th>Asset Name</th>
                        <th>Supplementary Asset Name</th>
                        <th>SOU Date</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="souData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_sou_history(2)">Load more</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-scroll"></i> Fixed Asset Transfer Forms Table</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Date Updated From</label>
                    <input type="date" class="form-control" id="fat_history_date_updated_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Date Updated To</label>
                    <input type="date" class="form-control" id="fat_history_date_updated_to">
                  </div>
                  <div class="col-sm-6">
                    <label>Item Description</label>
                    <input list="fat_history_item_descriptions" class="form-control" id="fat_history_item_description" maxlength="255">
                    <datalist id="fat_history_item_descriptions"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>FAT No.</label>
                    <input type="text" class="form-control" id="fat_history_no" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Item Name</label>
                    <input type="text" class="form-control" id="fat_history_item_name" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Machine No.</label>
                    <input list="fat_history_machines_no" class="form-control" id="fat_history_machine_no" maxlength="255">
                    <datalist id="fat_history_machines_no"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Equipment No.</label>
                    <input list="fat_history_equipments_no" class="form-control" id="fat_history_equipment_no" maxlength="255">
                    <datalist id="fat_history_equipments_no"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>FAT Status</label>
                    <select class="form-control" id="fat_history_status" style="width: 100%;">
                      <option selected value="All">All</option>
                      <option value="Saved">Pending</option>
                      <option value="Returned">Returned</option>
                      <option value="Confirmed">Confirmed</option>
                    </select>
                  </div>
                  <div class="col-sm-3 offset-sm-6">
                    <label>&nbsp;</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_fat_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="fatTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>FAT No.</th>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Asset Tag No.</th>
                        <th>Date Transfer</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="fatData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count2">
                  <label id="counter_view2"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data2" style="display:none;" onclick="get_fat_history(2)">Load more</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/approver3-sou-details_modal.php');
include('plugins/modals/approver3-fat-details_modal.php');
include('plugins/js/approver-3_script.php');
?>
