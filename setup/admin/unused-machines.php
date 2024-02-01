<?php
include('plugins/header.php');
include('plugins/css/unused-machines_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/unused-machines_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Unused Machines</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item"><a href="unused-machines.php">Machine Set Up Management</a></li>
              <li class="breadcrumb-item active">Unused Machines</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-4 offset-sm-8">
            <button type="button" class="btn bg-lime btn-block" id="btnGoAddUnusedMachine" data-toggle="modal" data-target="#AddUnusedMachineModal"><i class="fas fa-plus-circle"></i> Add Unused Machine</button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exclamation-circle"></i> Unused Machines Table</h3>
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
                    <label>Machine No.</label>
                    <input list="search_machines_no" class="form-control" id="search_machine_no" maxlength="255">
                    <datalist id="search_machines_no"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Equipment No.</label>
                    <input list="search_equipments_no" class="form-control" id="search_equipment_no" maxlength="255">
                    <datalist id="search_equipments_no"></datalist>
                  </div>
                  <div class="col-sm-6">
                    <label>Machine Name</label>
                    <input list="search_machines" class="form-control" id="search_machine_name" maxlength="255">
                    <datalist id="search_machines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Status</label>
                    <input type="text" class="form-control" id="search_status" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Car Model</label>
                    <input list="search_car_models" class="form-control" id="search_car_model" maxlength="255">
                    <datalist id="search_car_models"></datalist>
                  </div>
                  <div class="col-sm-6">
                    <label>Unused Machine Location</label>
                    <input type="text" class="form-control" id="search_unused_machine_location" maxlength="255">
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-sm-2 offset-sm-6">
                    <button type="button" class="btn bg-lime btn-block" onclick="get_unused_machines(3)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lime btn-block" onclick="get_unused_machines(1)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lime btn-block" onclick="export_unused_machines_csv()"><i class="fas fa-download"></i> Export CSV</button>
                  </div>
                </div>
                <div id="accordion_unused_machines_legend">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneUnusedMachinesLegend">
                          Unused Machines Legend
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOneUnusedMachinesLegend" class="collapse" data-parent="#accordion_unused_machines_legend">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-3 col-lg-3 p-1 bg-gray-dark"><center>Unused</center></div>
                          <div class="col-sm-3 col-lg-3 p-1 bg-success"><center>Sold</center></div>
                          <div class="col-sm-3 col-lg-3 p-1 bg-warning"><center>Borrowed</center></div>
                          <div class="col-sm-3 col-lg-3 p-1 bg-danger"><center>Disposed</center></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="unusedMachinesTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Machine Name</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Car Model</th>
                        <th>Asset Tag No.</th>
                        <th>Status</th>
                        <th>Reserved For</th>
                        <th>Remarks</th>
                        <th>PIC</th>
                        <th>Unused Machine Location</th>
                        <th>Target Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="unusedMachinesData" style="text-align: center;">
                      <tr>
                        <td colspan="12" style="text-align:center;">
                          <div class="spinner-border text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="load_more_data" style="display:none;" onclick="get_unused_machines(2)">Load more</button>
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_unused_machines(4)">Load more</button>
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
include('plugins/modals/unused-machines_add.php');
include('plugins/modals/unused-machines_details.php');
include('plugins/modals/unused-machines_action.php');
include('plugins/js/unused-machines_script.php');
?>
