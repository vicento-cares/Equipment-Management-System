// Global Variables for Realtime Tables
var realtime_get_pending_machine_checksheets;
var realtime_get_recent_pm_records;
var realtime_get_returned_machine_checksheets;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('pm_role') != 'Admin') {
    document.getElementById("btnGoAddMachineDocs").setAttribute('disabled', true);
    document.getElementById("btnAddMachineDocs").setAttribute('disabled', true);
    document.getElementById("btnAddMachineDocs").style.display = 'none';
    document.getElementById("u_machine_name").setAttribute('disabled', true);
    document.getElementById("u_machine_docs_type").setAttribute('disabled', true);
    document.getElementById("u_machine_docs_file").setAttribute('disabled', true);
    document.getElementById("btnUpdateMachineDocs").setAttribute('disabled', true);
    document.getElementById("btnUpdateMachineDocs").style.display = 'none';
    document.getElementById("btnGoDeleteMachineDocs").setAttribute('disabled', true);
    document.getElementById("btnGoDeleteMachineDocs").style.display = 'none';
  }
  get_machines_dropdown();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  load_machine_docs(1);

  get_pending_machine_checksheets();
  realtime_get_pending_machine_checksheets = setInterval(get_pending_machine_checksheets, 5000);
  get_recent_pm_records();
  realtime_get_recent_pm_records = setInterval(get_recent_pm_records, 7500);
  get_returned_machine_checksheets();
  realtime_get_returned_machine_checksheets = setInterval(get_returned_machine_checksheets, 7500);
  load_notif_pm_rsir_page();
  realtime_load_notif_pm_rsir_page = setInterval(load_notif_pm_rsir_page, 7500);
  update_notif_approved_rsir();
  update_notif_disapproved_rsir();
});

const get_machines_dropdown = () => {
  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_machines_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("i_machine_name").innerHTML = response;
      document.getElementById("u_machine_name").innerHTML = response;
      document.getElementById("work_order_machine_name").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_machine_no_datalist = () => {
  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_machine_no_datalist'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("rsir_machines_no").innerHTML = response;
      document.getElementById("work_order_machines_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_equipment_no_datalist = () => {
  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_equipment_no_datalist'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("rsir_equipments_no").innerHTML = response;
      document.getElementById("work_order_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

document.getElementById("rsir_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id();
  } else {
    document.getElementById("rsir_equipment_no").value = '';
    document.getElementById("rsir_machine_name").value = '';
    document.getElementById("rsir_process").value = '';
    document.getElementById("rsir_is_new").value = '';
    document.getElementById("rsir_is_new").checked = false;
  }
});

document.getElementById("rsir_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id();
  } else {
    document.getElementById("rsir_machine_no").value = '';
    document.getElementById("rsir_machine_name").value = '';
    document.getElementById("rsir_process").value = '';
    document.getElementById("rsir_is_new").value = '';
    document.getElementById("rsir_is_new").checked = false;
  }
});

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


