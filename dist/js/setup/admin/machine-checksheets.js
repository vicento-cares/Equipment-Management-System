// Global Variables for Realtime Tables
var realtime_get_pending_machine_checksheets;
var realtime_get_recent_machine_checksheets_history;
var realtime_get_returned_machine_checksheets;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('setup_role') != 'Admin') {
    document.getElementById("btnReturnPendingRsir").setAttribute('disabled', true);
    document.getElementById("btnReturnPendingRsir").style.display = 'none';
    document.getElementById("btnConfirmPendingMstprc").setAttribute('disabled', true);
    document.getElementById("btnConfirmPendingMstprc").style.display = 'none';
  }
  get_machines_dropdown();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  get_car_models_datalist_search();
  get_locations_dropdown();
  load_machine_docs(1);

  get_pending_machine_checksheets();
  realtime_get_pending_machine_checksheets = setInterval(get_pending_machine_checksheets, 5000);
  get_recent_machine_checksheets_history();
  realtime_get_recent_machine_checksheets_history = setInterval(get_recent_machine_checksheets_history, 7500);
  get_returned_machine_checksheets();
  realtime_get_returned_machine_checksheets = setInterval(get_returned_machine_checksheets, 7500);
  load_notif_setup_mstprc_page();
  realtime_load_notif_setup_mstprc_page = setInterval(load_notif_setup_mstprc_page, 7500);
  update_notif_approved_mstprc();
  update_notif_disapproved_mstprc();
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
      document.getElementById("mstprc_setup_machines_no").innerHTML = response;
      document.getElementById("mstprc_transfer_machines_no").innerHTML = response;
      document.getElementById("mstprc_pullout_machines_no").innerHTML = response;
      document.getElementById("mstprc_relayout_machines_no").innerHTML = response;
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
      document.getElementById("mstprc_setup_equipments_no").innerHTML = response;
      document.getElementById("mstprc_transfer_equipments_no").innerHTML = response;
      document.getElementById("mstprc_pullout_equipments_no").innerHTML = response;
      document.getElementById("mstprc_relayout_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_car_models_datalist = (action, setup_process) => {
  $.ajax({
    url: '../process/admin/car-models_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_car_model_datalist',
      process: setup_process
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (action == 'transfer') {
        document.getElementById("mstprc_transfer_to_car_models").innerHTML = response;
      }
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
      document.getElementById("mstprc_setup_new_groups").innerHTML = response;
      document.getElementById("mstprc_transfer_new_groups").innerHTML = response;
      document.getElementById("mstprc_pullout_new_groups").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_locations_dropdown = () => {
  $.ajax({
    url: '../process/admin/locations_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_location_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("mstprc_transfer_to_location").innerHTML = response;
      document.getElementById("mstprc_setup_new_location").innerHTML = response;
      document.getElementById("mstprc_transfer_new_location").innerHTML = response;
      document.getElementById("mstprc_pullout_new_location").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

document.getElementById("mstprc_setup_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('setup');
  } else {
    document.getElementById("mstprc_setup_equipment_no").value = '';
    document.getElementById("mstprc_setup_car_model").value = '';
    document.getElementById("mstprc_setup_location").value = '';
    document.getElementById("mstprc_setup_grid").value = '';
    document.getElementById("mstprc_setup_machine_name").value = '';
    document.getElementById("mstprc_setup_process").value = '';
    document.getElementById("mstprc_setup_is_new").value = '';
    document.getElementById("mstprc_setup_is_new").checked = false;
    document.getElementById("mstprc_setup_asset_tag_no").value = '';
    document.getElementById("mstprc_setup_trd_no").value = '';
    document.getElementById("mstprc_setup_ns-iv_no").value = '';
  }
});

document.getElementById("mstprc_setup_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('setup');
  } else {
    document.getElementById("mstprc_setup_machine_no").value = '';
    document.getElementById("mstprc_setup_car_model").value = '';
    document.getElementById("mstprc_setup_location").value = '';
    document.getElementById("mstprc_setup_grid").value = '';
    document.getElementById("mstprc_setup_machine_name").value = '';
    document.getElementById("mstprc_setup_process").value = '';
    document.getElementById("mstprc_setup_is_new").value = '';
    document.getElementById("mstprc_setup_is_new").checked = false;
    document.getElementById("mstprc_setup_asset_tag_no").value = '';
    document.getElementById("mstprc_setup_trd_no").value = '';
    document.getElementById("mstprc_setup_ns-iv_no").value = '';
  }
});

document.getElementById("mstprc_transfer_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('transfer');
  } else {
    document.getElementById("mstprc_transfer_equipment_no").value = '';
    document.getElementById("mstprc_transfer_car_model").value = '';
    document.getElementById("mstprc_transfer_location").value = '';
    document.getElementById("mstprc_transfer_grid").value = '';
    document.getElementById("mstprc_transfer_machine_name").value = '';
    document.getElementById("mstprc_transfer_process").value = '';
    document.getElementById("mstprc_transfer_asset_tag_no").value = '';
    document.getElementById("mstprc_transfer_trd_no").value = '';
    document.getElementById("mstprc_transfer_ns-iv_no").value = '';
    document.getElementById("mstprc_transfer_from_car_model").value = '';
    document.getElementById("mstprc_transfer_from_location").value = '';
    document.getElementById("mstprc_transfer_from_grid").value = '';
  }
});

document.getElementById("mstprc_transfer_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('transfer');
  } else {
    document.getElementById("mstprc_transfer_machine_no").value = '';
    document.getElementById("mstprc_transfer_car_model").value = '';
    document.getElementById("mstprc_transfer_location").value = '';
    document.getElementById("mstprc_transfer_grid").value = '';
    document.getElementById("mstprc_transfer_machine_name").value = '';
    document.getElementById("mstprc_transfer_process").value = '';
    document.getElementById("mstprc_transfer_asset_tag_no").value = '';
    document.getElementById("mstprc_transfer_trd_no").value = '';
    document.getElementById("mstprc_transfer_ns-iv_no").value = '';
    document.getElementById("mstprc_transfer_from_car_model").value = '';
    document.getElementById("mstprc_transfer_from_location").value = '';
    document.getElementById("mstprc_transfer_from_grid").value = '';
  }
});

document.getElementById("mstprc_pullout_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('pullout');
  } else {
    document.getElementById("mstprc_pullout_equipment_no").value = '';
    document.getElementById("mstprc_pullout_car_model").value = '';
    document.getElementById("mstprc_pullout_location").value = '';
    document.getElementById("mstprc_pullout_grid").value = '';
    document.getElementById("mstprc_pullout_machine_name").value = '';
    document.getElementById("mstprc_pullout_process").value = '';
    document.getElementById("mstprc_pullout_asset_tag_no").value = '';
    document.getElementById("mstprc_pullout_trd_no").value = '';
    document.getElementById("mstprc_pullout_ns-iv_no").value = '';
  }
});

document.getElementById("mstprc_pullout_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('pullout');
  } else {
    document.getElementById("mstprc_pullout_machine_no").value = '';
    document.getElementById("mstprc_pullout_car_model").value = '';
    document.getElementById("mstprc_pullout_location").value = '';
    document.getElementById("mstprc_pullout_grid").value = '';
    document.getElementById("mstprc_pullout_machine_name").value = '';
    document.getElementById("mstprc_pullout_process").value = '';
    document.getElementById("mstprc_pullout_asset_tag_no").value = '';
    document.getElementById("mstprc_pullout_trd_no").value = '';
    document.getElementById("mstprc_pullout_ns-iv_no").value = '';
  }
});

document.getElementById("mstprc_relayout_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('relayout');
  } else {
    document.getElementById("mstprc_relayout_equipment_no").value = '';
    document.getElementById("mstprc_relayout_car_model").value = '';
    document.getElementById("mstprc_relayout_location").value = '';
    document.getElementById("mstprc_relayout_grid").value = '';
    document.getElementById("mstprc_relayout_machine_name").value = '';
    document.getElementById("mstprc_relayout_process").value = '';
    document.getElementById("mstprc_relayout_asset_tag_no").value = '';
    document.getElementById("mstprc_relayout_trd_no").value = '';
    document.getElementById("mstprc_relayout_ns-iv_no").value = '';
  }
});

document.getElementById("mstprc_relayout_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('relayout');
  } else {
    document.getElementById("mstprc_relayout_machine_no").value = '';
    document.getElementById("mstprc_relayout_car_model").value = '';
    document.getElementById("mstprc_relayout_location").value = '';
    document.getElementById("mstprc_relayout_grid").value = '';
    document.getElementById("mstprc_relayout_machine_name").value = '';
    document.getElementById("mstprc_relayout_process").value = '';
    document.getElementById("mstprc_relayout_asset_tag_no").value = '';
    document.getElementById("mstprc_relayout_trd_no").value = '';
    document.getElementById("mstprc_relayout_ns-iv_no").value = '';
  }
});

const clear_mstprc_setup_step1_fields = () => {
  document.getElementById("mstprc_setup_machine_no").value = '';
  document.getElementById("mstprc_setup_equipment_no").value = '';
  document.getElementById("mstprc_setup_car_model").value = '';
  document.getElementById("mstprc_setup_location").value = '';
  document.getElementById("mstprc_setup_grid").value = '';
  document.getElementById("mstprc_setup_machine_name").value = '';
  document.getElementById("mstprc_setup_process").value = '';
  document.getElementById("mstprc_setup_is_new").value = '';
  document.getElementById("mstprc_setup_is_new").checked = false;
  document.getElementById("mstprc_setup_asset_tag_no").value = '';
  document.getElementById("mstprc_setup_trd_no").value = '';
  document.getElementById("mstprc_setup_ns-iv_no").value = '';
  document.getElementById("mstprc_setup_date").value = '';
}

const clear_mstprc_transfer_step1_fields = () => {
  document.getElementById("mstprc_transfer_machine_no").value = '';
  document.getElementById("mstprc_transfer_equipment_no").value = '';
  document.getElementById("mstprc_transfer_car_model").value = '';
  document.getElementById("mstprc_transfer_location").value = '';
  document.getElementById("mstprc_transfer_grid").value = '';
  document.getElementById("mstprc_transfer_machine_name").value = '';
  document.getElementById("mstprc_transfer_process").value = '';
  document.getElementById("mstprc_transfer_asset_tag_no").value = '';
  document.getElementById("mstprc_transfer_trd_no").value = '';
  document.getElementById("mstprc_transfer_ns-iv_no").value = '';
  document.getElementById("mstprc_transfer_from_car_model").value = '';
  document.getElementById("mstprc_transfer_from_location").value = '';
  document.getElementById("mstprc_transfer_from_grid").value = '';
  document.getElementById("mstprc_transfer_to_car_model").value = '';
  document.getElementById("mstprc_transfer_to_location").value = '';
  document.getElementById("mstprc_transfer_to_grid").value = '';
  document.getElementById("mstprc_transfer_date").value = '';
  document.getElementById("mstprc_transfer_reason").value = '';
}

