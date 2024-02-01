<?php
include('plugins/header.php');
include('plugins/css/pm-plan_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/pm-plan_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PM Plan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="pm-plan.php">PM Management</a></li>
              <li class="breadcrumb-item active">PM Plan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-6 col-6" id="cardAddSinglePmPlan">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner mb-3">
                <h4>PM Plan</h4>
                <p>Preventive Maintenance Plan</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-list"></i>
              </div>
              <a data-toggle="modal" data-target="#AddSinglePmPlanModal" class="small-box-footer" style="cursor:pointer;">Make PM Plan (Single Machine) <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6" id="cardExportPmPlan">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner mb-3">
                <h4>Export PM Plan</h4>
                <p>PM Plan File</p>
              </div>
              <div class="icon">
                <i class="ion ion-document-text"></i>
              </div>
              <a data-toggle="modal" data-target="#ExportPmPlanModal" class="small-box-footer" style="cursor:pointer;">Export PM Plan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row mb-2">
          <div class="col-lg-6 col-6" id="cardExportPmPlanFormat">
            <!-- small box -->
            <div class="small-box bg-lime">
              <div class="inner mb-3">
                <h4>Download Template</h4>
                <p>PM Plan Template</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-download"></i>
              </div>
              <a onclick="export_pm_plan_format()" class="small-box-footer" style="cursor:pointer;">Download PM Plan CSV Template <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6" id="cardUploadPmPlan">
            <!-- small box -->
            <div class="small-box bg-olive">
              <div class="inner mb-3">
                <h4>Upload PM Plan</h4>
                <p>Filled out PM Plan Template</p>
              </div>
              <div class="icon">
                <i class="ion ion-upload"></i>
              </div>
              <a data-toggle="modal" data-target="#UploadPmPlanCsvModal" class="small-box-footer" style="cursor:pointer;">Upload PM Plan CSV (Two or more machines) <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-scroll"></i> PM Plan Table</h3>
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
                    <label>PM Plan Year</label>
                    <input list="search_pm_plan_years" class="form-control" id="search_pm_plan_year" maxlength="4">
                    <datalist id="search_pm_plan_years"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Work Week No.</label>
                    <input list="search_all_ww_no" class="form-control" id="search_ww_no" maxlength="4">
                    <datalist id="search_all_ww_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Car Model</label>
                    <input list="search_car_models" class="form-control" id="search_car_model" maxlength="255">
                    <datalist id="search_car_models"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Machine Name</label>
                    <input list="search_machines" class="form-control" id="search_machine_name" maxlength="255">
                    <datalist id="search_machines"></datalist>
                  </div>
                </div>
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
                  <div class="col-sm-3">
                    <label>Machine Specification</label>
                    <input type="text" class="form-control" id="search_machine_spec" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Search</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_pm_plan(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="pmPlanTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Machine Name</th>
                        <th>Machine Specification</th>
                        <th>Car Model</th>
                        <th>Location</th>
                        <th>Grid</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>TRD No.</th>
                        <th>NS-IV No.</th>
                        <th>Year</th>
                        <th>WW No.</th>
                        <th>WW Start Date</th>
                        <th>Frequency</th>
                        <th>Machine Status</th>
                        <th>PM Status</th>
                      </tr>
                    </thead>
                    <tbody id="pmPlanData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_pm_plan(2)">Load more</button>
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
include('plugins/modals/pm-plan_add.php');
include('plugins/modals/pm-plan_details.php');
include('plugins/modals/pm-plan_export.php');
include('plugins/modals/delete-data_modal.php');
include('plugins/modals/upload-pm-plan-csv_modal.php');
include('plugins/js/pm-plan_script.php');
?>
