// Global Variables for Realtime Tables
var realtime_get_need_rsir_machine_checksheets;
var realtime_get_pending_machine_checksheets;
var realtime_get_recent_pm_records;
var realtime_get_returned_machine_checksheets;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_need_rsir_machine_checksheets();
  realtime_get_need_rsir_machine_checksheets = setInterval(get_need_rsir_machine_checksheets, 5000);
  get_pending_machine_checksheets();
  realtime_get_pending_machine_checksheets = setInterval(get_pending_machine_checksheets, 5000);
  get_recent_pm_records();
  realtime_get_recent_pm_records = setInterval(get_recent_pm_records, 7500);
  get_returned_machine_checksheets();
  realtime_get_returned_machine_checksheets = setInterval(get_returned_machine_checksheets, 7500);
  load_notif_setup();
  realtime_load_notif_setup = setInterval(load_notif_setup, 5000);
});

const goto_rsir_step1 = () => {
  var machine_no = document.getElementById("pending_mstprc_machine_no").innerHTML;
  var equipment_no = document.getElementById("pending_mstprc_equipment_no").innerHTML;

  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_machine_details_by_id',
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        var setup_process = response_array.process;
        var machine_name = response_array.machine_name;
        var machine_no = response_array.machine_no;
        var equipment_no = response_array.equipment_no;
        var is_new = response_array.is_new;
        var registered = response_array.registered;

        clear_rsir_step1_fields();

        if (registered == true) {
          document.getElementById("rsir_machine_no").value = machine_no;
          document.getElementById("rsir_equipment_no").value = equipment_no;
          document.getElementById("rsir_machine_name").value = machine_name;
          document.getElementById("rsir_process").value = setup_process;
          document.getElementById("rsir_is_new").value = is_new;
          if (is_new == 0) {
            document.getElementById("rsir_is_new").checked = false;
          } else if (is_new == 1) {
            document.getElementById("rsir_is_new").checked = true;
          }
        }
      } catch(e) {
        console.log(response);
        swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });

  $('#NeedRsirMachineChecksheetInfoModal').modal('hide');
  setTimeout(() => {
    $('#RsirStep1Modal').modal('show');
  }, 400);
}

const clear_rsir_step1_fields = () => {
  document.getElementById("rsir_machine_no").value = '';
  document.getElementById("rsir_equipment_no").value = '';
  document.getElementById("rsir_machine_name").value = '';
  document.getElementById("rsir_process").value = '';
  document.getElementById("rsir_is_new").value = '';
  document.getElementById("rsir_is_new").checked = false;
  document.getElementById("rsir_type").value = '';
  document.getElementById("rsir_date").value = '';
}

