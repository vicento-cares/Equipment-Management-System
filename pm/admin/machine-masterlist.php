<?php
include('plugins/header.php');
include('plugins/css/machine-masterlist_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/machine-masterlist_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine Masterlist</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="machine-masterlist.php">Machine Information</a></li>
              <li class="breadcrumb-item active">Machine Masterlist</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-6 col-6" id="cardAddMachine">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner mb-3">
                <h4>New Machine</h4>
                <p>Machine Masterlist</p>
              </div>
              <div class="icon">
                <i class="ion ion-wrench"></i>
              </div>
              <a data-toggle="modal" data-target="#AddMachineModal" class="small-box-footer" style="cursor:pointer;" id="btnAddMachine">Add New Machine (Single Machine) <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6" id="cardExportMachine">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner mb-3">
                <h4>Export Machines</h4>
                <p>Machine Masterlist</p>
              </div>
              <div class="icon">
                <i class="ion ion-document-text"></i>
              </div>
              <a data-toggle="modal" data-target="#ExportMachineModal" class="small-box-footer" style="cursor:pointer;" id="btnExportMachine">Export Machine Masterlist CSV <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row mb-2">
          <div class="col-lg-6 col-6" id="cardExportMachineFormat">
            <!-- small box -->
            <div class="small-box bg-lime">
              <div class="inner mb-3">
                <h4>Download Template</h4>
                <p>Machine Masterlist Template</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-download"></i>
              </div>
              <a onclick="export_masterlist_format()" class="small-box-footer" style="cursor:pointer;">Download Machine Masterlist CSV Template <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6" id="cardUploadMachine">
            <!-- small box -->
            <div class="small-box bg-olive">
              <div class="inner mb-3">
                <h4>Upload More Machines</h4>
                <p>Filled out Machine Masterlist Template</p>
              </div>
              <div class="icon">
                <i class="ion ion-upload"></i>
              </div>
              <a data-toggle="modal" data-target="#UploadMachineMasterlistMenuModal" class="small-box-footer" style="cursor:pointer;">Upload Machines CSV (Two or more machines) <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tools"></i> Machine Masterlist Table</h3>
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
                    <label>Process</label>
                    <select class="form-control" id="i_search_process" style="width: 100%;" onchange="load_data(1)">
                      <option selected value="All">All Process</option>
                      <option value="Initial">Initial</option>
                      <option value="Final">Final</option>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>Car Model</label>
                    <input list="i_search_car_models" class="form-control" id="i_search_car_model" maxlength="255">
                    <datalist id="i_search_car_models"></datalist>
                  </div>
                  <div class="col-sm-5">
                    <label>Machine Name</label>
                    <input list="i_search_machines" class="form-control" id="i_search_machine_name" maxlength="255">
                    <datalist id="i_search_machines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Machine No.</label>
                    <input list="i_search_machines_no" class="form-control" id="i_search_machine_no" maxlength="255">
                    <datalist id="i_search_machines_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Equipment No.</label>
                    <input list="i_search_equipments_no" class="form-control" id="i_search_equipment_no" maxlength="255">
                    <datalist id="i_search_equipments_no"></datalist>
                  </div>
                  <div class="col-sm-5">
                    <label>Machine Specification</label>
                    <input type="text" class="form-control" id="i_search_machine_spec" maxlength="255">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <button type="button" class="btn bg-lime btn-block" onclick="export_machine_names()"><i class="fas fa-download"></i> Export Machine Names</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lime btn-block" onclick="export_locations()"><i class="fas fa-download"></i> Export Locations</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lime btn-block" onclick="export_car_models()"><i class="fas fa-download"></i> Export Car Models</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn bg-lime btn-block" onclick="load_data(1)"><i class="fas fa-search"></i> Search Machine</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lime btn-block" onclick="load_data(3)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="machineTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Machine Name</th>
                        <th>Machine Specification</th>
                        <th>Car Model</th>
                        <th>Location</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="machineData" style="text-align: center;">
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
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="load_data(2)">Load more</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="cardMachineNameTable">
          <div class="col-sm-12">
            <div class="card card-lime card-outline collapsed-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tools"></i> Machine Name Table</h3>
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
                  <div class="col-sm-2">
                    <label>Process</label>
                    <select class="form-control" id="i_search_process2" style="width: 100%;" onchange="get_machine_names(1)">
                      <option selected value="All">All Process</option>
                      <option value="Initial">Initial</option>
                      <option value="Final">Final</option>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>Machine Name</label>
                    <input type="text" class="form-control" id="i_search_machine_name2" maxlength="255">
                  </div>
                  <div class="col-sm-2">
                    <label>Search</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_machine_names(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Refresh</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_machine_names(3)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Add</label>
                    <button type="button" class="btn bg-lime btn-block" data-toggle="modal" data-target="#AddMachineNameModal" id="btnGoAddMachine"><i class="fas fa-plus-circle"></i> Add New</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="machineNameTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>Current No.</th>
                        <th>Process</th>
                        <th>Machine Name</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="machineNameData" style="text-align: center;">
                      <tr>
                        <td colspan="4" style="text-align:center;">
                          <div class="spinner-border text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count2">
                  <label id="counter_view2"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data2" style="display:none;" onclick="get_machine_names(2)">Load more</button>
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
include('plugins/modals/machine-masterlist_add.php');
include('plugins/modals/machine-masterlist_details.php');
include('plugins/modals/machine-masterlist_export.php');
include('plugins/modals/machine-name_add.php');
include('plugins/modals/upload-machine-masterlist-menu_modal.php');
include('plugins/modals/upload-machine-masterlist-csv_modal.php');
include('plugins/modals/upload-old-machine-masterlist-csv_modal.php');
include('plugins/js/machine-masterlist_script.php');
?>
