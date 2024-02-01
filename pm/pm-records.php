<?php
include('plugins/header.php');
include('plugins/css/pm-records_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar/pm-records_navbar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
          <h1 class="m-0"> PM Records</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/ems/pm/">EMS PM</a></li>
            <li class="breadcrumb-item active">PM Records</li>
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
              <h3 class="card-title"><i class="fas fa-archive"></i> PM Records Table</h3>
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
                  <label>RSIR Date From</label>
                  <input type="date" class="form-control" id="history_date_from">
                </div>
                <div class="col-sm-3">
                  <label>RSIR Date To</label>
                  <input type="date" class="form-control" id="history_date_to">
                </div>
                <div class="col-sm-6">
                  <label>Machine Name</label>
                  <input list="history_machines" class="form-control" id="history_machine_name" maxlength="255">
                  <datalist id="history_machines"></datalist>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-sm-3">
                  <label>RSIR No.</label>
                  <input type="text" class="form-control" id="history_rsir_no" maxlength="255">
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
                <div class="col-sm-3">
                  <label>Search</label>
                  <button type="button" class="btn bg-lime btn-block" onclick="get_pm_records(1)"><i class="fas fa-search"></i> Search RSIR</button>
                </div>
              </div>
              <div id="accordion_rsir_legend">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                      <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneRsirLegend">
                        RSIR History Legend
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOneRsirLegend" class="collapse" data-parent="#accordion_rsir_legend">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6 col-lg-6 p-1 bg-danger"><center>Disapproved</center></div>
                        <div class="col-sm-6 col-lg-6 p-1 bg-success"><center>Approved</center></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-sm-start">
                <label id="counter_view_search"></label>
              </div>
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="pmRecordsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>No.</th>
                      <th>RSIR No.</th>
                      <th>Machine Name</th>
                      <th>Machine No.</th>
                      <th>Equipment No.</th>
                      <th>Kind of Inspection</th>
                      <th>RSIR Date</th>
                    </tr>
                  </thead>
                  <tbody id="pmRecordsData" style="text-align: center;"></tbody>
                </table>
              </div>
              <div class="d-flex justify-content-sm-end">
                <input type="hidden" id="loader_count">
                <label id="counter_view"></label>
              </div>
              <div class="d-flex justify-content-sm-center">
                <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_pm_records(2)">Load more</button>
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
include('plugins/modals/rsir-history_modal.php');
include('plugins/js/pm-records_script.php');
?>