const clear_mstprc_pullout_step1_fields = () => {
  document.getElementById("mstprc_pullout_machine_no").value = '';
  document.getElementById("mstprc_pullout_equipment_no").value = '';
  document.getElementById("mstprc_pullout_car_model").value = '';
  document.getElementById("mstprc_pullout_location").value = '';
  document.getElementById("mstprc_pullout_grid").value = '';
  document.getElementById("mstprc_pullout_machine_name").value = '';
  document.getElementById("mstprc_pullout_process").value = '';
  document.getElementById("mstprc_pullout_asset_tag_no").value = '';
  document.getElementById("mstprc_pullout_trd_no").value = '';
  document.getElementById("mstprc_pullout_ns-iv_no").value = '';
  document.getElementById("mstprc_pullout_date").value = '';
  document.getElementById("mstprc_pullout_reason").value = '';
  document.getElementById("mstprc_pullout_machine_location").value = '';
}

const clear_mstprc_relayout_step1_fields = () => {
  document.getElementById("mstprc_relayout_machine_no").value = '';
  document.getElementById("mstprc_relayout_equipment_no").value = '';
  document.getElementById("mstprc_relayout_car_model").value = '';
  document.getElementById("mstprc_relayout_location").value = '';
  document.getElementById("mstprc_relayout_grid").value = '';
  document.getElementById("mstprc_relayout_machine_name").value = '';
  document.getElementById("mstprc_relayout_process").value = '';
  document.getElementById("mstprc_relayout_asset_tag_no").value = '';
  document.getElementById("mstprc_relayout_trd_no").value = '';
  document.getElementById("mstprc_relayout_ns-iv_no").value = '';
  document.getElementById("mstprc_relayout_date").value = '';
}

