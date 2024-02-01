<?php
include('plugins/header.php');
include('plugins/css/approver-2_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/approver-2_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Approver 2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="approver-2.php">EMS SP</a></li>
              <li class="breadcrumb-item"><a href="approver-2.php">Setup Approver</a></li>
              <li class="breadcrumb-item active">Approver 2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks"></i> Machine Checksheet Table</h3>
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
                    <label>Car Model</label>
                    <input list="pending_car_models_search" class="form-control" id="pending_car_model_search" maxlength="255">
                    <datalist id="pending_car_models_search"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Location</label>
                    <input list="pending_locations_search" class="form-control" id="pending_location_search" maxlength="255">
                    <datalist id="pending_locations_search"></datalist>
                  </div>
                  <div class="col-sm-6">
                    <label>Machine Name</label>
                    <input list="pending_machines_search" class="form-control" id="pending_machine_name_search" maxlength="255">
                    <datalist id="pending_machines_search"></datalist>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-sm-3">
                    <label>Grid</label>
                    <input type="text" class="form-control" id="pending_grid_search" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>MSTPRC No.</label>
                    <input type="text" class="form-control" id="pending_mstprc_no_search" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Machine No.</label>
                    <input list="pending_machines_no_search" class="form-control" id="pending_machine_no_search" maxlength="255">
                    <datalist id="pending_machines_no_search"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Equipment No.</label>
                    <input list="pending_equipments_no_search" class="form-control" id="pending_equipment_no_search" maxlength="255">
                    <datalist id="pending_equipments_no_search"></datalist>
                  </div>
                </div>
                <div id="accordion_a2_mstprc_legend">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneA2MstprcLegend">
                          Approver 2 MSTPRC Legend
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOneA2MstprcLegend" class="collapse" data-parent="#accordion_a2_mstprc_legend">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4 col-lg-4 p-1 bg-yellow"><center>Unread</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-gray-dark"><center>Need Approval</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Approved - Waiting to be Fully Approved</center></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="a2MachineChecksheetTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>MSTPRC No.</th>
                        <th>Machine Name</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Car Model</th>
                        <th>Checksheet Type</th>
                        <th>MSTPRC Date</th>
                      </tr>
                    </thead>
                    <tbody id="a2MachineChecksheetData" style="text-align: center;">
                      <tr>
                        <td colspan="8" style="text-align:center;">
                          <div class="spinner-border text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
            <div class="card card-lime card-outline collapsed-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Machine Checksheet Approval History</h3>
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
                    <label>MSTPRC Date From</label>
                    <input type="date" class="form-control" id="history_mstprc_date_from">
                  </div>
                  <div class="col-sm-3">
                    <label>MSTPRC Date To</label>
                    <input type="date" class="form-control" id="history_mstprc_date_to">
                  </div>
                  <div class="col-sm-6">
                    <label>Machine Name</label>
                    <input list="history_machines" class="form-control" id="history_machine_name" maxlength="255">
                    <datalist id="history_machines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>MSTPRC No.</label>
                    <input type="text" class="form-control" id="history_mstprc_no" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Car Model</label>
                    <input list="history_car_models" class="form-control" id="history_car_model" maxlength="255">
                    <datalist id="history_car_models"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Machine No.</label>
                    <input list="history_machines_no" class="form-control" id="history_machine_no" maxlength="255">
                    <datalist id="history_machines_no"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Equipment No.</label>
                    <input list="history_equipments_no" class="form-control" id="history_equipment_no" maxlength="255">
                    <datalist id="history_equipments_no"></datalist>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-sm-3">
                    <label>History Option</label>
                    <select class="form-control" id="history_option" style="width: 100%;" required>
                      <option selected value="1">Partially Approved</option>
                      <option value="2">Fully Approved / Disapproved</option>
                    </select>
                  </div>
                  <div class="col-sm-3 offset-sm-6">
                    <label>&nbsp;</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_a2_machine_checksheets_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <!-- <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnExportA2MachineChecksheetHistory" onclick="export_a2_machine_checksheets_history()"><i class="fas fa-download"></i> Export</button>
                  </div> -->
                </div>
                <div id="accordion_mstprc_legend">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneMstprcLegend">
                          MSTPRC History Legend
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOneMstprcLegend" class="collapse" data-parent="#accordion_mstprc_legend">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4 col-lg-4 p-1 bg-warning"><center>Partially Approved</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-danger"><center>Disapproved</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Fully Approved</center></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="a2MachineChecksheetHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Checksheet ID</th>
                        <th>Machine Name</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Car Model</th>
                        <th>Checksheet Type</th>
                        <th>MSTPRC Date</th>
                      </tr>
                    </thead>
                    <tbody id="a2MachineChecksheetHistoryData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count2">
                  <label id="counter_view2"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data2" style="display:none;" onclick="get_a2_machine_checksheets_history(2)">Load more</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/approver2-mstprc_modal.php');
include('plugins/modals/approver2-mstprc-disapprove_modal.php');
include('plugins/modals/approver2-mstprc-history_modal.php');
include('plugins/js/approver-2_script.php');
?>