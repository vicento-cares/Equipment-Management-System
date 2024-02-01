// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('pm_role') != 'Admin') {
    document.getElementById("cardAddMachine").style.display = 'none';
    document.getElementById("cardExportMachineFormat").style.display = 'none';
    document.getElementById("cardUploadMachine").style.display = 'none';
    document.getElementById("cardMachineNameTable").style.display = 'none';

    /*document.getElementById("u_machine_name").setAttribute('disabled', true);
    document.getElementById("u_machine_spec").setAttribute('disabled', true);
    document.getElementById("u_machine_no").setAttribute('disabled', true);
    document.getElementById("u_equipment_no").setAttribute('disabled', true);*/
    document.getElementById("u_location").setAttribute('disabled', true);
    document.getElementById("u_grid").setAttribute('disabled', true);
    document.getElementById("u_car_model").setAttribute('disabled', true);
    document.getElementById("u_asset_tag_no").setAttribute('disabled', true);
    /*document.getElementById("u_trd_no").setAttribute('disabled', true);
    document.getElementById("u_ns-iv_no").setAttribute('disabled', true);*/
    document.getElementById("btnUpdateMachine").setAttribute('disabled', true);
    document.getElementById("btnUpdateMachine").style.display = 'none';
    /*document.getElementById("btnUpdateAssetTagNo").setAttribute('disabled', true);
    document.getElementById("btnUpdateAssetTagNo").style.display = 'none';*/
  } else if (getCookie('pm_role') == 'Admin' && getCookie('pm_process') == 'Initial') {
    document.getElementById("cardAddMachine").style.display = 'none';
    document.getElementById("cardExportMachineFormat").style.display = 'none';
    document.getElementById("cardUploadMachine").style.display = 'none';

    document.getElementById("btnGoAddMachine").setAttribute('disabled', true);
    document.getElementById("btnAddMachine").setAttribute('disabled', true);
    document.getElementById("btnAddMachine").style.display = 'none';

    document.getElementById("u_location").setAttribute('disabled', true);
    document.getElementById("u_grid").setAttribute('disabled', true);
    document.getElementById("u_car_model").setAttribute('disabled', true);
    document.getElementById("u_asset_tag_no").setAttribute('disabled', true);
    document.getElementById("btnUpdateMachine").setAttribute('disabled', true);
    document.getElementById("btnUpdateMachine").style.display = 'none';
    /*document.getElementById("btnUpdateAssetTagNo").setAttribute('disabled', true);
    document.getElementById("btnUpdateAssetTagNo").style.display = 'none';*/
  }

  load_data(1);
  get_car_models_datalist_search();
  get_machines_datalist_search();

  get_machines_dropdown();
  get_locations_dropdown();
  get_machines_dropdown_all();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  get_machine_names(1);
  
  load_notif_pm();
  realtime_load_notif_pm = setInterval(load_notif_pm, 5000);
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

