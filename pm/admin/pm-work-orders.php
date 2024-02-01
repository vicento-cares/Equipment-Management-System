<?php
include('plugins/header.php');
include('plugins/css/pm-work-orders_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/pm-work-orders_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Work Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="pm-work-orders.php">PM Documentation</a></li>
              <li class="breadcrumb-item active">Work Orders</li>
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
                <h3 class="card-title"><i class="fas fa-archive"></i> Work Orders Table</h3>
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
                  <div class="col-sm-4">
                    <label>WO Date From</label>
                    <input type="datetime-local" class="form-control" id="history_wo_date_from">
                  </div>
                  <div class="col-sm-4">
                    <label>WO Date To</label>
                    <input type="datetime-local" class="form-control" id="history_wo_date_to">
                  </div>
                  <div class="col-sm-4">
                    <label>Machine Name</label>
                    <input list="history_machines" class="form-control" id="history_machine_name" maxlength="255">
                    <datalist id="history_machines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-4">
                    <label>Machine No.</label>
                    <input list="history_machines_no" class="form-control" id="history_machine_no" maxlength="255">
                    <datalist id="history_machines_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Equipment No.</label>
                    <input list="history_equipments_no" class="form-control" id="history_equipment_no" maxlength="255">
                    <datalist id="history_equipments_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Search</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_work_orders(1)"><i class="fas fa-search"></i> Search Work Order</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="workOrderTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>WO No.</th>
                        <th>Machine Name</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>WO Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="workOrderData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_work_orders(2)">Load more</button>
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
include('plugins/modals/pm-work-order_details.php');
include('plugins/js/pm-work-orders_script.php');
?>