const get_machine_details_by_id = () => {
  var machine_no = document.getElementById("rsir_machine_no").value.trim();
  var equipment_no = document.getElementById("rsir_equipment_no").value.trim();

  if (machine_no != '' || equipment_no != '') {
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
          var pm_process = response_array.process;
          var machine_name = response_array.machine_name;
          var machine_no = response_array.machine_no;
          var equipment_no = response_array.equipment_no;
          var is_new = response_array.is_new;
          var registered = response_array.registered;

          if (registered == true) {
            document.getElementById("rsir_machine_no").value = machine_no;
            document.getElementById("rsir_equipment_no").value = equipment_no;
            document.getElementById("rsir_machine_name").value = machine_name;
            document.getElementById("rsir_process").value = pm_process;
            document.getElementById("rsir_is_new").value = is_new;
            if (is_new == 0) {
              document.getElementById("rsir_is_new").checked = false;
            } else if (is_new == 1) {
              document.getElementById("rsir_is_new").checked = true;
            }
          } else {
            swal('Machine Checksheets Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
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
  }
}

const goto_rsir_step2 = () => {
  var machine_no = document.getElementById("rsir_machine_no").value.trim();
  var equipment_no = document.getElementById("rsir_equipment_no").value.trim();
  var machine_name = document.getElementById("rsir_machine_name").value;
  var rsir_type = document.getElementById("rsir_type").value;
  var rsir_date = document.getElementById("rsir_date").value;
  var rsir_no = document.getElementById("rsir_no").value;
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/pm-machine-docs_processor.php',
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

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
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

  if (rsir_process_status == 'Saved' && getCookie('pm_role') == 'Admin') {
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
      let table_rows = parseInt(document.getElementById("pendingPmRecordsData").childNodes.length);
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

const get_pending_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
      let table_rows = parseInt(document.getElementById("returnedPmRecordsData").childNodes.length);
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
    url: '../process/admin/machine-checksheets_processor.php',
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
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const download_rsir_history = () => {
  var file_url = document.getElementById("history_rsir_file_url").value;
  window.open(file_url,'_blank');
}

const get_details_machine_docs = el => {
  var id = el.dataset.id;
  var pm_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var machine_docs_type = el.dataset.machine_docs_type;
  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  document.getElementById("u_id").value = id;
  document.getElementById("u_process").value = pm_process;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_machine_docs_type").value = machine_docs_type;
  document.getElementById("u_file_name").innerHTML = file_name;
  document.getElementById("u_file_url").value = file_url;
}

const count_machine_docs = () => {
  var i_search = sessionStorage.getItem('saved_i_search');
  
  $.ajax({
    url: '../process/admin/pm-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_machine_docs',
      search: i_search
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("machineDocsData").childNodes.length);
      let loader_count3 = document.getElementById("loader_count3").value;
      if (i_search == '') {
        document.getElementById("counter_view_search3").style.display = 'none';
        document.getElementById("search_more_data3").style.display = 'none';
        let counter_view3 = "";
        if (total_rows != 0) {
          if (total_rows < 2) {
            counter_view3 = `${table_rows} row of ${total_rows} record`;
          } else {
            counter_view3 = `${table_rows} rows of ${total_rows} records`;
          }
          document.getElementById("counter_view3").innerHTML = counter_view3;
          document.getElementById("counter_view3").style.display = 'block';
        } else {
          document.getElementById("counter_view3").style.display = 'none';
        }

        if (total_rows == 0) {
          document.getElementById("load_more_data3").style.display = 'none';
        } else if (total_rows > loader_count3) {
          document.getElementById("load_more_data3").style.display = 'block';
        } else if (total_rows <= loader_count3) {
          document.getElementById("load_more_data3").style.display = 'none';
        }
      } else {
        document.getElementById("counter_view3").style.display = 'none';
        document.getElementById("load_more_data3").style.display = 'none';
        let counter_view3 = "";
        if (total_rows != 0) {
          let counter_view_search3 = "";
          if (total_rows < 2) {
            counter_view_search3 = `${total_rows} record found`;
            counter_view3 = `${table_rows} row of ${total_rows} record`;
          } else {
            counter_view_search3 = `${total_rows} records found`;
            counter_view3 = `${table_rows} rows of ${total_rows} records`;
          }
          document.getElementById("counter_view_search3").innerHTML = counter_view_search3;
          document.getElementById("counter_view_search3").style.display = 'block';
          document.getElementById("counter_view3").innerHTML = counter_view3;
          document.getElementById("counter_view3").style.display = 'block';
        } else {
          document.getElementById("counter_view_search3").style.display = 'none';
          document.getElementById("counter_view3").style.display = 'none';
        }

        if (total_rows == 0) {
          document.getElementById("search_more_data3").style.display = 'none';
        } else if (total_rows > loader_count3) {
          document.getElementById("search_more_data3").style.display = 'block';
        } else if (total_rows <= loader_count3) {
          document.getElementById("search_more_data3").style.display = 'none';
        }
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const load_machine_docs = option => {
  var id = 0;
  var i_search = '';
  var loader_count3 = 0;
  var continue_loading = true;
  switch (option) {
    case 2:
      var id = document.getElementById("machineDocsData").lastChild.getAttribute("id");
      var loader_count3 = parseInt(document.getElementById("loader_count3").value);
      break;
    case 3:
      var i_search = document.getElementById("i_search").value.trim();
      if (i_search == '') {
        var continue_loading = false;
        swal('Machine Masterlist Search', 'Fill out search input field', 'info');
      }
      break;
    case 4:
      var id = document.getElementById("machineDocsData").lastChild.getAttribute("id");
      var i_search = sessionStorage.getItem('saved_i_search');
      var loader_count3 = parseInt(document.getElementById("loader_count3").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/pm-machine-docs_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'load_machine_docs',
        id: id,
        search: i_search,
        c: loader_count3
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="4" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("machineDocsData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("machineDocsData").innerHTML = response;
            document.getElementById("loader_count3").value = 10;
            sessionStorage.setItem('saved_i_search', '');
            break;
          case 3:
            document.getElementById("machineDocsData").innerHTML = response;
            document.getElementById("loader_count3").value = 10;
            sessionStorage.setItem('saved_i_search', i_search);
            break;
          case 2:
          case 4:
            document.getElementById("machineDocsData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count3").value = loader_count + 10;
            break;
          default:
        }
        count_machine_docs();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("i_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_machine_docs(3);
  }
});

document.getElementById("work_order_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_wo();
  } else {
    document.getElementById("work_order_equipment_no").value = '';
    document.getElementById("work_order_machine_name").value = '';
    document.getElementById("work_order_process").value = '';
  }
});

document.getElementById("work_order_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_wo();
  } else {
    document.getElementById("work_order_machine_no").value = '';
    document.getElementById("work_order_machine_name").value = '';
    document.getElementById("work_order_process").value = '';
  }
});

$("#UploadWorkOrderModal").on('hidden.bs.modal', e => {
  document.getElementById("work_order_machine_no").value = '';
  document.getElementById("work_order_equipment_no").value = '';
  document.getElementById("work_order_machine_name").value = '';
  document.getElementById("work_order_process").value = '';
  document.getElementById("work_order_file").value = '';
});

$("#AddMachineDocsModal").on('hidden.bs.modal', e => {
  document.getElementById("i_machine_name").value = '';
  document.getElementById("i_process").value = '';
  document.getElementById("i_machine_docs_file").value = '';
  document.getElementById("i_machine_docs_type").value = '';
});

const clear_machine_docs_info_fields = () => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_process").value = '';
  document.getElementById("u_machine_docs_file").value = '';
  document.getElementById("u_machine_docs_type").value = '';
  document.getElementById("u_file_name").innerHTML = '';
  document.getElementById("u_file_url").value = '';
}

const get_machine_details_wo = () => {
  var machine_no = document.getElementById("work_order_machine_no").value.trim();
  var equipment_no = document.getElementById("work_order_equipment_no").value.trim();

  if (machine_no != '' || equipment_no != '') {
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
          var pm_process = response_array.process;
          var machine_name = response_array.machine_name;
          var machine_no = response_array.machine_no;
          var equipment_no = response_array.equipment_no;
          var registered = response_array.registered;

          if (registered == true) {
            document.getElementById("work_order_machine_no").value = machine_no;
            document.getElementById("work_order_equipment_no").value = equipment_no;
            document.getElementById("work_order_machine_name").value = machine_name;
            document.getElementById("work_order_process").value = pm_process;
          } else {
            swal('Machine Checksheet Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
          }
        } catch(e) {
          console.log(response);
          swal('Machine Checksheet Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const get_machine_details = action => {
  var machine_name = '';
  if (action == 'insert') {
    var machine_name = document.getElementById("i_machine_name").value;
  } else if (action == 'update') {
    var machine_name = document.getElementById("u_machine_name").value;
  }
  if (machine_name != '' && getCookie('pm_role') == 'Admin') {
    $.ajax({
      url: '../process/admin/machines_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_machine_details',
        machine_name:machine_name
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          var pm_process = response_array.process;
          if (action == 'insert') {
            document.getElementById("i_process").value = pm_process;
          } else if (action == 'update') {
            document.getElementById("u_process").value = pm_process;
          }
        } catch(e) {
          console.log(response);
          swal('Machine Checksheet Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const upload_work_order = () => {
  var form_data = new FormData();
  var ins = document.getElementById('work_order_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('work_order_file').files[x]);
  }
  form_data.append("method", 'upload_work_order');
  form_data.append("machine_no", document.getElementById('work_order_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('work_order_equipment_no').value.trim());
  form_data.append("machine_name", document.getElementById('work_order_machine_name').value.trim());
  form_data.append("process", document.getElementById('work_order_process').value);

  $.ajax({
    url: '../process/admin/pm-work-orders_processor.php',
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
          swal('Machine Checksheets', 'PM Work Order File and its information are successfully registered and uploaded', 'success');
          $('#UploadWorkOrderModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// TO BE CONTINUED

const save_machine_docs = () => {
  var form_data = new FormData();
  var ins = document.getElementById('i_machine_docs_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('i_machine_docs_file').files[x]);
  }
  form_data.append("method", 'save_machine_docs');
  form_data.append("machine_name", document.getElementById('i_machine_name').value.trim());
  form_data.append("process", document.getElementById('i_process').value);
  form_data.append("machine_docs_type", document.getElementById('i_machine_docs_type').value.trim());

  $.ajax({
    url: '../process/admin/pm-machine-docs_processor.php',
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
          swal('Machine Checksheets', 'Machine Docs and its information are successfully registered and uploaded', 'success');
          load_machine_docs(1);
          $('#AddMachineDocsModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const download_machine_docs = () => {
  var file_url = document.getElementById("u_file_url").value;
  window.open(file_url,'_blank');
}

const update_machine_docs = () => {
  var form_data = new FormData();
  var ins = document.getElementById('u_machine_docs_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('u_machine_docs_file').files[x]);
  }
  form_data.append("method", 'update_machine_docs');
  form_data.append("id", document.getElementById('u_id').value.trim());
  form_data.append("machine_name", document.getElementById('u_machine_name').value.trim());
  form_data.append("process", document.getElementById('u_process').value);
  form_data.append("machine_docs_type", document.getElementById('u_machine_docs_type').value.trim());

  $.ajax({
    url: '../process/admin/pm-machine-docs_processor.php',
    type: 'POST',
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
          swal('Machine Checksheets', 'Machine Docs and its information are successfully updated or re-uploaded', 'success');
          load_machine_docs(1);
          clear_machine_docs_info_fields();
          $('#MachineDocsDetailsModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const delete_machine_docs = () => {
  var id = document.getElementById('u_id').value.trim();

  $.ajax({
    url: '../process/admin/pm-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_machine_docs',
      id:id
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
        if (response != '') {
          swal('Machine Checksheets', `Error: ${response}`, 'error');
        } else {
          swal('Machine Checksheets', 'Machine Docs and its information are successfully deleted', 'info');
          load_machine_docs(1);
          clear_machine_docs_info_fields();
          $('#deleteMachineDocsModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}