const get_machines_dropdown_all = () => {
  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_machines_dropdown_all'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("i_export_machine_name").innerHTML = response;
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
      document.getElementById("i_search_machines").innerHTML = response;
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
      /*document.getElementById("i_location").innerHTML = response;*/
      document.getElementById("u_location").innerHTML = response;
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
      if (action == 'insert') {
        document.getElementById("i_car_models").innerHTML = response;
      } else if (action == 'update') {
        document.getElementById("u_car_models").innerHTML = response;
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
      document.getElementById("i_search_car_models").innerHTML = response;
      document.getElementById("i_export_car_models").innerHTML = response;
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
      document.getElementById("i_search_machines_no").innerHTML = response;
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
      document.getElementById("i_search_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var number = el.dataset.number;
  var setup_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var machine_spec = el.dataset.machine_spec;
  var car_model = el.dataset.car_model;
  var location = el.dataset.location;
  var grid = el.dataset.grid;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var asset_tag_no = el.dataset.asset_tag_no;
  var trd_no = el.dataset.trd_no;
  var ns_iv_no = el.dataset.ns_iv_no;
  var machine_status = el.dataset.machine_status;
  var is_new = el.dataset.is_new;

  document.getElementById("u_id").value = id;
  document.getElementById("u_number").value = number;
  document.getElementById("u_process").value = setup_process;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_machine_spec").value = machine_spec;
  document.getElementById("u_car_model").value = car_model;
  document.getElementById("u_location").value = location;
  document.getElementById("u_grid").value = grid;
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_asset_tag_no").value = asset_tag_no;
  document.getElementById("u_trd_no").value = trd_no;
  document.getElementById("u_ns-iv_no").value = ns_iv_no;
  document.getElementById("u_machine_status").value = machine_status;
  document.getElementById("u_is_new").value = is_new;
  if (is_new == 0) {
    document.getElementById("u_is_new").checked = false;
  } else if (is_new == 1) {
    document.getElementById("u_is_new").checked = true;
  }
  get_machine_details('update');
}

const count_data = () => {
  var setup_process = sessionStorage.getItem('saved_i_search_process');
  var car_model = sessionStorage.getItem('saved_i_search_car_model');
  var machine_name = sessionStorage.getItem('saved_i_search_machine_name');
  var machine_spec = sessionStorage.getItem('saved_i_search_machine_spec');
  var machine_no = sessionStorage.getItem('saved_i_search_machine_no');
  var equipment_no = sessionStorage.getItem('saved_i_search_equipment_no');

  $.ajax({
    url: '../process/admin/machine-masterlist_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_data',
      process: setup_process,
      car_model: car_model,
      machine_name: machine_name,
      machine_spec: machine_spec,
      machine_no: machine_no,
      equipment_no: equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("machineData").childNodes.length);
      let loader_count = document.getElementById("loader_count").value;
      document.getElementById("counter_view").style.display = 'none';
      let counter_view = "";
      if (total_rows != 0) {
        let counter_view_search = "";
        if (total_rows < 2) {
          counter_view_search = `${total_rows} record found`;
          counter_view = `${table_rows} row of ${total_rows} record`;
        } else {
          counter_view_search = `${total_rows} records found`;
          counter_view = `${table_rows} rows of ${total_rows} records`;
        }
        document.getElementById("counter_view_search").innerHTML = counter_view_search;
        document.getElementById("counter_view_search").style.display = 'block';
        document.getElementById("counter_view").innerHTML = counter_view;
        document.getElementById("counter_view").style.display = 'block';
      } else {
        document.getElementById("counter_view_search").style.display = 'none';
        document.getElementById("counter_view").style.display = 'none';
      }

      if (total_rows == 0) {
        document.getElementById("search_more_data").style.display = 'none';
      } else if (total_rows > loader_count) {
        document.getElementById("search_more_data").style.display = 'block';
      } else if (total_rows <= loader_count) {
        document.getElementById("search_more_data").style.display = 'none';
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const load_data = option => {
  var id = 0;
  var setup_process = '';
  var car_model = '';
  var machine_name = '';
  var machine_spec = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var setup_process = document.getElementById("i_search_process").value;
      var car_model = document.getElementById("i_search_car_model").value;
      var machine_name = document.getElementById("i_search_machine_name").value.trim();
      var machine_spec = document.getElementById("i_search_machine_spec").value.trim();
      var machine_no = document.getElementById("i_search_machine_no").value.trim();
      var equipment_no = document.getElementById("i_search_equipment_no").value.trim();
      break;
    case 2:
      var id = document.getElementById("machineData").lastChild.getAttribute("id");
      var setup_process = sessionStorage.getItem('saved_i_search_process');
      var car_model = sessionStorage.getItem('saved_i_search_car_model');
      var machine_name = sessionStorage.getItem('saved_i_search_machine_name');
      var machine_spec = sessionStorage.getItem('saved_i_search_machine_spec');
      var machine_no = sessionStorage.getItem('saved_i_search_machine_no');
      var equipment_no = sessionStorage.getItem('saved_i_search_equipment_no');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    case 3:
      var setup_process = sessionStorage.getItem('saved_i_search_process');
      var car_model = sessionStorage.getItem('saved_i_search_car_model');
      var machine_name = sessionStorage.getItem('saved_i_search_machine_name');
      var machine_spec = sessionStorage.getItem('saved_i_search_machine_spec');
      var machine_no = sessionStorage.getItem('saved_i_search_machine_no');
      var equipment_no = sessionStorage.getItem('saved_i_search_equipment_no');
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/machine-masterlist_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'fetch_data',
        id: id,
        process: setup_process,
        car_model: car_model,
        machine_name: machine_name,
        machine_spec: machine_spec,
        machine_no: machine_no,
        equipment_no: equipment_no,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("machineData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
          case 3:
            document.getElementById("machineData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('saved_i_search_process', setup_process);
            sessionStorage.setItem('saved_i_search_car_model', car_model);
            sessionStorage.setItem('saved_i_search_machine_name', machine_name);
            sessionStorage.setItem('saved_i_search_machine_spec', machine_spec);
            sessionStorage.setItem('saved_i_search_machine_no', machine_no);
            sessionStorage.setItem('saved_i_search_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("machineData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_data();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("i_search_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(1);
  }
});

document.getElementById("i_search_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(1);
  }
});

document.getElementById("i_search_machine_spec").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(1);
  }
});

document.getElementById("i_search_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(1);
  }
});