const goto_rsir_step2 = () => {
  var machine_no = document.getElementById("rsir_machine_no").value.trim();
  var equipment_no = document.getElementById("rsir_equipment_no").value.trim();
  var machine_name = document.getElementById("rsir_machine_name").value;
  var rsir_type = document.getElementById("rsir_type").value;
  var rsir_date = document.getElementById("rsir_date").value;
  var rsir_no = document.getElementById("rsir_no").value;
  
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'goto_rsir_step2',
      machine_no:machine_no,
      equipment_no:equipment_no,
      machine_name:machine_name,
      rsir_type:rsir_type,
      rsir_date:rsir_date,
      rsir_no:rsir_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        try {
          let response_array = JSON.parse(response);
          if (response_array.message == 'success') {
            document.getElementById("rsir_no").value = response_array.rsir_no;
            document.getElementById("rsir_no2").innerHTML = response_array.rsir_no;
            document.getElementById("rsir_type2").innerHTML = rsir_type;
            document.getElementById("rsir_date2").innerHTML = rsir_date;
            document.getElementById("rsir_machine_no2").innerHTML = machine_no;
            document.getElementById("rsir_equipment_no2").innerHTML = equipment_no;
            document.getElementById("rsir_machine_name2").innerHTML = machine_name;
            $('#RsirStep1Modal').modal('hide');
            setTimeout(() => {
              $('#RsirStep2Modal').modal('show');
            }, 400);
          } else if (response_array.message == 'Machine Indentification Empty') {
            swal('Machine Checksheets', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Forgotten Enter Key') {
            swal('Machine Checksheets', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Unregistered Machine') {
            swal('Machine Checksheets Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
          } else if (response_array.message == 'RSIR Type Not Set') {
            swal('Machine Checksheets', 'Please set Kind of Inspection', 'info');
          } else if (response_array.message == 'Date Not Set') {
            swal('Machine Checksheets', 'Please set RSIR Date', 'info');
          } else if (response_array.message == 'Not For RSIR') {
            swal('Machine Checksheets Error', 'Only Machines inside this company are allowed for RSIR', 'error');
          } else if (response_array.message == 'Checksheet On Process') {
            swal('Machine Checksheets', 'Machine Checksheet is already on process of approval', 'info');
          } else if (response_array.message == 'Machine Identification Mismatch') {
            swal('Machine Checksheets Error', 'The recent and current checksheet information was mismatched. Re-open this form or fill out recent information.', 'error');
          } else {
            console.log(response);
            swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
          }
        } catch(e) {
          console.log(response);
          swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const clear_rsir_step2_fields = () => {
  document.getElementById("rsir_approver_role").value = '';
  document.getElementById("rsir_next_pm_date").value = '';
  document.getElementById("rsir_repair_details").value = '';
  document.getElementById("rsir_repair_date").value = '';
  document.getElementById("rsir_repaired_by").value = '';
}

const download_rsir_format = () => {
  var machine_name = document.getElementById("rsir_machine_name2").innerHTML;
  $.ajax({
    url: '../process/admin/setup-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'download_rsir_format',
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        var rsir_file_url = response;
        window.open(rsir_file_url,'_blank');
      } else {
        swal('Machine Checksheet Error', 'No RSIR Format found for this machine', 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const goto_pm_sticker = () => {
  var machine_no = document.getElementById("rsir_machine_no").value.trim();
  var equipment_no = document.getElementById("rsir_equipment_no").value.trim();
  var machine_name = document.getElementById("rsir_machine_name").value;
  
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_machine_name").value = machine_name;

  $('#RsirStep2Modal').modal('hide');
  setTimeout(() => {
    $('#PmStickerContentModal').modal('show');
  }, 400);
}

const clear_pm_sticker_fields = () => {
  document.getElementById("u_ww_start_date").value = '';
  document.getElementById("u_ww_next_date").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_manpower").value = '';
  document.getElementById("u_shift_engineer").value = '';
}

const print_single_pm_sticker = () => {
  var ww_start_date = document.getElementById("u_ww_start_date").value;
  var ww_next_date = document.getElementById("u_ww_next_date").value;
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();
  var machine_name = document.getElementById("u_machine_name").value;
  var manpower = document.getElementById("u_manpower").value.trim();
  var shift_engineer = document.getElementById("u_shift_engineer").value.trim();

  window.open('../process/print/print_single_pm_sticker.php?ww_start_date='+ww_start_date
    +'&&ww_next_date='+ww_next_date+'&&machine_no='+machine_no+'&&equipment_no='+equipment_no
    +'&&machine_name='+machine_name+'&&manpower='+manpower+'&&shift_engineer='+shift_engineer,'_blank');
}

const save_rsir = () => {
  var form_data = new FormData();
  var ins = document.getElementById('rsir_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('rsir_file').files[x]);
  }
  form_data.append("method", 'save_rsir');
  form_data.append("rsir_no", document.getElementById('rsir_no').value);
  form_data.append("machine_no", document.getElementById('rsir_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('rsir_equipment_no').value.trim());
  form_data.append("machine_name", document.getElementById('rsir_machine_name').value);
  form_data.append("rsir_type", document.getElementById('rsir_type').value);
  form_data.append("rsir_date", document.getElementById('rsir_date').value);
  form_data.append("rsir_approver_role", document.getElementById('rsir_approver_role').value);
  form_data.append("next_pm_date", document.getElementById('rsir_next_pm_date').value);
  form_data.append("repair_details", document.getElementById('rsir_repair_details').value.trim());
  form_data.append("repair_date", document.getElementById('rsir_repair_date').value.trim());
  form_data.append("repaired_by", document.getElementById('rsir_repaired_by').value.trim());
  form_data.append("mstprc_no", document.getElementById('pending_mstprc_no').innerHTML);

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response != '') {
          swal('Machine Checksheets', `Error: ${response}`, 'error');
        } else {
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("rsir_no").value = '';
          clear_rsir_step1_fields();
          clear_rsir_step2_fields();
          clear_pm_sticker_fields();
          get_pending_machine_checksheets();
          $('#RsirStep2Modal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details_need_rsir_machine_checksheets = el => {
  var mstprc_no = el.dataset.mstprc_no;
  var mstprc_type = el.dataset.mstprc_type;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var car_model = el.dataset.car_model;
  var location = el.dataset.location;
  var grid = el.dataset.grid;
  var to_car_model = el.dataset.to_car_model;
  var to_location = el.dataset.to_location;
  var to_grid = el.dataset.to_grid;
  var pullout_location = el.dataset.pullout_location;
  var transfer_reason = el.dataset.transfer_reason;
  var pullout_reason = el.dataset.pullout_reason;
  var mstprc_date = el.dataset.mstprc_date;
  var mstprc_process_status = el.dataset.mstprc_process_status;

  var mstprc_eq_member = el.dataset.mstprc_eq_member;
  var mstprc_eq_g_leader = el.dataset.mstprc_eq_g_leader;
  var mstprc_safety_officer = el.dataset.mstprc_safety_officer;
  var mstprc_eq_manager = el.dataset.mstprc_eq_manager;
  var mstprc_eq_sp_personnel = el.dataset.mstprc_eq_sp_personnel;
  var mstprc_prod_engr_manager = el.dataset.mstprc_prod_engr_manager;
  var mstprc_prod_supervisor = el.dataset.mstprc_prod_supervisor;
  var mstprc_prod_manager = el.dataset.mstprc_prod_manager;
  var mstprc_qa_supervisor = el.dataset.mstprc_qa_supervisor;
  var mstprc_qa_manager = el.dataset.mstprc_qa_manager;

  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  document.getElementById("pending_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("pending_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("pending_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("pending_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("pending_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("pending_mstprc_car_model").value = car_model;
  document.getElementById("pending_mstprc_location").value = location;
  document.getElementById("pending_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("pending_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("pending_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("pending_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("pending_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("pending_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("pending_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("pending_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("pending_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("pending_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("pending_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("pending_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("pending_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("pending_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("pending_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("pending_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("pending_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("pending_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("pending_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("pending_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("pending_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("pending_mstprc_qa_manager").value = mstprc_qa_manager;

  document.getElementById("pending_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("pending_mstprc_transfer_reason").innerHTML = transfer_reason;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("pending_mstprc_from_car_model").value = car_model;
    document.getElementById("pending_mstprc_from_location").value = location;
    document.getElementById("pending_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("pending_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("pending_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("pending_mstprc_to_car_model").value = to_car_model;
  document.getElementById("pending_mstprc_to_location").value = to_location;
  document.getElementById("pending_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("pending_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("pending_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("pending_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("pending_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("pending_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("pending_mstprc_file_name").innerHTML = file_name;
  document.getElementById("pending_mstprc_file_url").value = file_url;
}

const count_need_rsir_machine_checksheets = () => {
  var history_option = sessionStorage.getItem('history_option');

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_need_rsir_machine_checksheets',
      history_option: history_option
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let counter_view = "";
      if (total_rows != 0) {
        let counter_view_search = "";
        if (total_rows < 2) {
          counter_view_search = `${total_rows} record found`;
        } else {
          counter_view_search = `${total_rows} records found`;
        }
        document.getElementById("counter_view_search").innerHTML = counter_view_search;
        document.getElementById("counter_view_search").style.display = 'block';
      } else {
        document.getElementById("counter_view_search").style.display = 'none';
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_need_rsir_machine_checksheets = () => {
  var history_option = document.getElementById("history_option").value;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_need_rsir_machine_checksheets',
      history_option: history_option
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("machineChecksheetPendingData").innerHTML = response;
      sessionStorage.setItem('history_option', history_option);
      count_need_rsir_machine_checksheets();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_need_rsir_machine_checksheets);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const download_pending_mstprc = () => {
  var file_url = document.getElementById("pending_mstprc_file_url").value;
  window.open(file_url,'_blank');
}

$('#pendingPmRecordsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_pending_machine_checksheets = el => {
  var rsir_no = el.dataset.rsir_no;
  var rsir_type = el.dataset.rsir_type;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var rsir_date = el.dataset.rsir_date;
  var rsir_process_status = el.dataset.rsir_process_status;

  var judgement_of_eq = el.dataset.judgement_of_eq;
  var judgement_of_prod = el.dataset.judgement_of_prod;
  var repair_details = el.dataset.repair_details;
  var inspected_by = el.dataset.inspected_by;
  var repair_date = el.dataset.repair_date;
  var confirmed_by = el.dataset.confirmed_by;
  var repaired_by = el.dataset.repaired_by;
  var judgement_by = el.dataset.judgement_by;
  var next_pm_date = el.dataset.next_pm_date;

  var rsir_approver_role = el.dataset.rsir_approver_role;

  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  document.getElementById("pending_rsir_no").innerHTML = rsir_no;
  document.getElementById("pending_rsir_type").innerHTML = rsir_type;
  document.getElementById("pending_rsir_machine_name").innerHTML = machine_name;
  document.getElementById("pending_rsir_machine_no").innerHTML = machine_no;
  document.getElementById("pending_rsir_equipment_no").innerHTML = equipment_no;
  document.getElementById("pending_rsir_date").innerHTML = rsir_date;

  document.getElementById("pending_rsir_judgement_of_eq").innerHTML = judgement_of_eq;
  document.getElementById("pending_rsir_repair_details").innerHTML = repair_details;
  document.getElementById("pending_rsir_judgement_of_prod").innerHTML = judgement_of_prod;
  document.getElementById("pending_rsir_confirmed_by").innerHTML = confirmed_by;
  document.getElementById("pending_rsir_repair_date").innerHTML = repair_date;
  document.getElementById("pending_rsir_inspected_by").innerHTML = inspected_by;
  document.getElementById("pending_rsir_repaired_by").innerHTML = repaired_by;
  document.getElementById("pending_rsir_judgement_by").innerHTML = judgement_by;
  document.getElementById("pending_rsir_next_pm_date").innerHTML = next_pm_date;

  document.getElementById("pending_rsir_approver_role").value = rsir_approver_role;

  document.getElementById("pending_rsir_file_name").innerHTML = file_name;
  document.getElementById("pending_rsir_file_url").value = file_url;

  if (rsir_process_status == 'Saved' && getCookie('setup_role') == 'Admin') {
    document.getElementById("ok_rsir_judgement_of_eq").removeAttribute('disabled');
    document.getElementById("adj_rsir_judgement_of_eq").removeAttribute('disabled');
    document.getElementById("ng_rsir_judgement_of_eq").removeAttribute('disabled');
    document.getElementById("na_rsir_judgement_of_eq").removeAttribute('disabled');
    document.getElementById("btnReturnPendingRsir").removeAttribute('disabled');
    document.getElementById("btnReturnPendingRsir").style.display = 'block';
    document.getElementById("btnConfirmPendingRsir").removeAttribute('disabled');
    document.getElementById("btnConfirmPendingRsir").style.display = 'block';
  } else {
    document.getElementById("ok_rsir_judgement_of_eq").setAttribute('disabled', true);
    document.getElementById("adj_rsir_judgement_of_eq").setAttribute('disabled', true);
    document.getElementById("ng_rsir_judgement_of_eq").setAttribute('disabled', true);
    document.getElementById("na_rsir_judgement_of_eq").setAttribute('disabled', true);
    document.getElementById("btnReturnPendingRsir").setAttribute('disabled', true);
    document.getElementById("btnReturnPendingRsir").style.display = 'none';
    document.getElementById("btnConfirmPendingRsir").setAttribute('disabled', true);
    document.getElementById("btnConfirmPendingRsir").style.display = 'none';
  }

  document.getElementById('ok_rsir_judgement_of_eq').checked = false;
  document.getElementById('adj_rsir_judgement_of_eq').checked = false;
  document.getElementById('ng_rsir_judgement_of_eq').checked = false;
  document.getElementById('na_rsir_judgement_of_eq').checked = false;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pending_machine_checksheets_mark_as_read',
      rsir_process_status:rsir_process_status,
      rsir_no:rsir_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_pending_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pending_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let counter_view = "";
      if (total_rows != 0) {
        let counter_view_search2 = "";
        if (total_rows < 2) {
          counter_view_search2 = `${total_rows} record found`;
        } else {
          counter_view_search2 = `${total_rows} records found`;
        }
        document.getElementById("counter_view_search2").innerHTML = counter_view_search2;
        document.getElementById("counter_view_search2").style.display = 'block';
      } else {
        document.getElementById("counter_view_search2").style.display = 'none';
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_pending_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_pending_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pendingPmRecordsData").innerHTML = response; 
      count_pending_machine_checksheets();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_pending_machine_checksheets);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const download_pending_rsir = opt => {
  let file_url = '';
  switch(opt) {
    case 1:
      file_url = document.getElementById("pending_rsir_file_url").value;
      break;
    case 2:
      file_url = document.getElementById("returned_rsir_file_url").value;
      break;
    default:
  }
  window.open(file_url,'_blank');
}

$('#returnedPmRecordsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_returned_machine_checksheets = el => {
  var rsir_no = el.dataset.rsir_no;
  var rsir_type = el.dataset.rsir_type;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var rsir_date = el.dataset.rsir_date;
  var rsir_process_status = el.dataset.rsir_process_status;

  var judgement_of_eq = el.dataset.judgement_of_eq;
  var judgement_of_prod = el.dataset.judgement_of_prod;
  var repair_details = el.dataset.repair_details;
  var inspected_by = el.dataset.inspected_by;
  var repair_date = el.dataset.repair_date;
  var confirmed_by = el.dataset.confirmed_by;
  var repaired_by = el.dataset.repaired_by;
  var judgement_by = el.dataset.judgement_by;
  var next_pm_date = el.dataset.next_pm_date;

  var rsir_approver_role = el.dataset.rsir_approver_role;

  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  document.getElementById("returned_rsir_no").innerHTML = rsir_no;
  document.getElementById("returned_rsir_type").innerHTML = rsir_type;
  document.getElementById("returned_rsir_machine_name").innerHTML = machine_name;
  document.getElementById("returned_rsir_machine_no").innerHTML = machine_no;
  document.getElementById("returned_rsir_equipment_no").innerHTML = equipment_no;
  document.getElementById("returned_rsir_date").innerHTML = rsir_date;

  document.getElementById("returned_rsir_judgement_of_eq").innerHTML = judgement_of_eq;
  document.getElementById("returned_rsir_repair_details").innerHTML = repair_details;
  document.getElementById("returned_rsir_judgement_of_prod").innerHTML = judgement_of_prod;
  document.getElementById("returned_rsir_confirmed_by").innerHTML = confirmed_by;
  document.getElementById("returned_rsir_repair_date").innerHTML = repair_date;
  document.getElementById("returned_rsir_inspected_by").innerHTML = inspected_by;
  document.getElementById("returned_rsir_repaired_by").innerHTML = repaired_by;
  document.getElementById("returned_rsir_judgement_by").innerHTML = judgement_by;
  document.getElementById("returned_rsir_next_pm_date").innerHTML = next_pm_date;

  document.getElementById("returned_rsir_approver_role").value = rsir_approver_role;

  document.getElementById("returned_rsir_file_name").innerHTML = file_name;
  document.getElementById("returned_rsir_file_url").value = file_url;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'returned_machine_checksheets_mark_as_read',
      rsir_process_status:rsir_process_status,
      rsir_no:rsir_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_returned_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_returned_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let counter_view4 = "";
      if (total_rows != 0) {
        let counter_view_search4 = "";
        if (total_rows < 2) {
          counter_view_search4 = `${total_rows} record found`;
        } else {
          counter_view_search4 = `${total_rows} records found`;
        }
        document.getElementById("counter_view_search4").innerHTML = counter_view_search4;
        document.getElementById("counter_view_search4").style.display = 'block';
      } else {
        document.getElementById("counter_view_search4").style.display = 'none';
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_returned_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_returned_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("returnedPmRecordsData").innerHTML = response; 
      count_returned_machine_checksheets();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_returned_machine_checksheets);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const revise_returned_rsir = () => {
  var rsir_no = document.getElementById("returned_rsir_no").innerHTML;
  var rsir_type = document.getElementById("returned_rsir_type").innerHTML;
  var machine_name = document.getElementById("returned_rsir_machine_name").innerHTML;
  var machine_no = document.getElementById("returned_rsir_machine_no").innerHTML;
  var equipment_no = document.getElementById("returned_rsir_equipment_no").innerHTML;

  var rsir_date = document.getElementById("returned_rsir_date").innerHTML;
  rsir_date.replace("-", " ");
  rsir_date = new Date(rsir_date);
  let day = rsir_date.getDate();
  let month = rsir_date.getMonth();
  let year = rsir_date.getFullYear();
  if (day < 10) {
    day = '0' + day;
  }
  month++;
  if (month < 10) {
    month = `0${month}`;
  } else {
    month = `${month}`;
  }
  rsir_date = `${year}-${month}-${day}`;

  var repair_details = document.getElementById("returned_rsir_repair_details").innerHTML;
  var repair_date = document.getElementById("returned_rsir_repair_date").innerHTML;
  var repaired_by = document.getElementById("returned_rsir_repaired_by").innerHTML;
  var next_pm_date = document.getElementById("returned_rsir_next_pm_date").innerHTML;

  var rsir_approver_role = document.getElementById("returned_rsir_approver_role").value;

  document.getElementById('rsir_no').value = rsir_no;
  document.getElementById('rsir_machine_no').value = machine_no;
  document.getElementById('rsir_equipment_no').value = equipment_no;
  document.getElementById('rsir_machine_name').value = machine_name;
  document.getElementById('rsir_type').value = rsir_type;
  document.getElementById('rsir_date').value = rsir_date;
  document.getElementById('rsir_approver_role').value = rsir_approver_role;
  document.getElementById('rsir_next_pm_date').value = next_pm_date;
  document.getElementById('rsir_repair_details').value = repair_details;
  document.getElementById('rsir_repair_date').value = repair_date;
  document.getElementById('rsir_repaired_by').value = repaired_by;

  $('#ReturnedMachineChecksheetInfoModal').modal('hide');
  setTimeout(() => {$('#RsirStep1Modal').modal('show');}, 400);
}

const return_pending_rsir = () => {
  var rsir_no = document.getElementById("pending_rsir_no").innerHTML;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'return_pending_rsir',
      rsir_no:rsir_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Machine Checksheets', 'Returned Successfully', 'success');
          get_pending_machine_checksheets();
          get_returned_machine_checksheets();
          document.getElementById('ok_rsir_judgement_of_eq').checked = false;
          document.getElementById('adj_rsir_judgement_of_eq').checked = false;
          document.getElementById('ng_rsir_judgement_of_eq').checked = false;
          document.getElementById('na_rsir_judgement_of_eq').checked = false;
          $('#PendingMachineChecksheetInfoModal').modal('hide');
        } else {
          console.log(response);
          swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const confirm_pending_rsir = () => {
  var rsir_no = document.getElementById("pending_rsir_no").innerHTML;
  var rsir_judgement_of_eq = document.getElementsByName('rsir_judgement_of_eq');
  var judgement_of_eq = '';
  for (i = 0; i < rsir_judgement_of_eq.length; i++) {
    if (rsir_judgement_of_eq[i].checked)
      judgement_of_eq = rsir_judgement_of_eq[i].value;
  }
  var rsir_approver_role = document.getElementById("pending_rsir_approver_role").value;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'confirm_pending_rsir',
      rsir_no:rsir_no,
      judgement_of_eq:judgement_of_eq,
      rsir_approver_role:rsir_approver_role
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Loading please wait...', {
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
      });
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      setTimeout(() => {
        swal.close();
        if (response == 'success') {
          swal('Machine Checksheets', 'Confirmed Successfully', 'success');
          get_pending_machine_checksheets();
          document.getElementById('ok_rsir_judgement_of_eq').checked = false;
          document.getElementById('adj_rsir_judgement_of_eq').checked = false;
          document.getElementById('ng_rsir_judgement_of_eq').checked = false;
          document.getElementById('na_rsir_judgement_of_eq').checked = false;
          $('#PendingMachineChecksheetInfoModal').modal('hide');
        } else if (response == 'Judgement Of Equipment Empty') {
          swal('Machine Checksheets', 'Please set Judgement Of Equipment', 'info');
        } else {
          console.log(response);
          swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#recentPmRecordsHistoryTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_machine_checksheets_history = el => {
  var rsir_no = el.dataset.rsir_no;
  var rsir_type = el.dataset.rsir_type;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var rsir_date = el.dataset.rsir_date;
  var rsir_process_status = el.dataset.rsir_process_status;

  var judgement_of_eq = el.dataset.judgement_of_eq;
  var judgement_of_prod = el.dataset.judgement_of_prod;
  var repair_details = el.dataset.repair_details;
  var inspected_by = el.dataset.inspected_by;
  var repair_date = el.dataset.repair_date;
  var confirmed_by = el.dataset.confirmed_by;
  var repaired_by = el.dataset.repaired_by;
  var judgement_by = el.dataset.judgement_by;
  var next_pm_date = el.dataset.next_pm_date;

  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  var disapproved_by = el.dataset.disapproved_by;
  var disapproved_by_role = el.dataset.disapproved_by_role;
  var disapproved_comment = el.dataset.disapproved_comment;

  document.getElementById("history_rsir_no2").innerHTML = rsir_no;
  document.getElementById("history_rsir_type2").innerHTML = rsir_type;
  document.getElementById("history_rsir_machine_name2").innerHTML = machine_name;
  document.getElementById("history_rsir_machine_no2").innerHTML = machine_no;
  document.getElementById("history_rsir_equipment_no2").innerHTML = equipment_no;
  document.getElementById("history_rsir_date2").innerHTML = rsir_date;

  document.getElementById("history_rsir_judgement_of_eq").innerHTML = judgement_of_eq;
  document.getElementById("history_rsir_repair_details").innerHTML = repair_details;
  document.getElementById("history_rsir_judgement_of_prod").innerHTML = judgement_of_prod;
  document.getElementById("history_rsir_confirmed_by").innerHTML = confirmed_by;
  document.getElementById("history_rsir_repair_date").innerHTML = repair_date;
  document.getElementById("history_rsir_inspected_by").innerHTML = inspected_by;
  document.getElementById("history_rsir_repaired_by").innerHTML = repaired_by;
  document.getElementById("history_rsir_judgement_by").innerHTML = judgement_by;
  document.getElementById("history_rsir_next_pm_date").innerHTML = next_pm_date;

  document.getElementById("history_rsir_file_name").innerHTML = file_name;
  document.getElementById("history_rsir_file_url").value = file_url;

  document.getElementById("history_rsir_disapproved_by").innerHTML = disapproved_by;
  document.getElementById("history_rsir_disapproved_by_role").innerHTML = disapproved_by_role;
  document.getElementById("history_rsir_disapproved_comment").innerHTML = disapproved_comment;

  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'history_machine_checksheets_mark_as_read',
      rsir_process_status:rsir_process_status,
      rsir_no:rsir_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_recent_pm_records = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets-pm_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_recent_pm_records'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("recentPmRecordsHistoryData").innerHTML = response; 
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_recent_pm_records);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    }
  });
}

const download_rsir_history = () => {
  var file_url = document.getElementById("history_rsir_file_url").value;
  window.open(file_url,'_blank');
}
