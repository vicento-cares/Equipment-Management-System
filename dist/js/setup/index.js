// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_setup_activities_day();

  get_recent_machine_checksheets();
  load_notif_public_act_sched();
  realtime_load_notif_public_act_sched = setInterval(load_notif_public_act_sched, 5000);
});

const get_setup_activities_day = () => {
  $.ajax({
    url: 'process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_setup_activities_day'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        var date_time_now = new Date(response_array.activity_date).toDateString();
        document.getElementById("setup_activity_date_now").innerHTML = date_time_now;
        document.getElementById("setup_activity_date_now_hidden").value = response_array.activity_date;
        document.getElementById("setupActivityData").innerHTML = response_array.data;
      } catch(e) {
        console.log(response);
        swal('Setup Activity Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_previous_setup_activities = () => {
  var activity_date = document.getElementById("setup_activity_date_now_hidden").value;
  $.ajax({
    url: 'process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_previous_setup_activities',
      activity_date: activity_date
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        var date_time_now = new Date(response_array.activity_date).toDateString();
        document.getElementById("setup_activity_date_now").innerHTML = date_time_now;
        document.getElementById("setup_activity_date_now_hidden").value = response_array.activity_date;
        document.getElementById("setupActivityData").innerHTML = response_array.data;
      } catch(e) {
        console.log(response);
        swal('Setup Activity Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_next_setup_activities = () => {
  var activity_date = document.getElementById("setup_activity_date_now_hidden").value;
  $.ajax({
    url: 'process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_next_setup_activities',
      activity_date: activity_date
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        var date_time_now = new Date(response_array.activity_date).toDateString();
        document.getElementById("setup_activity_date_now").innerHTML = date_time_now;
        document.getElementById("setup_activity_date_now_hidden").value = response_array.activity_date;
        document.getElementById("setupActivityData").innerHTML = response_array.data;
      } catch(e) {
        console.log(response);
        swal('Setup Activity Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details_machine_checksheets = el => {
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

  document.getElementById("recent_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("recent_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("recent_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("recent_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("recent_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("recent_mstprc_car_model").value = car_model;
  document.getElementById("recent_mstprc_location").value = location;
  document.getElementById("recent_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("recent_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("recent_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("recent_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("recent_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("recent_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("recent_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("recent_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("recent_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("recent_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("recent_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("recent_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("recent_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("recent_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("recent_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("recent_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("recent_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("recent_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("recent_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("recent_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("recent_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("recent_mstprc_qa_manager").value = mstprc_qa_manager;

  document.getElementById("recent_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("recent_mstprc_transfer_reason").innerHTML = transfer_reason;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("recent_mstprc_from_car_model").value = car_model;
    document.getElementById("recent_mstprc_from_location").value = location;
    document.getElementById("recent_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("recent_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("recent_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("recent_mstprc_to_car_model").value = to_car_model;
  document.getElementById("recent_mstprc_to_location").value = to_location;
  document.getElementById("recent_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("recent_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("recent_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("recent_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("recent_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("recent_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("recent_mstprc_file_name").innerHTML = file_name;
  document.getElementById("recent_mstprc_file_url").value = file_url;
}

const get_recent_machine_checksheets = () => {
  var i_search = document.getElementById("i_search").value.trim();
  $.ajax({
    url: 'process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_recent_machine_checksheets',
      search: i_search
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("machineChecksheetData").innerHTML = response; 
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

const download_mstprc = () => {
  var file_url = document.getElementById("recent_mstprc_file_url").value;
  window.open(file_url,'_blank');
}