document.getElementById("i_search_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    load_data(1);
  }
});

$("#AddMachineModal").on('hidden.bs.modal', e => {
  document.getElementById("i_process").value = '';
  document.getElementById("i_machine_name").value = '';
  document.getElementById("i_machine_spec").value = '';
  document.getElementById("i_machine_no").value = '';
  document.getElementById("i_equipment_no").value = '';
  document.getElementById("i_asset_tag_no").value = '';
  document.getElementById("i_trd_no").value = '';
  document.getElementById("i_ns-iv_no").value = '';
  document.getElementById("i_trd_no").setAttribute('disabled', true);
  document.getElementById("i_ns-iv_no").setAttribute('disabled', true);
});

$("#MachineInfoModal").on('hidden.bs.modal', e => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_process").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_car_model").value = '';
  document.getElementById("u_location").value = '';
  document.getElementById("u_grid").value = '';
  document.getElementById("u_machine_spec").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_asset_tag_no").value = '';
  document.getElementById("u_trd_no").value = '';
  document.getElementById("u_ns-iv_no").value = '';
  document.getElementById("u_number").value = '';
  document.getElementById("u_machine_status").value = '';
  document.getElementById("u_is_new").value = '';
  document.getElementById("u_is_new").checked = false;
  /*document.getElementById("u_location").setAttribute('disabled', true);
  document.getElementById("u_car_model").setAttribute('disabled', true);*/
  document.getElementById("u_trd_no").setAttribute('disabled', true);
  document.getElementById("u_ns-iv_no").setAttribute('disabled', true);
});

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
          var setup_process = response_array.process;
          var trd = response_array.trd;
          var ns_iv = response_array.ns_iv;
          if (action == 'insert') {
            document.getElementById("i_process").value = setup_process;
            if (trd == 1) {
              document.getElementById("i_ns-iv_no").value = '';
              document.getElementById("i_ns-iv_no").setAttribute('disabled', true);
              document.getElementById("i_trd_no").removeAttribute('disabled');
            } else if (ns_iv == 1) {
              document.getElementById("i_trd_no").value = '';
              document.getElementById("i_trd_no").setAttribute('disabled', true);
              document.getElementById("i_ns-iv_no").removeAttribute('disabled');
            } else {
              document.getElementById("i_trd_no").value = '';
              document.getElementById("i_ns-iv_no").value = '';
              document.getElementById("i_trd_no").setAttribute('disabled', true);
              document.getElementById("i_ns-iv_no").setAttribute('disabled', true);
            }
          } else if (action == 'update') {
            get_car_models_datalist(action, setup_process);
            /*document.getElementById("u_process").value = setup_process;
            if (trd == 1) {
              document.getElementById("u_ns-iv_no").value = '';
              document.getElementById("u_ns-iv_no").setAttribute('disabled', true);
              document.getElementById("u_trd_no").removeAttribute('disabled');
            } else if (ns_iv == 1) {
              document.getElementById("u_trd_no").value = '';
              document.getElementById("u_trd_no").setAttribute('disabled', true);
              document.getElementById("u_ns-iv_no").removeAttribute('disabled');
            } else {
              document.getElementById("u_trd_no").value = '';
              document.getElementById("u_ns-iv_no").value = '';
              document.getElementById("u_trd_no").setAttribute('disabled', true);
              document.getElementById("u_ns-iv_no").setAttribute('disabled', true);
            }*/
          }
        } catch(e) {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const get_car_model_details = action => {
  var car_model = '';
  var setup_process = '';
  if (action == 'insert') {
    var car_model = document.getElementById("i_car_model").value.trim();
    var setup_process = document.getElementById("i_process").value;
  } else if (action == 'update') {
    var car_model = document.getElementById("u_car_model").value.trim();
    var setup_process = document.getElementById("u_process").value;
  }
  if (car_model != '' && setup_process == 'Final') {
    $.ajax({
      url: '../process/admin/car-models_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_car_model_details',
        car_model:car_model
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          if (action == 'insert') {
            document.getElementById("i_car_model").value = response_array.car_model;
            document.getElementById("i_location").value = response_array.location;              
          } else if (action == 'update') {
            document.getElementById("u_car_model").value = response_array.car_model;
            document.getElementById("u_location").value = response_array.location;
          }
        } catch(e) {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const save_data = () => {
  var setup_process = document.getElementById("i_process").value;
  var machine_name = document.getElementById("i_machine_name").value;
  var machine_spec = document.getElementById("i_machine_spec").value.trim();
  var machine_no = document.getElementById("i_machine_no").value.trim();
  var equipment_no = document.getElementById("i_equipment_no").value.trim();
  var asset_tag_no = document.getElementById("i_asset_tag_no").value.trim();
  var trd_no = document.getElementById("i_trd_no").value.trim();
  var ns_iv_no = document.getElementById("i_ns-iv_no").value.trim();

  $.ajax({
    url: '../process/admin/machine-masterlist_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      process:setup_process,
      machine_name:machine_name,
      machine_spec:machine_spec,
      machine_no:machine_no,
      equipment_no:equipment_no,
      asset_tag_no:asset_tag_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Masterlist', 'Loading please wait...', {
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
          swal('Machine Masterlist', 'Successfully Saved', 'success');
          load_data(1);
          $('#AddMachineModal').modal('hide');
        } else if (response == 'Machine Name Not Set') {
          swal('Machine Masterlist', 'Please set Machine Name', 'info');
        } else if (response == 'Machine Indentification Empty') {
          swal('Machine Masterlist', 'Cannot add machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'error');
        } else if (response == 'TRD No. Empty') {
          swal('Machine Masterlist', 'Please fill out TRD No.', 'info');
        } else if (response == 'NS-IV No. Empty') {
          swal('Machine Masterlist', 'Please fill out NS-IV No.', 'info');
        } else if (response == 'Machine No. Exists') {
          swal('Machine Masterlist', 'Add new machine failed. Machine No. Exists', 'error');
        } else if (response == 'Equipment No. Exists') {
          swal('Machine Masterlist', 'Add new machine failed. Equipment No. Exists', 'error');
        } else if (response == 'TRD No. Exists') {
          swal('Machine Masterlist', 'Add new machine failed. TRD No. Exists', 'error');
        } else if (response == 'NS-IV No. Exists') {
          swal('Machine Masterlist', 'Add new machine failed. NS-IV No. Exists', 'error');
        } else {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_data = () => {
  var id = document.getElementById("u_id").value.trim();
  var setup_process = document.getElementById("u_process").value;
  /*var machine_name = document.getElementById("u_machine_name").value;*/
  var car_model = document.getElementById("u_car_model").value.trim();
  var location = document.getElementById("u_location").value;
  var grid = document.getElementById("u_grid").value;
  /*var machine_spec = document.getElementById("u_machine_spec").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();*/
  var asset_tag_no = document.getElementById("u_asset_tag_no").value.trim();
  /*var trd_no = document.getElementById("u_trd_no").value.trim();
  var ns_iv_no = document.getElementById("u_ns-iv_no").value.trim();*/

  $.ajax({
    url: '../process/admin/machine-masterlist_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_data',
      id:id,
      process:setup_process,
      car_model:car_model,
      location:location,
      grid:grid,
      asset_tag_no:asset_tag_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Masterlist', 'Loading please wait...', {
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
          swal('Machine Masterlist', 'Successfully Updated', 'success');
          load_data(1);
          $('#MachineInfoModal').modal('hide');
        } else if (response == 'Machine Name Not Set') {
          swal('Machine Masterlist', 'Please set Machine Name', 'info');
        } else if (response == 'Car Model Empty') {
          swal('Machine Masterlist', 'Please fill out Car Model', 'info');
        } else if (response == 'Car Model Doesn\'t Exists') {
          swal('Machine Masterlist', `Cannot add machine. Car Model Doesn't Exists!`, 'error');
        } else if (response == 'Location Not Set') {
          swal('Machine Masterlist', 'Please set Location', 'info');
        } else if (response == 'Machine Indentification Empty') {
          swal('Machine Masterlist', 'Cannot add machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'error');
        } else if (response == 'TRD No. Empty') {
          swal('Machine Masterlist', 'Please fill out TRD No.', 'info');
        } else if (response == 'NS-IV No. Empty') {
          swal('Machine Masterlist', 'Please fill out NS-IV No.', 'info');
        } else {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_asset_tag_no = () => {
  var id = document.getElementById("u_id").value.trim();
  var asset_tag_no = document.getElementById("u_asset_tag_no").value.trim();

  $.ajax({
    url: '../process/admin/machine-masterlist_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_asset_tag_no',
      id:id,
      asset_tag_no:asset_tag_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machine Masterlist', 'Loading please wait...', {
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
          swal('Machine Masterlist', 'Successfully Updated', 'success');
          load_data(1);
          $('#MachineInfoModal').modal('hide');
        } else {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$("#ExportMachineModal").on('hidden.bs.modal', e => {
  document.getElementById("i_export_process").value = 'All';
  document.getElementById("i_export_machine_name").value = 'All';
  document.getElementById("i_export_car_model").value = '';
});

const export_masterlist = () => {
  var setup_process = document.getElementById("i_export_process").value;
  var machine_name = document.getElementById("i_export_machine_name").value;
  var car_model = document.getElementById("i_export_car_model").value.trim();
  window.open('../process/export/export_machine_masterlist.php?machine_name='+machine_name+'&process='+setup_process+'&car_model='+car_model,'_blank');
  $("#ExportMachineModal").modal("hide");
}

const export_masterlist_format = () => {
  window.open('../process/export/export_machine_masterlist_format.php','_blank');
}

const export_machine_names = () => {
  window.open('../process/export/export_machine_names.php','_blank');
}

const export_locations = () => {
  window.open('../process/export/export_locations.php','_blank');
}

const export_car_models = () => {
  window.open('../process/export/export_car_models.php','_blank');
}

$("#UploadMachineMasterlistCsvModal").on('hidden.bs.modal', e => {
  document.getElementById('machine_masterlist_file').value = '';
});

const upload_machine_masterlist_csv = () => {
  var form_data = new FormData();
  var ins = document.getElementById('machine_masterlist_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('machine_masterlist_file').files[x]);
  }
  $.ajax({
    url: '../process/import/import_machine_masterlist.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    beforeSend: (jqXHR, settings) => {
      swal('Upload CSV', 'Loading please wait...', {
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
          swal('Upload CSV', `Error: ${response}`, 'error');
        } else {
          swal('Upload CSV', 'Uploaded and updated successfully', 'success');
          load_data(1);
          $('#UploadMachineMasterlistCsvModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$("#UploadOldMachineMasterlistCsvModal").on('hidden.bs.modal', e => {
  document.getElementById('old_machine_masterlist_file').value = '';
});

const upload_old_machine_masterlist_csv = () => {
  var form_data = new FormData();
  var ins = document.getElementById('old_machine_masterlist_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('old_machine_masterlist_file').files[x]);
  }
  $.ajax({
    url: '../process/import/import_old_machine_masterlist.php',
    type: 'POST',
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    beforeSend: (jqXHR, settings) => {
      swal('Upload CSV', 'Loading please wait...', {
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
          swal('Upload CSV', `Error: ${response}`, 'error');
        } else {
          swal('Upload CSV', 'Uploaded and updated successfully', 'success');
          load_data(1);
          $('#UploadOldMachineMasterlistCsvModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_machine_names = () => {
  var setup_process = sessionStorage.getItem('saved_i_search_process2');
  var machine_name = sessionStorage.getItem('saved_i_search_machine_name2');

  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_data',
      process: setup_process,
      machine_name: machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("machineNameData").childNodes.length);
      let loader_count2 = document.getElementById("loader_count2").value;
      document.getElementById("counter_view2").style.display = 'none';
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

const get_machine_names = option => {
  var id = 0;
  var setup_process = '';
  var machine_name = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var setup_process = document.getElementById("i_search_process2").value;
      var machine_name = document.getElementById("i_search_machine_name2").value.trim();
      break;
    case 2:
      var id = document.getElementById("machineNameData").lastChild.getAttribute("id");
      var setup_process = sessionStorage.getItem('saved_i_search_process2');
      var machine_name = sessionStorage.getItem('saved_i_search_machine_name2');
      var loader_count2 = parseInt(document.getElementById("loader_count2").value);
      break;
    case 3:
      var setup_process = sessionStorage.getItem('saved_i_search_process2');
      var machine_name = sessionStorage.getItem('saved_i_search_machine_name2');
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/machines_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'fetch_data',
        id: id,
        process: setup_process,
        machine_name: machine_name,
        c: loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="4" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("machineNameData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
          case 3:
            document.getElementById("machineNameData").innerHTML = response;
            document.getElementById("loader_count2").value = 25;
            sessionStorage.setItem('saved_i_search_process2', setup_process);
            sessionStorage.setItem('saved_i_search_machine_name2', machine_name);
            break;
          case 2:
            document.getElementById("machineNameData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count2").value = loader_count2 + 25;
            break;
          default:
        }
        count_machine_names();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("i_search_machine_name2").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_names(1);
  }
});

$("#AddMachineNameModal").on('hidden.bs.modal', e => {
  document.getElementById("i_process2").value = '';
  document.getElementById("i_machine_name2").value = '';
});

const save_machine_name = () => {
  var setup_process = document.getElementById("i_process2").value;
  var machine_name = document.getElementById("i_machine_name2").value;

  $.ajax({
    url: '../process/admin/machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_data',
      process:setup_process,
      machine_name:machine_name
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Machines', 'Loading please wait...', {
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
          swal('Machines', 'Successfully Saved', 'success');
          get_machine_names(1);
          $('#AddMachineNameModal').modal('hide');
        } else if (response == 'Process Not Set') {
          swal('Machines', 'Please set Process', 'info');
        } else if (response == 'Machine Name Empty') {
          swal('Machines', 'Please fill out Machine Name', 'info');
        } else if (response == 'Machine Name Exists') {
          swal('Machines', 'Add new machine name failed. Machine Name Exists', 'error');
        } else {
          console.log(response);
          swal('Machine Masterlist Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
