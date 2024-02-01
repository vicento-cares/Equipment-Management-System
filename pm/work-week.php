<?php
include('plugins/header.php');
include('plugins/css/work-week_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar/work-week_navbar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
          <h1 class="m-0"> PM Schedule (Work Week)</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/ems/pm/">EMS PM</a></li>
            <li class="breadcrumb-item active">PM Schedule (Work Week)</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lime card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list-alt"></i> Work Week Table</h3>
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
                  <label>&nbsp;</label>
                  <div class="form-group mb-0">
                    <input type="radio" id="search_ww_opt_by_ww_no" name="search_ww_opt" value="1" onclick="check_ww_opt()">
                    <label class="h6" for="search_ww_opt_by_ww_no">By WW No.</label>
                  </div>
                </div>
                <div class="col-sm-2">
                  <label>Work Week No.</label>
                  <input list="search_all_ww_no" class="form-control" id="search_ww_no" maxlength="4">
                  <datalist id="search_all_ww_no"></datalist>
                </div>
                <div class="col-sm-2">
                  <label>&nbsp;</label>
                  <div class="form-group mb-0">
                    <input type="radio" id="search_ww_opt_by_date_range" name="search_ww_opt" value="2" onclick="check_ww_opt()">
                    <label class="h6" for="search_ww_opt_by_date_range">By Date Range</label>
                  </div>
                </div>
                <div class="col-sm-2">
                  <label>WW Start Date From</label>
                  <input type="date" class="form-control" id="search_ww_start_date_from" disabled>
                </div>
                <div class="col-sm-2">
                  <label>WW Start Date To</label>
                  <input type="date" class="form-control" id="search_ww_start_date_to" disabled>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-6">
                  <label>Car Model</label>
                  <input list="search_car_models" class="form-control" id="search_car_model" maxlength="255">
                  <datalist id="search_car_models"></datalist>
                </div>
                <div class="col-sm-6">
                  <label>Machine Name</label>
                  <input list="search_machines" class="form-control" id="search_machine_name" maxlength="255">
                  <datalist id="search_machines"></datalist>
                </div>
              </div>
              <div class="row mb-4">
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
                  <label>Search</label>
                  <button type="button" class="btn bg-lime btn-block" onclick="get_ww(1)"><i class="fas fa-search"></i> Search</button>
                </div>
                <div class="col-sm-3">
                  <label>Export</label>
                  <button type="button" class="btn bg-lime btn-block" onclick="export_ww()"><i class="fas fa-download"></i> Export WW</button>
                </div>
              </div>
              <div id="accordion_work_week_legend">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                      <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneWorkWeekLegend">
                        Work Week Legend
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOneWorkWeekLegend" class="collapse" data-parent="#accordion_work_week_legend">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3 col-lg-3 p-1 bg-danger"><center>No Manpower</center></div>
                        <div class="col-sm-2 col-lg-2 p-1 bg-lime"><center>No Sched</center></div>
                        <div class="col-sm-2 col-lg-2 p-1 bg-gray-dark"><center>Has Sched</center></div>
                        <div class="col-sm-3 col-lg-3 p-1 bg-warning"><center>Waiting For Confirmation</center></div>
                        <div class="col-sm-2 col-lg-2 p-1 bg-lightblue"><center>Done</center></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-sm-start">
                <label id="counter_view_search"></label>
              </div>
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="workWeekTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>No.</th>
                      <th>Year</th>
                      <th>WW No.</th>
                      <th>Machine Name</th>
                      <th>Machine No.</th>
                      <th>Equipment No.</th>
                      <th>Frequency</th>
                      <th>Car Model</th>
                      <th>Manpower</th>
                      <th>WW Start Date</th>
                      <th>Start Date & Time</th>
                      <th>End Date & Time</th>
                    </tr>
                  </thead>
                  <tbody id="workWeekData" style="text-align: center;"></tbody>
                </table>
              </div>
              <div class="d-flex justify-content-sm-end">
                <input type="hidden" id="loader_count">
                <label id="counter_view"></label>
              </div>
              <div class="d-flex justify-content-sm-center">
                <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_ww(2)">Load more</button>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/js/work-week_script.php');
?>
