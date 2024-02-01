<?php
include('plugins/header.php');
include('plugins/css/pm-sticker_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/pm-sticker_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PM Sticker</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="pm-sticker.php">PM Management</a></li>
              <li class="breadcrumb-item active">PM Sticker</li>
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
                <h3 class="card-title"><i class="fas fa-users-cog"></i> PM Sticker Table</h3>
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
                    <input list="sticker_pm_plan_years" class="form-control" id="sticker_pm_plan_year" maxlength="4">
                    <datalist id="sticker_pm_plan_years"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Work Week No.</label>
                    <input list="sticker_all_ww_no" class="form-control" id="sticker_ww_no" maxlength="4">
                    <datalist id="sticker_all_ww_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Machine No.</label>
                    <input list="sticker_machines_no" class="form-control" id="sticker_machine_no" maxlength="255">
                    <datalist id="sticker_machines_no"></datalist>
                  </div>
                  <div class="col-sm-4">
                    <label>Equipment No.</label>
                    <input list="sticker_equipments_no" class="form-control" id="sticker_equipment_no" maxlength="255">
                    <datalist id="sticker_equipments_no"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-4">
                    <label>Machine Name</label>
                    <input list="sticker_machines" class="form-control" id="sticker_machine_name" maxlength="255">
                    <datalist id="sticker_machines"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Search</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_ww(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Print</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnPrintPmSticker" onclick="print_all_pm_sticker()" disabled><i class="fas fa-print"></i> Print All</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Print</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnPrintSelPmSticker" onclick="print_selected_pm_sticker()" disabled><i class="fas fa-print"></i> Print Selected</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Update</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnUpdateSelPmSticker" data-toggle="modal" data-target="#PmStickerUpdateModal" disabled><i class="fas fa-pencil-alt"></i> Update Selected</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="pmStickerTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th><input type="checkbox" name="check_all_pm" id="check_all_pm" onclick="select_all_pm_func()"></th>
                        <th>No.</th>
                        <th>Year</th>
                        <th>WW No.</th>
                        <th>Machine Name</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>PM By</th>
                        <th>PM Date</th>
                        <th>Next PM Date</th>
                        <th>Shift Engineer</th>
                      </tr>
                    </thead>
                    <tbody id="pmStickerData" style="text-align: center;"></tbody>
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
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/pm-sticker_details.php');
include('plugins/modals/pm-sticker_update.php');
include('plugins/js/pm-sticker_script.php');
?>
