// Global Variables for Realtime Tables
var realtime_get_a1_machine_checksheets;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  get_car_models_datalist_search();

  get_a1_machine_checksheets();
  realtime_get_a1_machine_checksheets = setInterval(get_a1_machine_checksheets, 5000);
  load_notif_setup();
  realtime_load_notif_setup = setInterval(load_notif_setup, 5000);
});

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
      document.getElementById("history_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

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
      document.getElementById("history_car_models").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details_a1_machine_checksheets = el => {
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

  document.getElementById("a1_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("a1_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("a1_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("a1_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("a1_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("a1_mstprc_car_model").value = car_model;
  document.getElementById("a1_mstprc_location").value = location;
  document.getElementById("a1_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("a1_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("a1_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("a1_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("a1_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("a1_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("a1_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("a1_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("a1_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("a1_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("a1_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("a1_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("a1_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("a1_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("a1_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("a1_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("a1_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("a1_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("a1_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("a1_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("a1_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("a1_mstprc_qa_manager").value = mstprc_qa_manager;

  document.getElementById("a1_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("a1_mstprc_transfer_reason").innerHTML = transfer_reason;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("a1_mstprc_from_car_model").value = car_model;
    document.getElementById("a1_mstprc_from_location").value = location;
    document.getElementById("a1_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("a1_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("a1_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("a1_mstprc_to_car_model").value = to_car_model;
  document.getElementById("a1_mstprc_to_location").value = to_location;
  document.getElementById("a1_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("a1_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("a1_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("a1_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("a1_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("a1_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("a1_mstprc_file_name").innerHTML = file_name;
  document.getElementById("a1_mstprc_file_url").value = file_url;
}

const count_a1_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_a1_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("a1MachineChecksheetData").childNodes.length);
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

const get_a1_machine_checksheets = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_a1_machine_checksheets'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("a1MachineChecksheetData").innerHTML = response; 
      count_a1_machine_checksheets();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_a1_machine_checksheets);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const download_a1_mstprc = () => {
  var file_url = document.getElementById("a1_mstprc_file_url").value;
  window.open(file_url,'_blank');
}

const get_details_a1_machine_checksheets_history = el => {
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

  var disapproved_by = el.dataset.disapproved_by;
  var disapproved_by_role = el.dataset.disapproved_by_role;
  var disapproved_comment = el.dataset.disapproved_comment;

  document.getElementById("a1_history_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("a1_history_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("a1_history_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("a1_history_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("a1_history_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("a1_history_mstprc_car_model").value = car_model;
  document.getElementById("a1_history_mstprc_location").value = location;
  document.getElementById("a1_history_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("a1_history_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("a1_history_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("a1_history_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("a1_history_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("a1_history_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("a1_history_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("a1_history_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("a1_history_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("a1_history_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("a1_history_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("a1_history_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("a1_history_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("a1_history_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("a1_history_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("a1_history_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("a1_history_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("a1_history_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("a1_history_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("a1_history_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("a1_history_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("a1_history_mstprc_qa_manager").value = mstprc_qa_manager;

  document.getElementById("a1_history_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("a1_history_mstprc_transfer_reason").innerHTML = transfer_reason;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("a1_history_mstprc_from_car_model").value = car_model;
    document.getElementById("a1_history_mstprc_from_location").value = location;
    document.getElementById("a1_history_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("a1_history_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("a1_history_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("a1_history_mstprc_to_car_model").value = to_car_model;
  document.getElementById("a1_history_mstprc_to_location").value = to_location;
  document.getElementById("a1_history_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("a1_history_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("a1_history_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("a1_history_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("a1_history_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("a1_history_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("a1_history_mstprc_file_name").innerHTML = file_name;
  document.getElementById("a1_history_mstprc_file_url").value = file_url;

  document.getElementById("a1_history_mstprc_disapproved_by").innerHTML = disapproved_by;
  document.getElementById("a1_history_mstprc_disapproved_by_role").innerHTML = disapproved_by_role;
  document.getElementById("a1_history_mstprc_disapproved_comment").innerHTML = disapproved_comment;
}

const count_a1_machine_checksheets_history = () => {
  var mstprc_date_from = sessionStorage.getItem('history_mstprc_date_from');
  var mstprc_date_to = sessionStorage.getItem('history_mstprc_date_to');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var car_model = sessionStorage.getItem('history_car_model');
  var machine_no = sessionStorage.getItem('history_machine_no');
  var equipment_no = sessionStorage.getItem('history_equipment_no');
  var mstprc_no = sessionStorage.getItem('history_mstprc_no');
  var history_option = sessionStorage.getItem('history_option');

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_a1_machine_checksheets_history',
      mstprc_date_from:mstprc_date_from,
      mstprc_date_to:mstprc_date_to,
      machine_name:machine_name,
      car_model:car_model,
      machine_no:machine_no,
      equipment_no:equipment_no,
      mstprc_no:mstprc_no,
      history_option:history_option
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("a1MachineChecksheetHistoryData").childNodes.length);
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

const get_a1_machine_checksheets_history = option => {
  var id = 0;
  var mstprc_date_from = '';
  var mstprc_date_to = '';
  var machine_name = '';
  var car_model = '';
  var machine_no = '';
  var equipment_no = '';
  var mstprc_no = '';
  var history_option = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var mstprc_date_from = document.getElementById("history_mstprc_date_from").value;
      var mstprc_date_to = document.getElementById("history_mstprc_date_to").value;
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var car_model = document.getElementById("history_car_model").value.trim();
      var machine_no = document.getElementById("history_machine_no").value.trim();
      var equipment_no = document.getElementById("history_equipment_no").value.trim();
      var mstprc_no = document.getElementById("history_mstprc_no").value.trim();
      var history_option = document.getElementById("history_option").value;
      if (mstprc_date_from == '' || mstprc_date_to == '') {
        var continue_loading = false;
        swal('Approver 1', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("adminAccountData").lastChild.getAttribute("id");
      var mstprc_date_from = sessionStorage.getItem('history_mstprc_date_from');
      var mstprc_date_to = sessionStorage.getItem('history_mstprc_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var car_model = sessionStorage.getItem('history_car_model');
      var machine_no = sessionStorage.getItem('history_machine_no');
      var equipment_no = sessionStorage.getItem('history_equipment_no');
      var mstprc_no = sessionStorage.getItem('history_mstprc_no');
      var history_option = sessionStorage.getItem('history_option');
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
        method: 'get_a1_machine_checksheets_history',
        id: id,
        mstprc_date_from: mstprc_date_from,
        mstprc_date_to: mstprc_date_to,
        machine_name: machine_name,
        car_model: car_model,
        machine_no: machine_no,
        equipment_no: equipment_no,
        mstprc_no: mstprc_no,
        history_option: history_option,
        c: loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
            var loading = `<tr><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("a1MachineChecksheetHistoryData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("a1MachineChecksheetHistoryData").innerHTML = response;
            document.getElementById("loader_count2").value = 25;
            sessionStorage.setItem('history_mstprc_date_from', mstprc_date_from);
            sessionStorage.setItem('history_mstprc_date_to', mstprc_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_car_model', car_model);
            sessionStorage.setItem('history_machine_no', machine_no);
            sessionStorage.setItem('history_equipment_no', equipment_no);
            sessionStorage.setItem('history_mstprc_no', mstprc_no);
            sessionStorage.setItem('history_option', history_option);
            break;
          case 2:
            document.getElementById("a1MachineChecksheetHistoryData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count2").value = loader_count2 + 25;
            break;
          default:
        }
        count_a1_machine_checksheets_history();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("history_mstprc_date_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_mstprc_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_mstprc_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

document.getElementById("history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_a1_machine_checksheets_history(1);
  }
});

const download_a1_mstprc_history = () => {
  var file_url = document.getElementById("a1_history_mstprc_file_url").value;
  window.open(file_url,'_blank');
}
