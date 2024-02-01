// Global Variables for Realtime Tables
var realtime_get_machine_checksheets_prod;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_car_models_datalist_search();
  get_locations_datalist_search();
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  get_machine_checksheets_prod();
  realtime_get_machine_checksheets_prod = setInterval(get_machine_checksheets_prod, 5000);
  sessionStorage.setItem('notif_pending_rsir', 0);
  load_notif_pending_rsir_page();
  realtime_load_notif_pending_rsir_page = setInterval(load_notif_pending_rsir_page, 5000);
  update_notif_pending_rsir();
});

const get_car_models_datalist_search = () => {
  $.ajax({
    url: '../process/admin/car-models_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_car_model_datalist_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pending_car_models_search").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_locations_datalist_search = () => {
  $.ajax({
    url: '../process/admin/locations_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_location_datalist_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pending_locations_search").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_machines_datalist_search = () => {
  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_machines_datalist_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pending_machines_search").innerHTML = response;
      document.getElementById("history_machines").innerHTML = response;
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
      document.getElementById("pending_machines_no_search").innerHTML = response;
      document.getElementById("history_machines_no").innerHTML = response;
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
      document.getElementById("pending_equipments_no_search").innerHTML = response;
      document.getElementById("history_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

document.getElementById("pending_car_model_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_location_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_machine_name_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_grid_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_rsir_no_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_machine_no_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

document.getElementById("pending_equipment_no_search").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_checksheets_prod();
  }
});

$('#pendingPmRecordsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-warning');
});

const get_details_machine_checksheets_prod = el => {
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

  document.getElementById("pending_rsir_file_name").innerHTML = file_name;
  document.getElementById("pending_rsir_file_url").value = file_url;

  if (rsir_process_status == 'Confirmed') {
    document.getElementById("ok_rsir_judgement_of_prod").removeAttribute('disabled');
    document.getElementById("adj_rsir_judgement_of_prod").removeAttribute('disabled');
    document.getElementById("ng_rsir_judgement_of_prod").removeAttribute('disabled');
    document.getElementById("na_rsir_judgement_of_prod").removeAttribute('disabled');
  } else {
    document.getElementById("ok_rsir_judgement_of_prod").setAttribute('disabled', true);
    document.getElementById("adj_rsir_judgement_of_prod").setAttribute('disabled', true);
    document.getElementById("ng_rsir_judgement_of_prod").setAttribute('disabled', true);
    document.getElementById("na_rsir_judgement_of_prod").setAttribute('disabled', true);
  }

  document.getElementById('ok_rsir_judgement_of_prod').checked = false;
  document.getElementById('adj_rsir_judgement_of_prod').checked = false;
  document.getElementById('ng_rsir_judgement_of_prod').checked = false;
  document.getElementById('na_rsir_judgement_of_prod').checked = false;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'machine_checksheets_mark_as_read_prod',
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

const count_machine_checksheets_prod = () => {
  let car_model = sessionStorage.getItem('pending_car_model_search');
  let location = sessionStorage.getItem('pending_location_search');
  let machine_name = sessionStorage.getItem('pending_machine_name_search');
  let grid = sessionStorage.getItem('pending_grid_search');
  let rsir_no = sessionStorage.getItem('pending_rsir_no_search');
  let machine_no = sessionStorage.getItem('pending_machine_no_search');
  let equipment_no = sessionStorage.getItem('pending_equipment_no_search');

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_machine_checksheets_prod',
      car_model:car_model,
      location:location,
      machine_name:machine_name,
      grid:grid,
      rsir_no:rsir_no,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pendingPmRecordsData").childNodes.length);
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

const get_machine_checksheets_prod = () => {
  let car_model = document.getElementById("pending_car_model_search").value.trim();
  let location = document.getElementById("pending_location_search").value.trim();
  let machine_name = document.getElementById("pending_machine_name_search").value.trim();
  let grid = document.getElementById("pending_grid_search").value.trim();
  let rsir_no = document.getElementById("pending_rsir_no_search").value.trim();
  let machine_no = document.getElementById("pending_machine_no_search").value.trim();
  let equipment_no = document.getElementById("pending_equipment_no_search").value.trim();

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_machine_checksheets_prod',
      car_model:car_model,
      location:location,
      machine_name:machine_name,
      grid:grid,
      rsir_no:rsir_no,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pendingPmRecordsData").innerHTML = response;
      sessionStorage.setItem('pending_car_model_search', car_model);
      sessionStorage.setItem('pending_location_search', location);
      sessionStorage.setItem('pending_machine_name_search', machine_name);
      sessionStorage.setItem('pending_grid_search', grid);
      sessionStorage.setItem('pending_rsir_no_search', rsir_no);
      sessionStorage.setItem('pending_machine_no_search', machine_no);
      sessionStorage.setItem('pending_equipment_no_search', equipment_no);
      count_machine_checksheets_prod();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_machine_checksheets_prod);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

$("#MachineChecksheetDisapproveModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("u_disapproved_comment").getAttribute("maxlength");
    var comment_length = document.getElementById("u_disapproved_comment").value.length;
    var u_disapproved_comment_count = `${comment_length} / ${max_length}`;
    document.getElementById("u_disapproved_comment_count").innerHTML = u_disapproved_comment_count;
  }, 100);
});

const count_disapproved_comment_char = () => {
  var max_length = document.getElementById("u_disapproved_comment").getAttribute("maxlength");
  var comment_length = document.getElementById("u_disapproved_comment").value.length;
  var u_disapproved_comment_count = `${comment_length} / ${max_length}`;
  document.getElementById("u_disapproved_comment_count").innerHTML = u_disapproved_comment_count;
  if (comment_length > 0) {
    document.getElementById("btnDisapproveCMstprc").removeAttribute('disabled');
  } else {
    document.getElementById("btnDisapproveCMstprc").setAttribute('disabled', true);
  }
}

const download_pending_rsir = () => {
  var file_url = document.getElementById("pending_rsir_file_url").value;
  window.open(file_url,'_blank');
}

const approve_pending_rsir = () => {
  var rsir_no = document.getElementById("pending_rsir_no").innerHTML;
  var rsir_judgement_of_prod = document.getElementsByName('rsir_judgement_of_prod');
  var judgement_of_prod = '';
  for (i = 0; i < rsir_judgement_of_prod.length; i++) {
    if (rsir_judgement_of_prod[i].checked)
      judgement_of_prod = rsir_judgement_of_prod[i].value;
  }

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'approve_pending_rsir',
      rsir_no:rsir_no,
      judgement_of_prod:judgement_of_prod
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
          swal('Machine Checksheets', 'Approved Successfully', 'success');
          get_machine_checksheets_prod();
          document.getElementById('ok_rsir_judgement_of_prod').checked = false;
          document.getElementById('adj_rsir_judgement_of_prod').checked = false;
          document.getElementById('ng_rsir_judgement_of_prod').checked = false;
          document.getElementById('na_rsir_judgement_of_prod').checked = false;
          $('#PendingMachineChecksheetInfoModal').modal('hide');
        } else if (response == 'Judgement Of Product Empty') {
          swal('Machine Checksheets', 'Please set Judgement Of Product', 'info');
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

const disapprove_pending_rsir = () => {
  var rsir_no = document.getElementById("pending_rsir_no").innerHTML;
  var rsir_judgement_of_prod = document.getElementsByName('rsir_judgement_of_prod');
  var judgement_of_prod = '';
  for (i = 0; i < rsir_judgement_of_prod.length; i++) {
    if (rsir_judgement_of_prod[i].checked)
      judgement_of_prod = rsir_judgement_of_prod[i].value;
  }
  var disapproved_comment = document.getElementById("u_disapproved_comment").value;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'disapprove_pending_rsir',
      rsir_no:rsir_no,
      judgement_of_prod:judgement_of_prod,
      disapproved_comment:disapproved_comment
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
          swal('Machine Checksheets', 'Disapproved Successfully', 'success');
          get_machine_checksheets_prod();
          document.getElementById('ok_rsir_judgement_of_prod').checked = false;
          document.getElementById('adj_rsir_judgement_of_prod').checked = false;
          document.getElementById('ng_rsir_judgement_of_prod').checked = false;
          document.getElementById('na_rsir_judgement_of_prod').checked = false;
          $('#MachineChecksheetDisapproveModal').modal('hide');
          $('#PendingMachineChecksheetInfoModal').modal('hide');
        } else if (response == 'Judgement Of Product Empty') {
          swal('Machine Checksheets', 'Please set Judgement Of Product', 'info');
        } else if (response == 'Comment Empty') {
          swal('Machine Checksheets', 'Please fill out Disapprove Comment', 'info');
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
}

const count_pm_records_prod = () => {
  var history_date_from = sessionStorage.getItem('history_date_from');
  var history_date_to = sessionStorage.getItem('history_date_to');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var rsir_no = sessionStorage.getItem('history_rsir_no');
  var machine_no = sessionStorage.getItem('history_machine_no');
  var equipment_no = sessionStorage.getItem('history_equipment_no');
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pm_records_prod',
      rsir_date_from:history_date_from,
      rsir_date_to:history_date_to,
      machine_name:machine_name,
      rsir_no:rsir_no,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmRecordsData").childNodes.length);
      let loader_count2 = document.getElementById("loader_count2").value;
      let counter_view2 = "";
      if (total_rows != 0) {
        let counter_view_search2 = "";
        if (total_rows < 2) {
          counter_view_search2 = `${total_rows} record found`;
          counter_view2 = `${table_rows} row of ${total_rows} record`;
        } else {
          counter_view_search2 = `${total_rows} records found`;
          counter_view2 = `${table_rows} rows of ${total_rows} records`;
        }
        document.getElementById("counter_view_search2").innerHTML = counter_view_search2;
        document.getElementById("counter_view_search2").style.display = 'block';
        document.getElementById("counter_view2").innerHTML = counter_view2;
        document.getElementById("counter_view2").style.display = 'block';
      } else {
        document.getElementById("counter_view_search2").style.display = 'none';
        document.getElementById("counter_view2").style.display = 'none';
      }

      if (total_rows == 0) {
        document.getElementById("search_more_data2").style.display = 'none';
      } else if (total_rows > loader_count2) {
        document.getElementById("search_more_data2").style.display = 'block';
      } else if (total_rows <= loader_count2) {
        document.getElementById("search_more_data2").style.display = 'none';
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_pm_records_prod = option => {
  var id = 0;
  var history_date_from = '';
  var history_date_to = '';
  var machine_name = '';
  var rsir_no = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var history_date_from = document.getElementById("history_date_from").value;
      var history_date_to = document.getElementById("history_date_to").value;
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var rsir_no = document.getElementById("history_rsir_no").value.trim();
      var machine_no = document.getElementById("history_machine_no").value.trim();
      var equipment_no = document.getElementById("history_equipment_no").value.trim();
      if (history_date_from == '' || history_date_to == '') {
        var continue_loading = false;
        swal('Machine Checksheets', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("pmRecordsData").lastChild.getAttribute("id");
      var history_date_from = sessionStorage.getItem('history_date_from');
      var history_date_to = sessionStorage.getItem('history_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var rsir_no = sessionStorage.getItem('history_rsir_no');
      var machine_no = sessionStorage.getItem('history_machine_no');
      var equipment_no = sessionStorage.getItem('history_equipment_no');
      var loader_count2 = parseInt(document.getElementById("loader_count2").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/machine-checksheets_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_pm_records_prod',
        id:id,
        rsir_date_from:history_date_from,
        rsir_date_to:history_date_to,
        machine_name:machine_name,
        rsir_no:rsir_no,
        machine_no:machine_no,
        equipment_no:equipment_no,
        c:loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
            var loading = `<tr><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("pmRecordsData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("pmRecordsData").innerHTML = response;
            document.getElementById("loader_count2").value = 25;
            sessionStorage.setItem('history_date_from', history_date_from);
            sessionStorage.setItem('history_date_to', history_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_rsir_no', rsir_no);
            sessionStorage.setItem('history_machine_no', machine_no);
            sessionStorage.setItem('history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("pmRecordsData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count2").value = loader_count2 + 25;
            break;
          default:
        }
        count_pm_records_prod();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("history_date_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

document.getElementById("history_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

document.getElementById("history_rsir_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

document.getElementById("history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

document.getElementById("history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records_prod(1);
  }
});

const download_rsir_history = () => {
  var file_url = document.getElementById("history_rsir_file_url").value;
  window.open(file_url,'_blank');
}
