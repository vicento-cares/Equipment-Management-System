<?php
include('plugins/header.php');
include('plugins/css/machine-checksheets_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/machine-checksheets_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine Checksheets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item"><a href="machine-checksheets.php">Machine Set Up Management</a></li>
              <li class="breadcrumb-item active">Machine Checksheets</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner mb-3">
                <h4>Set Up</h4>
                <p>Machine Set Up</p>
              </div>
              <div class="icon">
                <i class="ion ion-wrench"></i>
              </div>
              <a data-toggle="modal" data-target="#MstprcSetupStep1Modal" class="small-box-footer" style="cursor:pointer;">Make Set Up Checksheet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner mb-3">
                <h4>Transfer</h4>
                <p>Machine Transfer</p>
              </div>
              <div class="icon">
                <i class="ion ion-arrow-move"></i>
              </div>
              <a data-toggle="modal" data-target="#MstprcTransferStep1Modal" class="small-box-footer" style="cursor:pointer;">Make Transfer Checksheet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner mb-3">
                <h4>Pullout</h4>
                <p>Machine Pullout</p>
              </div>
              <div class="icon">
                <i class="ion ion-share"></i>
              </div>
              <a data-toggle="modal" data-target="#MstprcPulloutStep1Modal" class="small-box-footer" style="cursor:pointer;">Make Pullout Checksheet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
              <div class="inner mb-3">
                <h4>Re-layout</h4>
                <p>Machine Re-layout</p>
              </div>
              <div class="icon">
                <i class="ion ion-forward"></i>
              </div>
              <a data-toggle="modal" data-target="#MstprcRelayoutStep1Modal" class="small-box-footer" style="cursor:pointer;">Make Re-layout Checksheet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="card card-gray card-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="machine-checksheets-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="machine-checksheets-1-tab" data-toggle="pill" href="#machine-checksheets-1" role="tab" aria-controls="machine-checksheets-1" aria-selected="true">Pending & Recent Machine Checksheet History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-2-tab" data-toggle="pill" href="#machine-checksheets-2" role="tab" aria-controls="machine-checksheets-2" aria-selected="false">Returned Machine Checksheet</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-3-tab" data-toggle="pill" href="#machine-checksheets-3" role="tab" aria-controls="machine-checksheets-3" aria-selected="false">Machine Documents</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="machine-checksheets-tabContent">

                  <div class="tab-pane fade show active" id="machine-checksheets-1" role="tabpanel" aria-labelledby="machine-checksheets-1-tab">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card card-lime card-outline">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-spinner"></i> Pending Machine Checksheet Approval Table</h3>
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
                            <div id="accordion_pending_mstprc_legend">
                              <div class="card shadow">
                                <div class="card-header">
                                  <h4 class="card-title w-100">
                                    <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOnePendingMstprcLegend">
                                      Pending MSTPRC Legend
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOnePendingMstprcLegend" class="collapse" data-parent="#accordion_pending_mstprc_legend">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-4 col-lg-4 p-1 bg-lime"><center>Unread</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-yellow"><center>Confirmed - Waiting for First Approval</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Approved - Waiting for Second Approval</center></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex justify-content-sm-start">
                              <label id="counter_view_search"></label>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                              <table id="machineChecksheetPendingTable" class="table table-sm table-head-fixed text-nowrap table-hover">
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
                                <tbody id="machineChecksheetPendingData" style="text-align: center;">
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
                        <div class="card card-lime card-outline">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-history"></i> Recent Machine Checksheet History Table</h3>
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
                            <div id="accordion_recent_mstprc_legend">
                              <div class="card shadow">
                                <div class="card-header">
                                  <h4 class="card-title w-100">
                                    <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneRecentMstprcLegend">
                                      Recent MSTPRC History Legend
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOneRecentMstprcLegend" class="collapse" data-parent="#accordion_recent_mstprc_legend">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-4 col-lg-4 p-1 bg-lime"><center>Unread</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-danger"><center>Disapproved</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Approved</center></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex justify-content-sm-start">
                              <label id="counter_view_search2"></label>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                              <table id="machineChecksheetHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                <thead style="text-align: center;">
                                  <tr>
                                    <th>No.</th>
                                    <th>MSTPRC No.</th>
                                    <th>Machine Name</th>
                                    <th>Machine No.</th>
                                    <th>Equipment No.</th>
                                    <th>Car Model</th>
                                    <th>Checksheet Type</th>
                                    <th>Date & Time</th>
                                  </tr>
                                </thead>
                                <tbody id="machineChecksheetHistoryData" style="text-align: center;">
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
                  </div>

                  <div class="tab-pane fade" id="machine-checksheets-2" role="tabpanel" aria-labelledby="machine-checksheets-2-tab">
                    <div id="accordion_returned_mstprc_legend">
                      <div class="card shadow">
                        <div class="card-header">
                          <h4 class="card-title w-100">
                            <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneReturnedMstprcLegend">
                              Returned MSTPRC Legend
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOneReturnedMstprcLegend" class="collapse" data-parent="#accordion_returned_mstprc_legend">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6 col-lg-6 p-1 bg-lime"><center>Unread</center></div>
                              <div class="col-sm-6 col-lg-6 p-1 bg-yellow"><center>Need Resubmit</center></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-sm-start">
                      <label id="counter_view_search4"></label>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                      <table id="machineChecksheetReturnedTable" class="table table-sm table-head-fixed text-nowrap table-hover">
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
                            <th>Returned By</th>
                            <th>Returned Date & Time</th>
                          </tr>
                        </thead>
                        <tbody id="machineChecksheetReturnedData" style="text-align: center;">
                          <tr>
                            <td colspan="10" style="text-align:center;">
                              <div class="spinner-border text-dark" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="machine-checksheets-3" role="tabpanel" aria-labelledby="machine-checksheets-3-tab">
                    <div class="row mb-4">
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="i_search" placeholder="Search" maxlength="255">
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" onclick="load_machine_docs(3)"><i class="fas fa-search"></i> Search</button>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" onclick="load_machine_docs(1)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" id="btnGoAddMachineDocs" data-toggle="modal" data-target="#AddMachineDocsModal"><i class="fas fa-plus-circle"></i> Add Document</button>
                      </div>
                    </div>
                    <div class="d-flex justify-content-sm-start">
                      <label id="counter_view_search3"></label>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                      <table id="machineDocsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                        <thead style="text-align: center;">
                          <tr>
                            <th>No.</th>
                            <th>Machine Name</th>
                            <th>Type</th>
                            <th>Date Updated</th>
                          </tr>
                        </thead>
                        <tbody id="machineDocsData" style="text-align: center;">
                          <tr>
                            <td colspan="6" style="text-align:center;">
                              <div class="spinner-border text-dark" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="d-flex justify-content-sm-end">
                      <input type="hidden" id="loader_count3">
                      <label id="counter_view3"></label>
                    </div>
                    <div class="d-flex justify-content-sm-center">
                      <button type="button" class="btn bg-lime" id="load_more_data3" style="display:none;" onclick="load_machine_docs(2)">Load more</button>
                      <button type="button" class="btn bg-lime" id="search_more_data3" style="display:none;" onclick="load_machine_docs(4)">Load more</button>
                    </div>
                  </div>

                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/mstprc-setup-step1_modal.php');
include('plugins/modals/mstprc-setup-step2_modal.php');
include('plugins/modals/mstprc-setup-sou_modal.php');
include('plugins/modals/mstprc-setup-fat_modal.php');
include('plugins/modals/mstprc-transfer-step1_modal.php');
include('plugins/modals/mstprc-transfer-step2_modal.php');
include('plugins/modals/mstprc-transfer-fat_modal.php');
include('plugins/modals/mstprc-pullout-step1_modal.php');
include('plugins/modals/mstprc-pullout-step2_modal.php');
include('plugins/modals/mstprc-pullout-fat_modal.php');
include('plugins/modals/mstprc-relayout-step1_modal.php');
include('plugins/modals/mstprc-relayout-step2_modal.php');
include('plugins/modals/pending-mstprc_modal.php');
include('plugins/modals/mstprc-fat-details_modal.php');
include('plugins/modals/mstprc-sou-details_modal.php');
include('plugins/modals/mstprc-history_modal.php');
include('plugins/modals/machine-docs_add.php');
include('plugins/modals/machine-docs_details.php');
include('plugins/modals/machine-docs_delete.php');
include('plugins/modals/returned-mstprc_modal.php');
include('plugins/modals/returned-mstprc-fat-details_modal.php');
include('plugins/modals/returned-mstprc-sou-details_modal.php');
include('plugins/js/machine-checksheets_script.php');
?>