const get_machine_details_by_id = action => {
  var machine_no = '';
  var equipment_no = '';
  if (action == 'setup') {
    var machine_no = document.getElementById("mstprc_setup_machine_no").value.trim();
    var equipment_no = document.getElementById("mstprc_setup_equipment_no").value.trim();
  } else if (action == 'transfer') {
    var machine_no = document.getElementById("mstprc_transfer_machine_no").value.trim();
    var equipment_no = document.getElementById("mstprc_transfer_equipment_no").value.trim();
  } else if (action == 'pullout') {
    var machine_no = document.getElementById("mstprc_pullout_machine_no").value.trim();
    var equipment_no = document.getElementById("mstprc_pullout_equipment_no").value.trim();
  } else if (action == 'relayout') {
    var machine_no = document.getElementById("mstprc_relayout_machine_no").value.trim();
    var equipment_no = document.getElementById("mstprc_relayout_equipment_no").value.trim();
  }

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
          var setup_process = response_array.process;
          var machine_name = response_array.machine_name;
          var car_model = response_array.car_model;
          var location = response_array.location;
          var grid = response_array.grid;
          var machine_no = response_array.machine_no;
          var equipment_no = response_array.equipment_no;
          var trd_no = response_array.trd_no;
          var ns_iv_no = response_array.ns_iv_no;
          var asset_tag_no = response_array.asset_tag_no;
          var is_new = response_array.is_new;
          var registered = response_array.registered;

          if (registered == true) {
            if (action == 'setup') {
              document.getElementById("mstprc_setup_machine_no").value = machine_no;
              document.getElementById("mstprc_setup_equipment_no").value = equipment_no;
              document.getElementById("mstprc_setup_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_setup_trd_no").value = trd_no;
              document.getElementById("mstprc_setup_ns-iv_no").value = ns_iv_no;
              document.getElementById("mstprc_setup_machine_name").value = machine_name;
              document.getElementById("mstprc_setup_process").value = setup_process;
              document.getElementById("mstprc_setup_car_model").value = car_model;
              document.getElementById("mstprc_setup_location").value = location;
              document.getElementById("mstprc_setup_grid").value = grid;
              document.getElementById("mstprc_setup_is_new").value = is_new;
              if (is_new == 0) {
                document.getElementById("mstprc_setup_is_new").checked = false;
              } else if (is_new == 1) {
                document.getElementById("mstprc_setup_is_new").checked = true;
              }
            } else if (action == 'transfer') {
              get_car_models_datalist(action, setup_process);
              document.getElementById("mstprc_transfer_to_car_model").removeAttribute('disabled');
              document.getElementById("mstprc_transfer_machine_no").value = machine_no;
              document.getElementById("mstprc_transfer_equipment_no").value = equipment_no;
              document.getElementById("mstprc_transfer_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_transfer_trd_no").value = trd_no;
              document.getElementById("mstprc_transfer_ns-iv_no").value = ns_iv_no;
              document.getElementById("mstprc_transfer_machine_name").value = machine_name;
              document.getElementById("mstprc_transfer_process").value = setup_process;
              document.getElementById("mstprc_transfer_car_model").value = car_model;
              document.getElementById("mstprc_transfer_location").value = location;
              document.getElementById("mstprc_transfer_grid").value = grid;
              document.getElementById("mstprc_transfer_from_car_model").value = car_model;
              document.getElementById("mstprc_transfer_from_location").value = location;
              document.getElementById("mstprc_transfer_from_grid").value = grid;
            } else if (action == 'pullout') {
              document.getElementById("mstprc_pullout_machine_no").value = machine_no;
              document.getElementById("mstprc_pullout_equipment_no").value = equipment_no;
              document.getElementById("mstprc_pullout_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_pullout_trd_no").value = trd_no;
              document.getElementById("mstprc_pullout_ns-iv_no").value = ns_iv_no;
              document.getElementById("mstprc_pullout_machine_name").value = machine_name;
              document.getElementById("mstprc_pullout_process").value = setup_process;
              document.getElementById("mstprc_pullout_car_model").value = car_model;
              document.getElementById("mstprc_pullout_location").value = location;
              document.getElementById("mstprc_pullout_grid").value = grid;
            } else if (action == 'relayout') {
              document.getElementById("mstprc_relayout_machine_no").value = machine_no;
              document.getElementById("mstprc_relayout_equipment_no").value = equipment_no;
              document.getElementById("mstprc_relayout_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_relayout_trd_no").value = trd_no;
              document.getElementById("mstprc_relayout_ns-iv_no").value = ns_iv_no;
              document.getElementById("mstprc_relayout_machine_name").value = machine_name;
              document.getElementById("mstprc_relayout_process").value = setup_process;
              document.getElementById("mstprc_relayout_car_model").value = car_model;
              document.getElementById("mstprc_relayout_location").value = location;
              document.getElementById("mstprc_relayout_grid").value = grid;
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

const goto_mstprc_setup_step2 = () => {
  var machine_no = document.getElementById("mstprc_setup_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_setup_equipment_no").value.trim();
  var car_model = document.getElementById("mstprc_setup_car_model").value;
  var location = document.getElementById("mstprc_setup_location").value;
  var grid = document.getElementById("mstprc_setup_grid").value;
  var machine_name = document.getElementById("mstprc_setup_machine_name").value;
  var asset_tag_no = document.getElementById("mstprc_setup_asset_tag_no").value;
  var trd_no = document.getElementById("mstprc_setup_trd_no").value;
  var ns_iv_no = document.getElementById("mstprc_setup_ns-iv_no").value;
  var mstprc_date = document.getElementById("mstprc_setup_date").value;
  var is_new = document.getElementById("mstprc_setup_is_new").value;
  var mstprc_no = document.getElementById("mstprc_setup_no").value;
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'goto_mstprc_setup_step2',
      machine_no:machine_no,
      equipment_no:equipment_no,
      car_model:car_model,
      location:location,
      grid:grid,
      machine_name:machine_name,
      asset_tag_no:asset_tag_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      mstprc_date:mstprc_date,
      is_new:is_new,
      mstprc_no:mstprc_no
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
            document.getElementById("mstprc_setup_no").value = response_array.mstprc_no;
            document.getElementById("mstprc_setup_no2").innerHTML = response_array.mstprc_no;
            document.getElementById("mstprc_setup_date2").innerHTML = mstprc_date;
            document.getElementById("mstprc_setup_machine_no2").innerHTML = machine_no;
            document.getElementById("mstprc_setup_equipment_no2").innerHTML = equipment_no;
            document.getElementById("mstprc_setup_car_model2").innerHTML = car_model;
            document.getElementById("mstprc_setup_machine_name2").innerHTML = machine_name;
            $('#MstprcSetupStep1Modal').modal('hide');
            setTimeout(() => {
              $('#MstprcSetupStep2Modal').modal('show');
            }, 400);
          } else if (response_array.message == 'Machine Indentification Empty') {
            swal('Machine Checksheets', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Forgotten Enter Key') {
            swal('Machine Checksheets', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Unregistered Machine') {
            swal('Machine Checksheets Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
          } else if (response_array.message == 'Date Not Set') {
            swal('Machine Checksheets', 'Please set Setup Date', 'info');
          } else if (response_array.message == 'Not For Setup') {
            swal('Machine Checksheets Error', 'Only Unused or New Machines are allowed for Setup', 'error');
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

const goto_mstprc_transfer_step2 = () => {
  var machine_no = document.getElementById("mstprc_transfer_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_transfer_equipment_no").value.trim();
  var car_model = document.getElementById("mstprc_transfer_car_model").value;
  var location = document.getElementById("mstprc_transfer_location").value;
  var grid = document.getElementById("mstprc_transfer_grid").value;
  var machine_name = document.getElementById("mstprc_transfer_machine_name").value;
  var asset_tag_no = document.getElementById("mstprc_transfer_asset_tag_no").value;
  var trd_no = document.getElementById("mstprc_transfer_trd_no").value;
  var ns_iv_no = document.getElementById("mstprc_transfer_ns-iv_no").value;
  var mstprc_date = document.getElementById("mstprc_transfer_date").value;
  var mstprc_no = document.getElementById("mstprc_transfer_no").value;
  var to_car_model = document.getElementById("mstprc_transfer_to_car_model").value.trim();
  var to_location = document.getElementById("mstprc_transfer_to_location").value;
  var to_grid = document.getElementById("mstprc_transfer_to_grid").value.trim();
  var transfer_reason = document.getElementById("mstprc_transfer_reason").value.trim();

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'goto_mstprc_transfer_step2',
      machine_no:machine_no,
      equipment_no:equipment_no,
      car_model:car_model,
      location:location,
      grid:grid,
      machine_name:machine_name,
      asset_tag_no:asset_tag_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      mstprc_date:mstprc_date,
      mstprc_no:mstprc_no,
      to_car_model:to_car_model,
      to_location:to_location,
      to_grid:to_grid,
      transfer_reason:transfer_reason
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
            document.getElementById("mstprc_transfer_no").value = response_array.mstprc_no;
            document.getElementById("mstprc_transfer_no2").innerHTML = response_array.mstprc_no;
            document.getElementById("mstprc_transfer_date2").innerHTML = mstprc_date;
            document.getElementById("mstprc_transfer_machine_no2").innerHTML = machine_no;
            document.getElementById("mstprc_transfer_equipment_no2").innerHTML = equipment_no;
            document.getElementById("mstprc_transfer_car_model2").innerHTML = car_model;
            document.getElementById("mstprc_transfer_machine_name2").innerHTML = machine_name;
            $('#MstprcTransferStep1Modal').modal('hide');
            setTimeout(() => {
              $('#MstprcTransferStep2Modal').modal('show');
            }, 400);
          } else if (response_array.message == 'Machine Indentification Empty') {
            swal('Machine Checksheets', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Forgotten Enter Key') {
            swal('Machine Checksheets', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Unregistered Machine') {
            swal('Machine Checksheets Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
          } else if (response_array.message == 'Date Not Set') {
            swal('Machine Checksheets', 'Please set Transfer Date', 'info');
          } else if (response_array.message == 'To Car Model Empty') {
            swal('Machine Checksheets', 'Please fill out To Car Model', 'info');
          } else if (response_array.message == 'To Location Not Set') {
            swal('Machine Checksheets', 'Please set To Location', 'info');
          } else if (response_array.message == 'Not For Transfer') {
            swal('Machine Checksheets Error', 'Only Currently Working Machines on Production are allowed for Transfer', 'error');
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

const goto_mstprc_pullout_step2 = () => {
  var machine_no = document.getElementById("mstprc_pullout_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_pullout_equipment_no").value.trim();
  var car_model = document.getElementById("mstprc_pullout_car_model").value;
  var location = document.getElementById("mstprc_pullout_location").value;
  var grid = document.getElementById("mstprc_pullout_grid").value;
  var machine_name = document.getElementById("mstprc_pullout_machine_name").value;
  var asset_tag_no = document.getElementById("mstprc_pullout_asset_tag_no").value;
  var trd_no = document.getElementById("mstprc_pullout_trd_no").value;
  var ns_iv_no = document.getElementById("mstprc_pullout_ns-iv_no").value;
  var mstprc_date = document.getElementById("mstprc_pullout_date").value;
  var mstprc_no = document.getElementById("mstprc_pullout_no").value;
  var pullout_reason = document.getElementById("mstprc_pullout_reason").value.trim();
  var pullout_location = document.getElementById("mstprc_pullout_machine_location").value.trim();
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'goto_mstprc_pullout_step2',
      machine_no:machine_no,
      equipment_no:equipment_no,
      car_model:car_model,
      location:location,
      grid:grid,
      machine_name:machine_name,
      asset_tag_no:asset_tag_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      mstprc_date:mstprc_date,
      mstprc_no:mstprc_no,
      pullout_reason:pullout_reason,
      pullout_location:pullout_location
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
            document.getElementById("mstprc_pullout_no").value = response_array.mstprc_no;
            document.getElementById("mstprc_pullout_no2").innerHTML = response_array.mstprc_no;
            document.getElementById("mstprc_pullout_date2").innerHTML = mstprc_date;
            document.getElementById("mstprc_pullout_machine_no2").innerHTML = machine_no;
            document.getElementById("mstprc_pullout_equipment_no2").innerHTML = equipment_no;
            document.getElementById("mstprc_pullout_car_model2").innerHTML = car_model;
            document.getElementById("mstprc_pullout_machine_name2").innerHTML = machine_name;
            $('#MstprcPulloutStep1Modal').modal('hide');
            setTimeout(() => {
              $('#MstprcPulloutStep2Modal').modal('show');
            }, 400);
          } else if (response_array.message == 'Machine Indentification Empty') {
            swal('Machine Checksheets', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Forgotten Enter Key') {
            swal('Machine Checksheets', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Unregistered Machine') {
            swal('Machine Checksheets Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
          } else if (response_array.message == 'Date Not Set') {
            swal('Machine Checksheets', 'Please set Pullout Date', 'info');
          } else if (response_array.message == 'Pullout Location Empty') {
            swal('Machine Checksheets', 'Please fill out Machine Location', 'info');
          } else if (response_array.message == 'Pullout Reason Empty') {
            swal('Machine Checksheets', 'Please fill out Pullout Reason', 'info');
          } else if (response_array.message == 'Not For Pullout') {
            swal('Machine Checksheets Error', 'Only Currently Working Machines on Production are allowed for Pullout', 'error');
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

const goto_mstprc_relayout_step2 = () => {
  var machine_no = document.getElementById("mstprc_relayout_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_relayout_equipment_no").value.trim();
  var car_model = document.getElementById("mstprc_relayout_car_model").value;
  var location = document.getElementById("mstprc_relayout_location").value;
  var grid = document.getElementById("mstprc_relayout_grid").value;
  var machine_name = document.getElementById("mstprc_relayout_machine_name").value;
  var asset_tag_no = document.getElementById("mstprc_relayout_asset_tag_no").value;
  var trd_no = document.getElementById("mstprc_relayout_trd_no").value;
  var ns_iv_no = document.getElementById("mstprc_relayout_ns-iv_no").value;
  var mstprc_date = document.getElementById("mstprc_relayout_date").value;
  var mstprc_no = document.getElementById("mstprc_relayout_no").value;
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'goto_mstprc_relayout_step2',
      machine_no:machine_no,
      equipment_no:equipment_no,
      car_model:car_model,
      location:location,
      grid:grid,
      machine_name:machine_name,
      asset_tag_no:asset_tag_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      mstprc_date:mstprc_date,
      mstprc_no:mstprc_no
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
            document.getElementById("mstprc_relayout_no").value = response_array.mstprc_no;
            document.getElementById("mstprc_relayout_no2").innerHTML = response_array.mstprc_no;
            document.getElementById("mstprc_relayout_date2").innerHTML = mstprc_date;
            document.getElementById("mstprc_relayout_machine_no2").innerHTML = machine_no;
            document.getElementById("mstprc_relayout_equipment_no2").innerHTML = equipment_no;
            document.getElementById("mstprc_relayout_car_model2").innerHTML = car_model;
            document.getElementById("mstprc_relayout_machine_name2").innerHTML = machine_name;
            $('#MstprcRelayoutStep1Modal').modal('hide');
            setTimeout(() => {
              $('#MstprcRelayoutStep2Modal').modal('show');
            }, 400);
          } else if (response_array.message == 'Machine Indentification Empty') {
            swal('Machine Checksheets', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Forgotten Enter Key') {
            swal('Machine Checksheets', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
          } else if (response_array.message == 'Unregistered Machine') {
            swal('Machine Checksheets Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
          } else if (response_array.message == 'Date Not Set') {
            swal('Machine Checksheets', 'Please set Re-layout Date', 'info');
          } else if (response_array.message == 'Not For Relayout') {
            swal('Machine Checksheets Error', 'Only Currently Working Machines on Production are allowed for Relayout', 'error');
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

const clear_mstprc_setup_step2_fields = () => {
  document.getElementById("mstprc_setup_file").value = '';
}
const clear_mstprc_transfer_step2_fields = () => {
  document.getElementById("mstprc_transfer_file").value = '';
}
const clear_mstprc_pullout_step2_fields = () => {
  document.getElementById("mstprc_pullout_file").value = '';
}
const clear_mstprc_relayout_step2_fields = () => {
  document.getElementById("mstprc_relayout_file").value = '';
}

const download_mstprc_setup_format = () => {
  var machine_name = document.getElementById("mstprc_setup_machine_name2").innerHTML;
  $.ajax({
    url: '../process/admin/setup-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'download_mstprc_format',
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        var mstprc_file_url = response;
        window.open(mstprc_file_url,'_blank');
      } else {
        swal('Machine Checksheet Error', 'No MSTPRC Format found for this machine', 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
const download_mstprc_transfer_format = () => {
  var machine_name = document.getElementById("mstprc_transfer_machine_name2").innerHTML;
  $.ajax({
    url: '../process/admin/setup-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'download_mstprc_format',
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        var mstprc_file_url = response;
        window.open(mstprc_file_url,'_blank');
      } else {
        swal('Machine Checksheet Error', 'No MSTPRC Format found for this machine', 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
const download_mstprc_pullout_format = () => {
  var machine_name = document.getElementById("mstprc_pullout_machine_name2").innerHTML;
  $.ajax({
    url: '../process/admin/setup-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'download_mstprc_format',
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        var mstprc_file_url = response;
        window.open(mstprc_file_url,'_blank');
      } else {
        swal('Machine Checksheet Error', 'No MSTPRC Format found for this machine', 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
const download_mstprc_relayout_format = () => {
  var machine_name = document.getElementById("mstprc_relayout_machine_name2").innerHTML;
  $.ajax({
    url: '../process/admin/setup-machine-docs_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'download_mstprc_format',
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        var mstprc_file_url = response;
        window.open(mstprc_file_url,'_blank');
      } else {
        swal('Machine Checksheet Error', 'No MSTPRC Format found for this machine', 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const clear_mstprc_setup_sou_fields = () => {
  document.getElementById("mstprc_setup_kigyo_no").value = '';
  document.getElementById("mstprc_setup_orig_asset_no").value = '';
  document.getElementById("mstprc_setup_sou_date").value = '';
  document.getElementById("mstprc_setup_sou_quantity").value = '';
  document.getElementById("mstprc_setup_managing_dept_code").value = '';
  document.getElementById("mstprc_setup_managing_dept_name").value = '';
  document.getElementById("mstprc_setup_install_area_code").value = '';
  document.getElementById("mstprc_setup_install_area_name").value = '';
  document.getElementById("mstprc_setup_no_of_units").value = '';
  document.getElementById("mstprc_setup_ntc_or_sa").value = '';
  document.getElementById("mstprc_setup_use_purpose").value = '';
}

const clear_mstprc_setup_fat_fields = () => {
  document.getElementById("mstprc_setup_previous_group").value = '';
  document.getElementById("mstprc_setup_previous_location").value = '';
  document.getElementById("mstprc_setup_previous_grid").value = '';
  document.getElementById("mstprc_setup_new_group").value = '';
  document.getElementById("mstprc_setup_new_location").value = '';
  document.getElementById("mstprc_setup_new_grid").value = '';
  document.getElementById("mstprc_setup_date_transfer").value = '';
  document.getElementById("mstprc_setup_fat_reason").value = '';
}

const clear_mstprc_transfer_fat_fields = () => {
  document.getElementById("mstprc_transfer_previous_group").value = '';
  document.getElementById("mstprc_transfer_previous_location").value = '';
  document.getElementById("mstprc_transfer_previous_grid").value = '';
  document.getElementById("mstprc_transfer_new_group").value = '';
  document.getElementById("mstprc_transfer_new_location").value = '';
  document.getElementById("mstprc_transfer_new_grid").value = '';
  document.getElementById("mstprc_transfer_date_transfer").value = '';
  document.getElementById("mstprc_transfer_fat_reason").value = '';
}

const clear_mstprc_pullout_fat_fields = () => {
  document.getElementById("mstprc_pullout_previous_group").value = '';
  document.getElementById("mstprc_pullout_previous_location").value = '';
  document.getElementById("mstprc_pullout_previous_grid").value = '';
  document.getElementById("mstprc_pullout_new_group").value = '';
  document.getElementById("mstprc_pullout_new_location").value = '';
  document.getElementById("mstprc_pullout_new_grid").value = '';
  document.getElementById("mstprc_pullout_date_transfer").value = '';
  document.getElementById("mstprc_pullout_fat_reason").value = '';
}

const goto_mstprc_setup_sou = () => {
  var machine_no = document.getElementById("mstprc_setup_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_setup_equipment_no").value.trim();

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
            var machine_name = response_array.machine_name;
            var machine_spec = response_array.machine_spec;
            var machine_no = response_array.machine_no;
            var equipment_no = response_array.equipment_no;
            var is_new = response_array.is_new;
            var registered = response_array.registered;

            if (registered == true) {
              if (is_new == 1) {
                document.getElementById("mstprc_setup_asset_name").value = machine_name;
                document.getElementById("mstprc_setup_sup_asset_name").value = machine_spec;
                document.getElementById("mstprc_setup_sou_machine_no").value = machine_no;
                document.getElementById("mstprc_setup_sou_equipment_no").value = equipment_no;
                check_setup_fat();
              } else {
                save_mstprc_setup_1();
              }
            } else {
              swal('Machine Checksheets Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
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
  } else {
    console.log('Machine Checksheets Error - Call IT Personnel Immediately!!! They will fix it right away. Error: Proceeding SOU Form without Machine Identification. Check Fields from Step 1');
  }
}

const check_mstprc_setup_file = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_setup_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_setup_file').files[x]);
  }
  form_data.append("method", 'check_mstprc_file');
  form_data.append("mstprc_no", document.getElementById('mstprc_setup_no').value);

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Checking File Uploaded... please wait...', {
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
          goto_mstprc_setup_fat();
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const check_mstprc_transfer_file = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_transfer_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_transfer_file').files[x]);
  }
  form_data.append("method", 'check_mstprc_file');
  form_data.append("mstprc_no", document.getElementById('mstprc_transfer_no').value);

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Checking File Uploaded... please wait...', {
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
          goto_mstprc_transfer_fat();
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const check_mstprc_pullout_file = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_pullout_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_pullout_file').files[x]);
  }
  form_data.append("method", 'check_mstprc_file');
  form_data.append("mstprc_no", document.getElementById('mstprc_pullout_no').value);

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Checking File Uploaded... please wait...', {
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
          goto_mstprc_pullout_fat();
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const check_mstprc_relayout_file = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_relayout_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_relayout_file').files[x]);
  }
  form_data.append("method", 'check_mstprc_file');
  form_data.append("mstprc_no", document.getElementById('mstprc_relayout_no').value);

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Checking File Uploaded... please wait...', {
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
          save_mstprc_relayout();
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const goto_mstprc_setup_fat = () => {
  var machine_no = document.getElementById("mstprc_setup_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_setup_equipment_no").value.trim();

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
            var machine_name = response_array.machine_name;
            var machine_spec = response_array.machine_spec;
            var machine_no = response_array.machine_no;
            var equipment_no = response_array.equipment_no;
            var asset_tag_no = response_array.asset_tag_no;
            var car_model = response_array.car_model;
            var location = response_array.location;
            var grid = response_array.grid;
            var registered = response_array.registered;

            if (registered == true) {
              document.getElementById("mstprc_setup_item_description").value = machine_name;
              document.getElementById("mstprc_setup_item_name").value = machine_spec;
              document.getElementById("mstprc_setup_fat_machine_no").value = machine_no;
              document.getElementById("mstprc_setup_fat_equipment_no").value = equipment_no;
              document.getElementById("mstprc_setup_fat_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_setup_previous_group").value = car_model;
              document.getElementById("mstprc_setup_previous_location").value = location;
              document.getElementById("mstprc_setup_previous_grid").value = grid;
              $('#MstprcSetupStep2Modal').modal('hide');
              setTimeout(() => {
                $('#MstprcSetupFatModal').modal('show');
              }, 400);
            } else {
              swal('Machine Checksheets Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
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
  } else {
    console.log('Machine Checksheets Error - Call IT Personnel Immediately!!! They will fix it right away. Error: Proceeding SOU Form without Machine Identification. Check Fields from Step 1');
  }
}

const goto_mstprc_transfer_fat = () => {
  var machine_no = document.getElementById("mstprc_transfer_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_transfer_equipment_no").value.trim();

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
            var machine_name = response_array.machine_name;
            var machine_spec = response_array.machine_spec;
            var machine_no = response_array.machine_no;
            var equipment_no = response_array.equipment_no;
            var asset_tag_no = response_array.asset_tag_no;
            var car_model = response_array.car_model;
            var location = response_array.location;
            var grid = response_array.grid;
            var registered = response_array.registered;

            if (registered == true) {
              document.getElementById("mstprc_transfer_item_description").value = machine_name;
              document.getElementById("mstprc_transfer_item_name").value = machine_spec;
              document.getElementById("mstprc_transfer_fat_machine_no").value = machine_no;
              document.getElementById("mstprc_transfer_fat_equipment_no").value = equipment_no;
              document.getElementById("mstprc_transfer_fat_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_transfer_previous_group").value = car_model;
              document.getElementById("mstprc_transfer_previous_location").value = location;
              document.getElementById("mstprc_transfer_previous_grid").value = grid;
              $('#MstprcTransferStep2Modal').modal('hide');
              setTimeout(() => {
                $('#MstprcTransferFatModal').modal('show');
              }, 400);
            } else {
              swal('Machine Checksheets Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
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
  } else {
    console.log('Machine Checksheets Error - Call IT Personnel Immediately!!! They will fix it right away. Error: Proceeding SOU Form without Machine Identification. Check Fields from Step 1');
  }
}

const goto_mstprc_pullout_fat = () => {
  var machine_no = document.getElementById("mstprc_pullout_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_pullout_equipment_no").value.trim();

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
            var machine_name = response_array.machine_name;
            var machine_spec = response_array.machine_spec;
            var machine_no = response_array.machine_no;
            var equipment_no = response_array.equipment_no;
            var asset_tag_no = response_array.asset_tag_no;
            var car_model = response_array.car_model;
            var location = response_array.location;
            var grid = response_array.grid;
            var registered = response_array.registered;

            if (registered == true) {
              document.getElementById("mstprc_pullout_item_description").value = machine_name;
              document.getElementById("mstprc_pullout_item_name").value = machine_spec;
              document.getElementById("mstprc_pullout_fat_machine_no").value = machine_no;
              document.getElementById("mstprc_pullout_fat_equipment_no").value = equipment_no;
              document.getElementById("mstprc_pullout_fat_asset_tag_no").value = asset_tag_no;
              document.getElementById("mstprc_pullout_previous_group").value = car_model;
              document.getElementById("mstprc_pullout_previous_location").value = location;
              document.getElementById("mstprc_pullout_previous_grid").value = grid;
              $('#MstprcPulloutStep2Modal').modal('hide');
              setTimeout(() => {
                $('#MstprcPulloutFatModal').modal('show');
              }, 400);
            } else {
              swal('Machine Checksheets Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
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
  } else {
    console.log('Machine Checksheets Error - Call IT Personnel Immediately!!! They will fix it right away. Error: Proceeding SOU Form without Machine Identification. Check Fields from Step 1');
  }
}

const check_setup_fat = () => {
  // FAT
  var item_description = document.getElementById("mstprc_setup_item_description").value.trim();
  var item_name = document.getElementById("mstprc_setup_item_name").value.trim();
  var machine_no = document.getElementById("mstprc_setup_fat_machine_no").value.trim();
  var equipment_no = document.getElementById("mstprc_setup_fat_equipment_no").value.trim();
  var asset_tag_no = document.getElementById("mstprc_setup_fat_asset_tag_no").value.trim();
  var prev_group = document.getElementById("mstprc_setup_previous_group").value.trim();
  var prev_location = document.getElementById("mstprc_setup_previous_location").value.trim();
  var prev_grid = document.getElementById("mstprc_setup_previous_grid").value.trim();
  var new_group = document.getElementById("mstprc_setup_new_group").value.trim();
  var new_location = document.getElementById("mstprc_setup_new_location").value.trim();
  var new_grid = document.getElementById("mstprc_setup_new_grid").value.trim();
  var date_transfer = document.getElementById("mstprc_setup_date_transfer").value;
  var reason = document.getElementById("mstprc_setup_fat_reason").value.trim();

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'check_setup_fat',
      item_description:item_description,
      item_name:item_name,
      machine_no:machine_no,
      equipment_no:equipment_no,
      asset_tag_no:asset_tag_no,
      prev_group:prev_group,
      prev_location:prev_location,
      prev_grid:prev_grid,
      new_group:new_group,
      new_location:new_location,
      new_grid:new_grid,
      date_transfer:date_transfer,
      reason:reason
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Checking please wait...', {
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
          $('#MstprcSetupFatModal').modal('hide');
          setTimeout(() => {
            $('#MstprcSetupSouModal').modal('show');
          }, 400);
        } else if (response == 'FAT Prev Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set Previous Group / Location', 'info');
        } else if (response == 'FAT New Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set New Group / Location', 'info');
        } else if (response == 'FAT Date Transfer Not Set') {
          swal('Machine Checksheets', 'Please set Date Transferred', 'info');
        } else if (response == 'FAT Reason Empty') {
          swal('Machine Checksheets', 'Please fill out Reason for Transfer', 'info');
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

const save_mstprc_setup_1 = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_setup_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_setup_file').files[x]);
  }
  form_data.append("method", 'save_mstprc_setup_1');
  form_data.append("mstprc_no", document.getElementById('mstprc_setup_no').value);
  form_data.append("machine_no", document.getElementById('mstprc_setup_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('mstprc_setup_equipment_no').value.trim());
  form_data.append("car_model", document.getElementById('mstprc_setup_car_model').value);
  form_data.append("location", document.getElementById('mstprc_setup_location').value);
  form_data.append("grid", document.getElementById('mstprc_setup_grid').value);
  form_data.append("machine_name", document.getElementById('mstprc_setup_machine_name').value);
  form_data.append("trd_no", document.getElementById('mstprc_setup_trd_no').value);
  form_data.append("ns_iv_no", document.getElementById('mstprc_setup_ns-iv_no').value);
  form_data.append("mstprc_date", document.getElementById('mstprc_setup_date').value);
  form_data.append("is_new", document.getElementById('mstprc_setup_is_new').value);

  form_data.append("item_description", document.getElementById('mstprc_setup_item_description').value);
  form_data.append("item_name", document.getElementById('mstprc_setup_item_name').value.trim());
  form_data.append("fat_machine_no", document.getElementById('mstprc_setup_fat_machine_no').value.trim());
  form_data.append("fat_equipment_no", document.getElementById('mstprc_setup_fat_equipment_no').value.trim());
  form_data.append("asset_tag_no", document.getElementById('mstprc_setup_fat_asset_tag_no').value.trim());
  form_data.append("prev_group", document.getElementById('mstprc_setup_previous_group').value.trim());
  form_data.append("prev_location", document.getElementById('mstprc_setup_previous_location').value.trim());
  form_data.append("prev_grid", document.getElementById('mstprc_setup_previous_grid').value.trim());
  form_data.append("new_group", document.getElementById('mstprc_setup_new_group').value.trim());
  form_data.append("new_location", document.getElementById('mstprc_setup_new_location').value.trim());
  form_data.append("new_grid", document.getElementById('mstprc_setup_new_grid').value.trim());
  form_data.append("date_transfer", document.getElementById('mstprc_setup_date_transfer').value);
  form_data.append("reason", document.getElementById('mstprc_setup_fat_reason').value.trim());

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Saving please wait...', {
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
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("mstprc_setup_no").value = '';
          clear_mstprc_setup_step1_fields();
          clear_mstprc_setup_step2_fields();
          document.getElementById("mstprc_setup_item_description").value = '';
          document.getElementById("mstprc_setup_item_name").value = '';
          document.getElementById("mstprc_setup_fat_machine_no").value = '';
          document.getElementById("mstprc_setup_fat_equipment_no").value = '';
          document.getElementById("mstprc_setup_fat_asset_tag_no").value = '';
          clear_mstprc_setup_fat_fields();
          document.getElementById("mstprc_setup_asset_name").value = '';
          document.getElementById("mstprc_setup_sup_asset_name").value = '';
          document.getElementById("mstprc_setup_sou_machine_no").value = '';
          document.getElementById("mstprc_setup_sou_equipment_no").value = '';
          clear_mstprc_setup_sou_fields();
          get_pending_machine_checksheets();
          $('#MstprcSetupFatModal').modal('hide');
        } else if (response == 'FAT Prev Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set Previous Group / Location', 'info');
        } else if (response == 'FAT New Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set New Group / Location', 'info');
        } else if (response == 'FAT Date Transfer Not Set') {
          swal('Machine Checksheets', 'Please set Date Transferred', 'info');
        } else if (response == 'FAT Reason Empty') {
          swal('Machine Checksheets', 'Please fill out Reason for Transfer', 'info');
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

const save_mstprc_setup_2 = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_setup_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_setup_file').files[x]);
  }
  form_data.append("method", 'save_mstprc_setup_2');
  form_data.append("mstprc_no", document.getElementById('mstprc_setup_no').value);
  form_data.append("machine_no", document.getElementById('mstprc_setup_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('mstprc_setup_equipment_no').value.trim());
  form_data.append("car_model", document.getElementById('mstprc_setup_car_model').value);
  form_data.append("location", document.getElementById('mstprc_setup_location').value);
  form_data.append("grid", document.getElementById('mstprc_setup_grid').value);
  form_data.append("machine_name", document.getElementById('mstprc_setup_machine_name').value);
  form_data.append("trd_no", document.getElementById('mstprc_setup_trd_no').value);
  form_data.append("ns_iv_no", document.getElementById('mstprc_setup_ns-iv_no').value);
  form_data.append("mstprc_date", document.getElementById('mstprc_setup_date').value);
  form_data.append("is_new", document.getElementById('mstprc_setup_is_new').value);

  form_data.append("item_description", document.getElementById('mstprc_setup_item_description').value);
  form_data.append("item_name", document.getElementById('mstprc_setup_item_name').value.trim());
  form_data.append("fat_machine_no", document.getElementById('mstprc_setup_fat_machine_no').value.trim());
  form_data.append("fat_equipment_no", document.getElementById('mstprc_setup_fat_equipment_no').value.trim());
  form_data.append("asset_tag_no", document.getElementById('mstprc_setup_fat_asset_tag_no').value.trim());
  form_data.append("prev_group", document.getElementById('mstprc_setup_previous_group').value.trim());
  form_data.append("prev_location", document.getElementById('mstprc_setup_previous_location').value.trim());
  form_data.append("prev_grid", document.getElementById('mstprc_setup_previous_grid').value.trim());
  form_data.append("new_group", document.getElementById('mstprc_setup_new_group').value.trim());
  form_data.append("new_location", document.getElementById('mstprc_setup_new_location').value.trim());
  form_data.append("new_grid", document.getElementById('mstprc_setup_new_grid').value.trim());
  form_data.append("date_transfer", document.getElementById('mstprc_setup_date_transfer').value);
  form_data.append("reason", document.getElementById('mstprc_setup_fat_reason').value.trim());

  form_data.append("kigyo_no", document.getElementById('mstprc_setup_kigyo_no').value.trim());
  form_data.append("asset_name", document.getElementById('mstprc_setup_asset_name').value.trim());
  form_data.append("sup_asset_name", document.getElementById('mstprc_setup_sup_asset_name').value.trim());
  form_data.append("orig_asset_no", document.getElementById('mstprc_setup_orig_asset_no').value.trim());
  form_data.append("sou_date", document.getElementById('mstprc_setup_sou_date').value);
  form_data.append("sou_quantity", document.getElementById('mstprc_setup_sou_quantity').value.trim());
  form_data.append("managing_dept_code", document.getElementById('mstprc_setup_managing_dept_code').value.trim());
  form_data.append("managing_dept_name", document.getElementById('mstprc_setup_managing_dept_name').value.trim());
  form_data.append("install_area_code", document.getElementById('mstprc_setup_install_area_code').value.trim());
  form_data.append("install_area_name", document.getElementById('mstprc_setup_install_area_name').value.trim());
  form_data.append("sou_machine_no", document.getElementById('mstprc_setup_sou_machine_no').value.trim());
  form_data.append("sou_equipment_no", document.getElementById('mstprc_setup_sou_equipment_no').value.trim());
  form_data.append("no_of_units", document.getElementById('mstprc_setup_no_of_units').value.trim());
  form_data.append("ntc_or_sa", document.getElementById('mstprc_setup_ntc_or_sa').value);
  form_data.append("use_purpose", document.getElementById('mstprc_setup_use_purpose').value.trim());

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Saving please wait...', {
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
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("mstprc_setup_no").value = '';
          clear_mstprc_setup_step1_fields();
          clear_mstprc_setup_step2_fields();
          document.getElementById("mstprc_setup_item_description").value = '';
          document.getElementById("mstprc_setup_item_name").value = '';
          document.getElementById("mstprc_setup_fat_machine_no").value = '';
          document.getElementById("mstprc_setup_fat_equipment_no").value = '';
          document.getElementById("mstprc_setup_fat_asset_tag_no").value = '';
          clear_mstprc_setup_fat_fields();
          document.getElementById("mstprc_setup_asset_name").value = '';
          document.getElementById("mstprc_setup_sup_asset_name").value = '';
          document.getElementById("mstprc_setup_sou_machine_no").value = '';
          document.getElementById("mstprc_setup_sou_equipment_no").value = '';
          clear_mstprc_setup_sou_fields();
          get_pending_machine_checksheets();
          $('#MstprcSetupSouModal').modal('hide');
        } else if (response == 'SOU Kigyo No. Empty') {
          swal('Machine Checksheets', 'Please fill out Kigyo No.', 'info');
        } else if (response == 'SOU Date Not Set') {
          swal('Machine Checksheets', 'Please set SOU Date', 'info');
        } else if (response == 'SOU Quantity Below 1') {
          swal('Machine Checksheets Error', 'Quantity Below 1 Not Accepted', 'error');
        } else if (response == 'SOU Managing Dept Code-Name Empty') {
          swal('Machine Checksheets', 'Please fill out Managing Dept Code & Name', 'info');
        } else if (response == 'SOU Install Area Code-Name Empty') {
          swal('Machine Checksheets', 'Please fill out Install Area Code & Name', 'info');
        } else if (response == 'SOU No. of Units Below 1') {
          swal('Machine Checksheets Error', 'No. of Units Below 1 Not Accepted', 'error');
        } else if (response == 'SOU NTC or SA Not Set') {
          swal('Machine Checksheets', 'Please set need to convert or standalone Not Set', 'info');
        } else if (response == 'SOU Use Purpose Empty') {
          swal('Machine Checksheets', 'Please fill out Install Area Code & Name', 'info');
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

const save_mstprc_transfer = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_transfer_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_transfer_file').files[x]);
  }
  form_data.append("method", 'save_mstprc_transfer');
  form_data.append("mstprc_no", document.getElementById('mstprc_transfer_no').value);
  form_data.append("machine_no", document.getElementById('mstprc_transfer_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('mstprc_transfer_equipment_no').value.trim());
  form_data.append("car_model", document.getElementById('mstprc_transfer_car_model').value);
  form_data.append("location", document.getElementById('mstprc_transfer_location').value);
  form_data.append("grid", document.getElementById('mstprc_transfer_grid').value);
  form_data.append("machine_name", document.getElementById('mstprc_transfer_machine_name').value);
  form_data.append("trd_no", document.getElementById('mstprc_transfer_trd_no').value);
  form_data.append("ns_iv_no", document.getElementById('mstprc_transfer_ns-iv_no').value);
  form_data.append("mstprc_date", document.getElementById('mstprc_transfer_date').value);
  form_data.append("to_car_model", document.getElementById('mstprc_transfer_to_car_model').value.trim());
  form_data.append("to_location", document.getElementById('mstprc_transfer_to_location').value.trim());
  form_data.append("to_grid", document.getElementById('mstprc_transfer_to_grid').value.trim());
  form_data.append("transfer_reason", document.getElementById('mstprc_transfer_reason').value.trim());

  form_data.append("item_description", document.getElementById('mstprc_transfer_item_description').value);
  form_data.append("item_name", document.getElementById('mstprc_transfer_item_name').value.trim());
  form_data.append("fat_machine_no", document.getElementById('mstprc_transfer_fat_machine_no').value.trim());
  form_data.append("fat_equipment_no", document.getElementById('mstprc_transfer_fat_equipment_no').value.trim());
  form_data.append("asset_tag_no", document.getElementById('mstprc_transfer_fat_asset_tag_no').value.trim());
  form_data.append("prev_group", document.getElementById('mstprc_transfer_previous_group').value.trim());
  form_data.append("prev_location", document.getElementById('mstprc_transfer_previous_location').value.trim());
  form_data.append("prev_grid", document.getElementById('mstprc_transfer_previous_grid').value.trim());
  form_data.append("new_group", document.getElementById('mstprc_transfer_new_group').value.trim());
  form_data.append("new_location", document.getElementById('mstprc_transfer_new_location').value.trim());
  form_data.append("new_grid", document.getElementById('mstprc_transfer_new_grid').value.trim());
  form_data.append("date_transfer", document.getElementById('mstprc_transfer_date_transfer').value);
  form_data.append("reason", document.getElementById('mstprc_transfer_fat_reason').value.trim());

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Saving please wait...', {
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
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("mstprc_transfer_no").value = '';
          clear_mstprc_transfer_step1_fields();
          clear_mstprc_transfer_step2_fields();
          document.getElementById("mstprc_transfer_item_description").value = '';
          document.getElementById("mstprc_transfer_item_name").value = '';
          document.getElementById("mstprc_transfer_fat_machine_no").value = '';
          document.getElementById("mstprc_transfer_fat_equipment_no").value = '';
          document.getElementById("mstprc_transfer_fat_asset_tag_no").value = '';
          clear_mstprc_transfer_fat_fields();
          get_pending_machine_checksheets();
          $('#MstprcTransferFatModal').modal('hide');
        } else if (response == 'FAT Prev Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set Previous Group / Location', 'info');
        } else if (response == 'FAT New Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set New Group / Location', 'info');
        } else if (response == 'FAT Date Transfer Not Set') {
          swal('Machine Checksheets', 'Please set Date Transferred', 'info');
        } else if (response == 'FAT Reason Empty') {
          swal('Machine Checksheets', 'Please fill out Reason for Transfer', 'info');
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

const save_mstprc_pullout = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_pullout_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_pullout_file').files[x]);
  }
  form_data.append("method", 'save_mstprc_pullout');
  form_data.append("mstprc_no", document.getElementById('mstprc_pullout_no').value);
  form_data.append("machine_no", document.getElementById('mstprc_pullout_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('mstprc_pullout_equipment_no').value.trim());
  form_data.append("car_model", document.getElementById('mstprc_pullout_car_model').value);
  form_data.append("location", document.getElementById('mstprc_pullout_location').value);
  form_data.append("grid", document.getElementById('mstprc_pullout_grid').value);
  form_data.append("machine_name", document.getElementById('mstprc_pullout_machine_name').value);
  form_data.append("trd_no", document.getElementById('mstprc_pullout_trd_no').value);
  form_data.append("ns_iv_no", document.getElementById('mstprc_pullout_ns-iv_no').value);
  form_data.append("mstprc_date", document.getElementById('mstprc_pullout_date').value);
  form_data.append("pullout_reason", document.getElementById('mstprc_pullout_reason').value.trim());
  form_data.append("pullout_location", document.getElementById('mstprc_pullout_machine_location').value.trim());

  form_data.append("item_description", document.getElementById('mstprc_pullout_item_description').value);
  form_data.append("item_name", document.getElementById('mstprc_pullout_item_name').value.trim());
  form_data.append("fat_machine_no", document.getElementById('mstprc_pullout_fat_machine_no').value.trim());
  form_data.append("fat_equipment_no", document.getElementById('mstprc_pullout_fat_equipment_no').value.trim());
  form_data.append("asset_tag_no", document.getElementById('mstprc_pullout_fat_asset_tag_no').value.trim());
  form_data.append("prev_group", document.getElementById('mstprc_pullout_previous_group').value.trim());
  form_data.append("prev_location", document.getElementById('mstprc_pullout_previous_location').value.trim());
  form_data.append("prev_grid", document.getElementById('mstprc_pullout_previous_grid').value.trim());
  form_data.append("new_group", document.getElementById('mstprc_pullout_new_group').value.trim());
  form_data.append("new_location", document.getElementById('mstprc_pullout_new_location').value.trim());
  form_data.append("new_grid", document.getElementById('mstprc_pullout_new_grid').value.trim());
  form_data.append("date_transfer", document.getElementById('mstprc_pullout_date_transfer').value);
  form_data.append("reason", document.getElementById('mstprc_pullout_fat_reason').value.trim());

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Saving please wait...', {
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
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("mstprc_pullout_no").value = '';
          clear_mstprc_pullout_step1_fields();
          clear_mstprc_pullout_step2_fields();
          document.getElementById("mstprc_pullout_item_description").value = '';
          document.getElementById("mstprc_pullout_item_name").value = '';
          document.getElementById("mstprc_pullout_fat_machine_no").value = '';
          document.getElementById("mstprc_pullout_fat_equipment_no").value = '';
          document.getElementById("mstprc_pullout_fat_asset_tag_no").value = '';
          clear_mstprc_pullout_fat_fields();
          get_pending_machine_checksheets();
          $('#MstprcPulloutFatModal').modal('hide');
        } else if (response == 'FAT Prev Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set Previous Group / Location', 'info');
        } else if (response == 'FAT New Group-Location Not Set') {
          swal('Machine Checksheets', 'Please set New Group / Location', 'info');
        } else if (response == 'FAT Date Transfer Not Set') {
          swal('Machine Checksheets', 'Please set Date Transferred', 'info');
        } else if (response == 'FAT Reason Empty') {
          swal('Machine Checksheets', 'Please fill out Reason for Transfer', 'info');
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

const save_mstprc_relayout = () => {
  var form_data = new FormData();
  var ins = document.getElementById('mstprc_relayout_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('mstprc_relayout_file').files[x]);
  }
  form_data.append("method", 'save_mstprc_relayout');
  form_data.append("mstprc_no", document.getElementById('mstprc_relayout_no').value);
  form_data.append("machine_no", document.getElementById('mstprc_relayout_machine_no').value.trim());
  form_data.append("equipment_no", document.getElementById('mstprc_relayout_equipment_no').value.trim());
  form_data.append("car_model", document.getElementById('mstprc_relayout_car_model').value);
  form_data.append("location", document.getElementById('mstprc_relayout_location').value);
  form_data.append("grid", document.getElementById('mstprc_relayout_grid').value);
  form_data.append("machine_name", document.getElementById('mstprc_relayout_machine_name').value);
  form_data.append("trd_no", document.getElementById('mstprc_relayout_trd_no').value);
  form_data.append("ns_iv_no", document.getElementById('mstprc_relayout_ns-iv_no').value);
  form_data.append("mstprc_date", document.getElementById('mstprc_relayout_date').value);

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Checksheets', 'Saving please wait...', {
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
          swal('Machine Checksheets', 'Successfully Saved', 'success');
          document.getElementById("mstprc_relayout_no").value = '';
          clear_mstprc_relayout_step1_fields();
          clear_mstprc_relayout_step2_fields();
          get_pending_machine_checksheets();
          $('#MstprcRelayoutStep2Modal').modal('hide');
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

$('#machineChecksheetPendingTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_pending_machine_checksheets = el => {
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

  var setup_process = el.dataset.setup_process;
  var fat_no = el.dataset.fat_no;
  var sou_no = el.dataset.sou_no;

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

  document.getElementById("pending_mstprc_setup_process").value = setup_process;
  document.getElementById("pending_mstprc_fat_no").value = fat_no;
  document.getElementById("pending_mstprc_sou_no").value = sou_no;

  if (mstprc_process_status == 'Saved' && getCookie('setup_role') == 'Admin') {
    if (setup_process == 'Final') {
      document.getElementById("pending_mstprc_approver").removeAttribute('disabled');
      document.getElementById("pending_mstprc_approver_div").style.display = 'block';
    } else {
      document.getElementById("pending_mstprc_approver").setAttribute('disabled', true);
      document.getElementById("pending_mstprc_approver_div").style.display = 'none';
    }
    document.getElementById("btnReturnPendingMstprc").removeAttribute('disabled');
    document.getElementById("btnReturnPendingMstprc").style.display = 'block';
    document.getElementById("btnConfirmPendingMstprc").removeAttribute('disabled');
    document.getElementById("btnConfirmPendingMstprc").style.display = 'block';
  } else {
    document.getElementById("pending_mstprc_approver").setAttribute('disabled', true);
    document.getElementById("pending_mstprc_approver_div").style.display = 'none';

    document.getElementById("btnReturnPendingMstprc").setAttribute('disabled', true);
    document.getElementById("btnReturnPendingMstprc").style.display = 'none';
    document.getElementById("btnConfirmPendingMstprc").setAttribute('disabled', true);
    document.getElementById("btnConfirmPendingMstprc").style.display = 'none';
  }

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pending_machine_checksheets_mark_as_read',
      mstprc_process_status:mstprc_process_status,
      mstprc_no:mstprc_no
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
      let table_rows = parseInt(document.getElementById("machineChecksheetPendingData").childNodes.length);
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
      document.getElementById("machineChecksheetPendingData").innerHTML = response; 
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
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`);
    }
  });
}

const download_pending_mstprc = opt => {
  let file_url = '';
  switch(opt) {
    case 1:
      file_url = document.getElementById("pending_mstprc_file_url").value;
      break;
    case 2:
      file_url = document.getElementById("returned_mstprc_file_url").value;
      break;
    default:
  }
  window.open(file_url,'_blank');
}

const view_pending_fat = opt => {
  let fat_no = '';
  switch(opt) {
    case 1:
      fat_no = document.getElementById("pending_mstprc_fat_no").value;
      break;
    case 2:
      fat_no = document.getElementById("returned_mstprc_fat_no").value;
      break;
    default:
  }
  if (fat_no != '') {
    $.ajax({
      url: '../process/admin/machine-checksheets_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'view_pending_fat',
        fat_no:fat_no
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (response_array.message == 'success') {
            switch(opt) {
              case 1:
                document.getElementById("fat_info_id").value = response_array.id;
                document.getElementById("fat_info_no").innerHTML = response_array.fat_no;
                document.getElementById("fat_info_item_name").innerHTML = response_array.item_name;
                document.getElementById("fat_info_item_description").innerHTML = response_array.item_description;
                document.getElementById("fat_info_machine_no").innerHTML = response_array.machine_no;
                document.getElementById("fat_info_equipment_no").innerHTML = response_array.equipment_no;
                document.getElementById("fat_info_asset_tag_no").innerHTML = response_array.asset_tag_no;
                document.getElementById("fat_info_prev_location_group").innerHTML = response_array.prev_location_group;
                document.getElementById("fat_info_prev_location_loc").innerHTML = response_array.prev_location_loc;
                document.getElementById("fat_info_prev_location_grid").innerHTML = response_array.prev_location_grid;
                document.getElementById("fat_info_date_transfer").innerHTML = response_array.date_transfer;
                document.getElementById("fat_info_new_location_group").innerHTML = response_array.new_location_group;
                document.getElementById("fat_info_new_location_loc").innerHTML = response_array.new_location_loc;
                document.getElementById("fat_info_new_location_grid").innerHTML = response_array.new_location_grid;
                document.getElementById("fat_info_reason").innerHTML = response_array.reason;
                $('#PendingMachineChecksheetInfoModal').modal('hide');
                setTimeout(() => {$('#FatInfoModal').modal('show');}, 400);
                break;
              case 2:
                document.getElementById("returned_fat_info_id").value = response_array.id;
                document.getElementById("returned_fat_info_no").innerHTML = response_array.fat_no;
                document.getElementById("returned_fat_info_item_name").innerHTML = response_array.item_name;
                document.getElementById("returned_fat_info_item_description").innerHTML = response_array.item_description;
                document.getElementById("returned_fat_info_machine_no").innerHTML = response_array.machine_no;
                document.getElementById("returned_fat_info_equipment_no").innerHTML = response_array.equipment_no;
                document.getElementById("returned_fat_info_asset_tag_no").innerHTML = response_array.asset_tag_no;
                document.getElementById("returned_fat_info_prev_location_group").innerHTML = response_array.prev_location_group;
                document.getElementById("returned_fat_info_prev_location_loc").innerHTML = response_array.prev_location_loc;
                document.getElementById("returned_fat_info_prev_location_grid").innerHTML = response_array.prev_location_grid;
                document.getElementById("returned_fat_info_date_transfer").innerHTML = response_array.date_transfer;
                document.getElementById("returned_fat_info_new_location_group").innerHTML = response_array.new_location_group;
                document.getElementById("returned_fat_info_new_location_loc").innerHTML = response_array.new_location_loc;
                document.getElementById("returned_fat_info_new_location_grid").innerHTML = response_array.new_location_grid;
                document.getElementById("returned_fat_info_reason").innerHTML = response_array.reason;
                $('#ReturnedMachineChecksheetInfoModal').modal('hide');
                setTimeout(() => {$('#ReturnedFatInfoModal').modal('show');}, 400);
                break;
              default:
            }
          } else if (response_array.message == 'FAT Not Found') {
            swal('Machine Checksheets', 'FAT Not Found', 'error');
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
  } else {
    swal('Machine Checksheets', 'FAT Unavailable', 'info');
  }
}

const view_pending_sou = opt => {
  let sou_no = '';
  switch(opt) {
    case 1:
      sou_no = document.getElementById("pending_mstprc_sou_no").value;
      break;
    case 2:
      sou_no = document.getElementById("returned_mstprc_sou_no").value;
      break;
    default:
  }
  if (sou_no != '') {
    $.ajax({
      url: '../process/admin/machine-checksheets_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'view_pending_sou',
        sou_no:sou_no
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (response_array.message == 'success') {
            switch(opt) {
              case 1:
                document.getElementById("sou_info_id").value = response_array.id;
                document.getElementById("sou_info_no").innerHTML = response_array.sou_no;
                document.getElementById("sou_info_kigyo_no").innerHTML = response_array.kigyo_no;
                document.getElementById("sou_info_asset_name").innerHTML = response_array.asset_name;
                document.getElementById("sou_info_sup_asset_name").innerHTML = response_array.sup_asset_name;
                document.getElementById("sou_info_orig_asset_no").innerHTML = response_array.orig_asset_no;
                document.getElementById("sou_info_date").innerHTML = response_array.sou_date;
                document.getElementById("sou_info_quantity").innerHTML = response_array.quantity;
                document.getElementById("sou_info_managing_dept_code").innerHTML = response_array.managing_dept_code;
                document.getElementById("sou_info_managing_dept_name").innerHTML = response_array.managing_dept_name;
                document.getElementById("sou_info_install_area_code").innerHTML = response_array.install_area_code;
                document.getElementById("sou_info_install_area_name").innerHTML = response_array.install_area_name;
                document.getElementById("sou_info_machine_no").innerHTML = response_array.machine_no;
                document.getElementById("sou_info_equipment_no").innerHTML = response_array.equipment_no;
                document.getElementById("sou_info_no_of_units").innerHTML = response_array.no_of_units;
                document.getElementById("sou_info_ntc_or_sa").innerHTML = response_array.ntc_or_sa;
                document.getElementById("sou_info_use_purpose").innerHTML = response_array.use_purpose;
                $('#PendingMachineChecksheetInfoModal').modal('hide');
                setTimeout(() => {$('#SouInfoModal').modal('show');}, 400);
                break;
              case 2:
                document.getElementById("returned_sou_info_id").value = response_array.id;
                document.getElementById("returned_sou_info_no").innerHTML = response_array.sou_no;
                document.getElementById("returned_sou_info_kigyo_no").innerHTML = response_array.kigyo_no;
                document.getElementById("returned_sou_info_asset_name").innerHTML = response_array.asset_name;
                document.getElementById("returned_sou_info_sup_asset_name").innerHTML = response_array.sup_asset_name;
                document.getElementById("returned_sou_info_orig_asset_no").innerHTML = response_array.orig_asset_no;
                document.getElementById("returned_sou_info_date").innerHTML = response_array.sou_date;
                document.getElementById("returned_sou_info_quantity").innerHTML = response_array.quantity;
                document.getElementById("returned_sou_info_managing_dept_code").innerHTML = response_array.managing_dept_code;
                document.getElementById("returned_sou_info_managing_dept_name").innerHTML = response_array.managing_dept_name;
                document.getElementById("returned_sou_info_install_area_code").innerHTML = response_array.install_area_code;
                document.getElementById("returned_sou_info_install_area_name").innerHTML = response_array.install_area_name;
                document.getElementById("returned_sou_info_machine_no").innerHTML = response_array.machine_no;
                document.getElementById("returned_sou_info_equipment_no").innerHTML = response_array.equipment_no;
                document.getElementById("returned_sou_info_no_of_units").innerHTML = response_array.no_of_units;
                document.getElementById("returned_sou_info_ntc_or_sa").innerHTML = response_array.ntc_or_sa;
                document.getElementById("returned_sou_info_use_purpose").innerHTML = response_array.use_purpose;
                $('#ReturnedMachineChecksheetInfoModal').modal('hide');
                setTimeout(() => {$('#ReturnedSouInfoModal').modal('show');}, 400);
                break;
              default:
            }
          } else if (response_array.message == 'SOU Not Found') {
            swal('Machine Checksheets', 'SOU Not Found', 'error');
          }
        } catch(e) {
          console.log(e);
          swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    swal('Machine Checksheets', 'SOU Unavailable', 'info');
  }
}

$('#machineChecksheetReturnedTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_returned_machine_checksheets = el => {
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

  var setup_process = el.dataset.setup_process;
  var fat_no = el.dataset.fat_no;
  var sou_no = el.dataset.sou_no;

  document.getElementById("returned_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("returned_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("returned_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("returned_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("returned_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("returned_mstprc_car_model").value = car_model;
  document.getElementById("returned_mstprc_location").value = location;
  document.getElementById("returned_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("returned_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("returned_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("returned_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("returned_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("returned_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("returned_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("returned_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("returned_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("returned_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("returned_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("returned_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("returned_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("returned_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("returned_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("returned_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("returned_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("returned_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("returned_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("returned_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("returned_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("returned_mstprc_qa_manager").value = mstprc_qa_manager;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("returned_mstprc_from_car_model").value = car_model;
    document.getElementById("returned_mstprc_from_location").value = location;
    document.getElementById("returned_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("returned_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("returned_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("returned_mstprc_to_car_model").value = to_car_model;
  document.getElementById("returned_mstprc_to_location").value = to_location;
  document.getElementById("returned_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("returned_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("returned_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("returned_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("returned_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("returned_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("returned_mstprc_file_name").innerHTML = file_name;
  document.getElementById("returned_mstprc_file_url").value = file_url;

  document.getElementById("returned_mstprc_setup_process").value = setup_process;
  document.getElementById("returned_mstprc_fat_no").value = fat_no;
  document.getElementById("returned_mstprc_sou_no").value = sou_no;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'returned_machine_checksheets_mark_as_read',
      mstprc_process_status:mstprc_process_status,
      mstprc_no:mstprc_no
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
      let table_rows = parseInt(document.getElementById("machineChecksheetReturnedData").childNodes.length);
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
      document.getElementById("machineChecksheetReturnedData").innerHTML = response; 
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
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`);
    }
  });
}

const get_returned_fat = opt => {
  var fat_no = document.getElementById("returned_mstprc_fat_no").value;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_pending_fat',
      fat_no:fat_no
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        if (response_array.message == 'success') {
          switch(opt) {
            case 1:
              document.getElementById("fat_info_no").innerHTML = response_array.fat_no;

              document.getElementById('mstprc_setup_item_description').value = response_array.item_description;
              document.getElementById('mstprc_setup_item_name').value = response_array.item_name;
              document.getElementById('mstprc_setup_fat_machine_no').value = response_array.machine_no;
              document.getElementById('mstprc_setup_fat_equipment_no').value = response_array.equipment_no;
              document.getElementById('mstprc_setup_fat_asset_tag_no').value = response_array.asset_tag_no;
              document.getElementById('mstprc_setup_previous_group').value = response_array.prev_location_group;
              document.getElementById('mstprc_setup_previous_location').value = response_array.prev_location_loc;
              document.getElementById('mstprc_setup_previous_grid').value = response_array.prev_location_grid;
              document.getElementById('mstprc_setup_new_group').value = response_array.new_location_group;
              document.getElementById('mstprc_setup_new_location').value = response_array.new_location_loc;
              document.getElementById('mstprc_setup_new_grid').value = response_array.new_location_grid;
              document.getElementById('mstprc_setup_date_transfer').value = response_array.date_transfer;
              document.getElementById('mstprc_setup_fat_reason').value = response_array.reason;
              break;
            case 2:
              document.getElementById("fat_info_no").innerHTML = response_array.fat_no;

              document.getElementById('mstprc_transfer_item_description').value = response_array.item_description;
              document.getElementById('mstprc_transfer_item_name').value = response_array.item_name;
              document.getElementById('mstprc_transfer_fat_machine_no').value = response_array.machine_no;
              document.getElementById('mstprc_transfer_fat_equipment_no').value = response_array.equipment_no;
              document.getElementById('mstprc_transfer_fat_asset_tag_no').value = response_array.asset_tag_no;
              document.getElementById('mstprc_transfer_previous_group').value = response_array.prev_location_group;
              document.getElementById('mstprc_transfer_previous_location').value = response_array.prev_location_loc;
              document.getElementById('mstprc_transfer_previous_grid').value = response_array.prev_location_grid;
              document.getElementById('mstprc_transfer_new_group').value = response_array.new_location_group;
              document.getElementById('mstprc_transfer_new_location').value = response_array.new_location_loc;
              document.getElementById('mstprc_transfer_new_grid').value = response_array.new_location_grid;
              document.getElementById('mstprc_transfer_date_transfer').value = response_array.date_transfer;
              document.getElementById('mstprc_transfer_fat_reason').value = response_array.reason;
              break;
            case 3:
              document.getElementById("fat_info_no").innerHTML = response_array.fat_no;

              document.getElementById('mstprc_pullout_item_description').value = response_array.item_description;
              document.getElementById('mstprc_pullout_item_name').value = response_array.item_name;
              document.getElementById('mstprc_pullout_fat_machine_no').value = response_array.machine_no;
              document.getElementById('mstprc_pullout_fat_equipment_no').value = response_array.equipment_no;
              document.getElementById('mstprc_pullout_fat_asset_tag_no').value = response_array.asset_tag_no;
              document.getElementById('mstprc_pullout_previous_group').value = response_array.prev_location_group;
              document.getElementById('mstprc_pullout_previous_location').value = response_array.prev_location_loc;
              document.getElementById('mstprc_pullout_previous_grid').value = response_array.prev_location_grid;
              document.getElementById('mstprc_pullout_new_group').value = response_array.new_location_group;
              document.getElementById('mstprc_pullout_new_location').value = response_array.new_location_loc;
              document.getElementById('mstprc_pullout_new_grid').value = response_array.new_location_grid;
              document.getElementById('mstprc_pullout_date_transfer').value = response_array.date_transfer;
              document.getElementById('mstprc_pullout_fat_reason').value = response_array.reason;
              break;
            default:
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
}

const get_returned_sou = () => {
  var sou_no = document.getElementById("returned_mstprc_sou_no").value;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'view_pending_sou',
      sou_no:sou_no
    }, 
    success: response => {
      try {
        let response_array = JSON.parse(response);
        if (response_array.message == 'success') {
          document.getElementById("sou_info_no").innerHTML = response_array.sou_no;

          document.getElementById('mstprc_setup_kigyo_no').value = response_array.kigyo_no;
          document.getElementById('mstprc_setup_asset_name').value = response_array.asset_name;
          document.getElementById('mstprc_setup_sup_asset_name').value = response_array.sup_asset_name;
          document.getElementById('mstprc_setup_orig_asset_no').value = response_array.orig_asset_no;
          document.getElementById('mstprc_setup_sou_date').value = response_array.sou_date;
          document.getElementById('mstprc_setup_sou_quantity').value = response_array.quantity;
          document.getElementById('mstprc_setup_managing_dept_code').value = response_array.managing_dept_code;
          document.getElementById('mstprc_setup_managing_dept_name').value = response_array.managing_dept_name;
          document.getElementById('mstprc_setup_install_area_code').value = response_array.install_area_code;
          document.getElementById('mstprc_setup_install_area_name').value = response_array.install_area_name;
          document.getElementById('mstprc_setup_sou_machine_no').value = response_array.machine_no;
          document.getElementById('mstprc_setup_sou_equipment_no').value = response_array.equipment_no;
          document.getElementById('mstprc_setup_no_of_units').value = response_array.no_of_units;
          document.getElementById('mstprc_setup_ntc_or_sa').value = response_array.ntc_or_sa;
          document.getElementById('mstprc_setup_use_purpose').value = response_array.use_purpose;
        }
      } catch(e) {
        console.log(e);
        swal('Machine Checksheets Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const revise_returned_mstprc = () => {
  var mstprc_no = document.getElementById("returned_mstprc_no").innerHTML;
  var mstprc_type = document.getElementById("returned_mstprc_type").innerHTML;
  var machine_name = document.getElementById("returned_mstprc_machine_name").innerHTML;
  var machine_no = document.getElementById("returned_mstprc_machine_no").innerHTML;
  var equipment_no = document.getElementById("returned_mstprc_equipment_no").innerHTML;
  var car_model = document.getElementById("returned_mstprc_car_model").value;
  var location = document.getElementById("returned_mstprc_location").value;
  var grid = document.getElementById("returned_mstprc_grid").value;
  var to_car_model = document.getElementById("returned_mstprc_to_car_model").value;
  var to_location = document.getElementById("returned_mstprc_to_location").value;
  var to_grid = document.getElementById("returned_mstprc_to_grid").value;
  var pullout_location = document.getElementById("returned_mstprc_pullout_location").innerHTML;
  var transfer_reason = document.getElementById("returned_mstprc_transfer_reason").innerHTML;
  var pullout_reason = document.getElementById("returned_mstprc_pullout_reason").innerHTML;

  var mstprc_date = document.getElementById("returned_mstprc_date").innerHTML;
  mstprc_date.replace("-", " ");
  mstprc_date = new Date(mstprc_date);
  let day = mstprc_date.getDate();
  let month = mstprc_date.getMonth();
  let year = mstprc_date.getFullYear();
  if (day < 10) {
    day = '0' + day;
  }
  month++;
  if (month < 10) {
    month = `0${month}`;
  } else {
    month = `${month}`;
  }
  mstprc_date = `${year}-${month}-${day}`;

  var setup_process = document.getElementById("returned_mstprc_setup_process").value;
  var fat_no = document.getElementById("returned_mstprc_fat_no").value;
  var sou_no = document.getElementById("returned_mstprc_sou_no").value;

  switch(mstprc_type) {
    case 'Setup':
      document.getElementById('mstprc_setup_no').value = mstprc_no;
      document.getElementById('mstprc_setup_machine_no').value = machine_no;
      document.getElementById('mstprc_setup_equipment_no').value = equipment_no;
      document.getElementById('mstprc_setup_date').value = mstprc_date;

      get_returned_fat(1);
      get_returned_sou();

      $('#ReturnedMachineChecksheetInfoModal').modal('hide');
      setTimeout(() => {$('#MstprcSetupStep1Modal').modal('show');}, 400);
      break;
    case 'Transfer':
      document.getElementById('mstprc_transfer_no').value = mstprc_no;
      document.getElementById('mstprc_transfer_machine_no').value = machine_no;
      document.getElementById('mstprc_transfer_equipment_no').value = equipment_no;
      document.getElementById('mstprc_transfer_date').value = mstprc_date;

      get_returned_fat(2);

      $('#ReturnedMachineChecksheetInfoModal').modal('hide');
      setTimeout(() => {$('#MstprcTransferStep1Modal').modal('show');}, 400);
      break;
    case 'Pullout':
      document.getElementById('mstprc_pullout_no').value = mstprc_no;
      document.getElementById('mstprc_pullout_machine_no').value = machine_no;
      document.getElementById('mstprc_pullout_equipment_no').value = equipment_no;
      document.getElementById('mstprc_pullout_date').value = mstprc_date;

      get_returned_fat(3);

      $('#ReturnedMachineChecksheetInfoModal').modal('hide');
      setTimeout(() => {$('#MstprcPulloutStep1Modal').modal('show');}, 400);
      break;
    case 'Relayout':
      document.getElementById('mstprc_relayout_no').value = mstprc_no;
      document.getElementById('mstprc_relayout_machine_no').value = machine_no;
      document.getElementById('mstprc_relayout_equipment_no').value = equipment_no;
      document.getElementById('mstprc_relayout_date').value = mstprc_date;

      $('#ReturnedMachineChecksheetInfoModal').modal('hide');
      setTimeout(() => {$('#MstprcRelayoutStep1Modal').modal('show');}, 400);
      break;
    default:
  }
}

const return_pending_mstprc = () => {
  var mstprc_no = document.getElementById("pending_mstprc_no").innerHTML;
  var fat_no = document.getElementById("pending_mstprc_fat_no").value;
  var sou_no = document.getElementById("pending_mstprc_sou_no").value;
    
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'return_pending_mstprc',
      mstprc_no:mstprc_no,
      fat_no:fat_no,
      sou_no:sou_no
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

const confirm_pending_mstprc = () => {
  var mstprc_no = document.getElementById("pending_mstprc_no").innerHTML;
  var setup_process = document.getElementById("pending_mstprc_setup_process").value;
  var approver = document.getElementById("pending_mstprc_approver").value;
  var fat_no = document.getElementById("pending_mstprc_fat_no").value;
  var sou_no = document.getElementById("pending_mstprc_sou_no").value;
    
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'confirm_pending_mstprc',
      mstprc_no:mstprc_no,
      setup_process:setup_process,
      approver:approver,
      fat_no:fat_no,
      sou_no:sou_no
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
          $('#PendingMachineChecksheetInfoModal').modal('hide');
        } else if (response == 'Approver Not Set') {
          swal('Machine Checksheets', 'Please set Approver', 'info');
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

$('#machineChecksheetHistoryTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_machine_checksheets_history = el => {
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

  document.getElementById("history_mstprc_no").innerHTML = mstprc_no;
  document.getElementById("history_mstprc_type").innerHTML = mstprc_type;
  document.getElementById("history_mstprc_machine_name").innerHTML = machine_name;
  document.getElementById("history_mstprc_machine_no").innerHTML = machine_no;
  document.getElementById("history_mstprc_equipment_no").innerHTML = equipment_no;
  document.getElementById("history_mstprc_car_model").value = car_model;
  document.getElementById("history_mstprc_location").value = location;
  document.getElementById("history_mstprc_grid").value = grid;
  if (grid != '') {
    document.getElementById("history_mstprc_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
  } else {
    document.getElementById("history_mstprc_line_car_model").innerHTML = `${car_model} ${location}`;
  }
  document.getElementById("history_mstprc_date").innerHTML = mstprc_date;

  document.getElementById("history_mstprc_eq_member").innerHTML = mstprc_eq_member;
  document.getElementById("history_mstprc_safety_officer").innerHTML = mstprc_safety_officer;
  document.getElementById("history_mstprc_eq_g_leader").innerHTML = mstprc_eq_g_leader;
  document.getElementById("history_mstprc_prod_engr_manager").innerHTML = mstprc_prod_engr_manager;
  document.getElementById("history_mstprc_eq_sp_personnel").innerHTML = mstprc_eq_sp_personnel;
  document.getElementById("history_mstprc_eq_manager").innerHTML = mstprc_eq_manager;

  if (mstprc_prod_supervisor != '' && mstprc_prod_manager != '') {
    document.getElementById("history_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} / ${mstprc_prod_manager}`;
  } else if (mstprc_prod_supervisor != '') {
    document.getElementById("history_mstprc_prod_supervisor_manager").innerHTML = `${mstprc_prod_supervisor} /`;
  } else if (mstprc_prod_manager != '') {
    document.getElementById("history_mstprc_prod_supervisor_manager").innerHTML = `/ ${mstprc_prod_manager}`;
  } else {
    document.getElementById("history_mstprc_prod_supervisor_manager").innerHTML = '';
  }
  document.getElementById("history_mstprc_prod_supervisor").value = mstprc_prod_supervisor;
  document.getElementById("history_mstprc_prod_manager").value = mstprc_prod_manager;
  
  if (mstprc_qa_supervisor != '' && mstprc_qa_manager != '') {
    document.getElementById("history_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} / ${mstprc_qa_manager}`;
  } else if (mstprc_qa_supervisor != '') {
    document.getElementById("history_mstprc_qa_supervisor_manager").innerHTML = `${mstprc_qa_supervisor} /`;
  } else if (mstprc_qa_manager != '') {
    document.getElementById("history_mstprc_qa_supervisor_manager").innerHTML = `/ ${mstprc_qa_manager}`;
  } else {
    document.getElementById("history_mstprc_qa_supervisor_manager").innerHTML = '';
  }
  document.getElementById("history_mstprc_qa_supervisor").value = mstprc_qa_supervisor;
  document.getElementById("history_mstprc_qa_manager").value = mstprc_qa_manager;

  if (to_car_model != '' && to_location != '') {
    document.getElementById("history_mstprc_from_car_model").value = car_model;
    document.getElementById("history_mstprc_from_location").value = location;
    document.getElementById("history_mstprc_from_grid").value = grid;
    if (grid != '') {
      document.getElementById("history_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}/${grid}`;
    } else {
      document.getElementById("history_mstprc_from_line_car_model").innerHTML = `${car_model} ${location}`;
    }
  }
  document.getElementById("history_mstprc_to_car_model").value = to_car_model;
  document.getElementById("history_mstprc_to_location").value = to_location;
  document.getElementById("history_mstprc_to_grid").value = to_grid;
  if (to_grid != '') {
    document.getElementById("history_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}/${to_grid}`;
  } else {
    document.getElementById("history_mstprc_to_line_car_model").innerHTML = `${to_car_model} ${to_location}`;
  }
  document.getElementById("history_mstprc_transfer_reason").innerHTML = transfer_reason;
  document.getElementById("history_mstprc_pullout_location").innerHTML = pullout_location;
  document.getElementById("history_mstprc_pullout_reason").innerHTML = pullout_reason;

  document.getElementById("history_mstprc_file_name").innerHTML = file_name;
  document.getElementById("history_mstprc_file_url").value = file_url;

  document.getElementById("history_mstprc_disapproved_by").innerHTML = disapproved_by;
  document.getElementById("history_mstprc_disapproved_by_role").innerHTML = disapproved_by_role;
  document.getElementById("history_mstprc_disapproved_comment").innerHTML = disapproved_comment;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'machine_checksheets_history_mark_as_read',
      mstprc_process_status:mstprc_process_status,
      mstprc_no:mstprc_no
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

const get_recent_machine_checksheets_history = () => {
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_recent_machine_checksheets_history'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("machineChecksheetHistoryData").innerHTML = response; 
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_recent_machine_checksheets_history);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const download_mstprc_history = () => {
  var file_url = document.getElementById("history_mstprc_file_url").value;
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
    url: '../process/admin/setup-machine-docs_processor.php',
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
      url: '../process/admin/setup-machine-docs_processor.php',
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

const get_machine_details = action => {
  var machine_name = '';
  if (action == 'insert') {
    var machine_name = document.getElementById("i_machine_name").value;
  } else if (action == 'update') {
    var machine_name = document.getElementById("u_machine_name").value;
  }
  if (machine_name != '' && getCookie('setup_role') == 'Admin') {
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
    url: '../process/admin/setup-machine-docs_processor.php',
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
    url: '../process/admin/setup-machine-docs_processor.php',
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
    url: '../process/admin/setup-machine-docs_processor.php',
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
