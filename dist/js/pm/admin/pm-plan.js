// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('pm_role') != 'Admin') {
    document.getElementById("cardAddSinglePmPlan").style.display = 'none';
    document.getElementById("cardExportPmPlanFormat").style.display = 'none';
    document.getElementById("cardUploadPmPlan").style.display = 'none';

    document.getElementById("u_machine_no").setAttribute('disabled', true);
    document.getElementById("u_equipment_no").setAttribute('disabled', true);
    document.getElementById("u_pm_plan_year").setAttribute('disabled', true);
    document.getElementById("u_ww_no").setAttribute('disabled', true);
    document.getElementById("u_frequency").setAttribute('disabled', true);
    document.getElementById("u_ww_start_date").setAttribute('disabled', true);
    document.getElementById("u_machine_status").setAttribute('disabled', true);
    document.getElementById("btnUpdateSinglePmPlan").setAttribute('disabled', true);
    document.getElementById("btnUpdateSinglePmPlan").style.display = 'none';
  }

  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_pm_plan_years_datalist_search();
  get_all_ww_no_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  
  load_notif_pm();
  realtime_load_notif_pm = setInterval(load_notif_pm, 5000);
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
      document.getElementById("search_car_models").innerHTML = response;
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
      document.getElementById("search_machines").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_pm_plan_years_datalist_search = () => {
  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_pm_plan_years_datalist_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("search_pm_plan_years").innerHTML = response;
      document.getElementById("export_pm_plan_years").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_all_ww_no_datalist_search = () => {
  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_all_ww_no_datalist_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("search_all_ww_no").innerHTML = response;
      document.getElementById("export_all_ww_no").innerHTML = response;
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
      document.getElementById("search_machines_no").innerHTML = response;
      document.getElementById("i_machines_no").innerHTML = response;
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
      document.getElementById("search_equipments_no").innerHTML = response;
      document.getElementById("i_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var pm_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var machine_spec = el.dataset.machine_spec;
  var car_model = el.dataset.car_model;
  var location = el.dataset.location;
  var grid = el.dataset.grid;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var trd_no = el.dataset.trd_no;
  var ns_iv_no = el.dataset.ns_iv_no;
  var pm_plan_year = el.dataset.pm_plan_year;
  var ww_no = el.dataset.ww_no;
  var frequency = el.dataset.frequency;
  var ww_start_date = el.dataset.ww_start_date;
  var machine_status = el.dataset.machine_status;
  var pm_status = el.dataset.pm_status;
  var internal_comment = el.dataset.internal_comment;

  document.getElementById("u_id").value = id;
  document.getElementById("u_process").value = pm_process;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_machine_spec").value = machine_spec;
  document.getElementById("u_car_model").value = car_model;
  document.getElementById("u_location").value = location;
  document.getElementById("u_grid").value = grid;
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_trd_no").value = trd_no;
  document.getElementById("u_ns-iv_no").value = ns_iv_no;
  document.getElementById("u_pm_plan_year").value = pm_plan_year;
  document.getElementById("u_ww_no").value = ww_no;
  document.getElementById("u_frequency").value = frequency;
  document.getElementById("u_ww_start_date").value = ww_start_date;
  document.getElementById("u_machine_status").value = machine_status;
  document.getElementById("u_pm_status").value = pm_status;
  document.getElementById("u_internal_comment").value = internal_comment;
}

$("#SinglePmPlanInfoModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("u_internal_comment").getAttribute("maxlength");
    var comment_length = document.getElementById("u_internal_comment").value.length;
    var u_internal_comment_count = `${comment_length} / ${max_length}`;
    document.getElementById("u_internal_comment_count").innerHTML = u_internal_comment_count;
  }, 100);
});

const count_internal_comment_char = () => {
  var max_length = document.getElementById("u_internal_comment").getAttribute("maxlength");
  var comment_length = document.getElementById("u_internal_comment").value.length;
  var u_internal_comment_count = `${comment_length} / ${max_length}`;
  document.getElementById("u_internal_comment_count").innerHTML = u_internal_comment_count;
}

const count_pm_plan = () => {
  var i_search_pm_plan_year = sessionStorage.getItem('search_pm_plan_year');
  var i_search_ww_no = sessionStorage.getItem('search_ww_no');
  var i_search_car_model = sessionStorage.getItem('search_car_model');
  var i_search_machine_name = sessionStorage.getItem('search_machine_name');
  var i_search_machine_no = sessionStorage.getItem('search_machine_no');
  var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
  var i_search_machine_spec = sessionStorage.getItem('search_machine_spec');
  
  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pm_plan',
      pm_plan_year: i_search_pm_plan_year,
      ww_no: i_search_ww_no,
      car_model: i_search_car_model,
      machine_name: i_search_machine_name,
      machine_no: i_search_machine_no,
      equipment_no: i_search_equipment_no,
      machine_spec: i_search_machine_spec
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmPlanData").childNodes.length);
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

const get_pm_plan = option => {
  var id = 0;
  var i_search_pm_plan_year = '';
  var i_search_ww_no = '';
  var i_search_car_model = '';
  var i_search_machine_name = '';
  var i_search_machine_no = '';
  var i_search_equipment_no = '';
  var i_search_machine_spec = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var i_search_pm_plan_year = document.getElementById("search_pm_plan_year").value.trim();
      var i_search_ww_no = document.getElementById("search_ww_no").value.trim();
      var i_search_car_model = document.getElementById("search_car_model").value.trim();
      var i_search_machine_name = document.getElementById("search_machine_name").value.trim();
      var i_search_machine_no = document.getElementById("search_machine_no").value.trim();
      var i_search_equipment_no = document.getElementById("search_equipment_no").value.trim();
      var i_search_machine_spec = document.getElementById("search_machine_spec").value.trim();
      if (i_search_pm_plan_year == '') {
        var continue_loading = false;
        swal('PM Plan', 'Fill out PM Plan Year input field', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("pmPlanData").lastChild.getAttribute("id");
      var i_search_pm_plan_year = sessionStorage.getItem('search_pm_plan_year');
      var i_search_ww_no = sessionStorage.getItem('search_ww_no');
      var i_search_car_model = sessionStorage.getItem('search_car_model');
      var i_search_machine_name = sessionStorage.getItem('search_machine_name');
      var i_search_machine_no = sessionStorage.getItem('search_machine_no');
      var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
      var i_search_machine_spec = sessionStorage.getItem('search_machine_spec');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/pm-plan_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_pm_plan',
        id: id,
        pm_plan_year: i_search_pm_plan_year,
        ww_no: i_search_ww_no,
        car_model: i_search_car_model,
        machine_name: i_search_machine_name,
        machine_no: i_search_machine_no,
        equipment_no: i_search_equipment_no,
        machine_spec: i_search_machine_spec,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="16" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("pmPlanData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("pmPlanData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('search_pm_plan_year', i_search_pm_plan_year);
            sessionStorage.setItem('search_ww_no', i_search_ww_no);
            sessionStorage.setItem('search_car_model', i_search_car_model);
            sessionStorage.setItem('search_machine_name', i_search_machine_name);
            sessionStorage.setItem('search_machine_no', i_search_machine_no);
            sessionStorage.setItem('search_equipment_no', i_search_equipment_no);
            sessionStorage.setItem('search_machine_spec', i_search_machine_spec);
            break;
          case 2:
            document.getElementById("pmPlanData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_pm_plan();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("search_pm_plan_year").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_ww_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

document.getElementById("search_machine_spec").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_plan(1);
  }
});

$("#AddSinglePmPlanModal").on('hidden.bs.modal', e => {
  document.getElementById("i_machine_no").value = '';
  document.getElementById("i_equipment_no").value = '';
  document.getElementById("i_trd_no").value = '';
  document.getElementById("i_ns-iv_no").value = '';
  document.getElementById("i_machine_name").value = '';
  document.getElementById("i_machine_spec").value = '';
  document.getElementById("i_process").value = '';
  document.getElementById("i_location").value = '';
  document.getElementById("i_grid").value = '';
  document.getElementById("i_car_model").value = '';
  document.getElementById("i_pm_plan_year").value = '';
  document.getElementById("i_ww_no").value = '';
  document.getElementById("i_frequency").value = '';
  document.getElementById("i_ww_start_date").value = '';
});

const clear_single_pm_plan_info_fields = () => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_trd_no").value = '';
  document.getElementById("u_ns-iv_no").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_machine_spec").value = '';
  document.getElementById("u_process").value = '';
  document.getElementById("u_location").value = '';
  document.getElementById("u_grid").value = '';
  document.getElementById("u_car_model").value = '';
  document.getElementById("u_pm_plan_year").value = '';
  document.getElementById("u_ww_no").value = '';
  document.getElementById("u_frequency").value = '';
  document.getElementById("u_ww_start_date").value = '';
  document.getElementById("u_machine_status").value = '';
  document.getElementById("u_pm_status").value = '';
}

document.getElementById("i_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('insert');
  } else {
    document.getElementById("i_equipment_no").value = '';
    document.getElementById("i_trd_no").value = '';
    document.getElementById("i_ns-iv_no").value = '';
    document.getElementById("i_machine_name").value = '';
    document.getElementById("i_machine_spec").value = '';
    document.getElementById("i_process").value = '';
    document.getElementById("i_location").value = '';
    document.getElementById("i_grid").value = '';
    document.getElementById("i_car_model").value = '';
  }
});

document.getElementById("i_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('insert');
  } else {
    document.getElementById("i_machine_no").value = '';
    document.getElementById("i_trd_no").value = '';
    document.getElementById("i_ns-iv_no").value = '';
    document.getElementById("i_machine_name").value = '';
    document.getElementById("i_machine_spec").value = '';
    document.getElementById("i_process").value = '';
    document.getElementById("i_location").value = '';
    document.getElementById("i_grid").value = '';
    document.getElementById("i_car_model").value = '';
  }
});

document.getElementById("u_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('update');
  } else {
    document.getElementById("u_equipment_no").value = '';
    document.getElementById("u_trd_no").value = '';
    document.getElementById("u_ns-iv_no").value = '';
    document.getElementById("u_machine_name").value = '';
    document.getElementById("u_machine_spec").value = '';
    document.getElementById("u_process").value = '';
    document.getElementById("u_location").value = '';
    document.getElementById("u_grid").value = '';
    document.getElementById("u_car_model").value = '';
  }
});

document.getElementById("u_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('update');
  } else {
    document.getElementById("u_machine_no").value = '';
    document.getElementById("u_trd_no").value = '';
    document.getElementById("u_ns-iv_no").value = '';
    document.getElementById("u_machine_name").value = '';
    document.getElementById("u_machine_spec").value = '';
    document.getElementById("u_process").value = '';
    document.getElementById("u_location").value = '';
    document.getElementById("u_grid").value = '';
    document.getElementById("u_car_model").value = '';
  }
});

const get_machine_details_by_id = action => {
  var machine_no = '';
  var equipment_no = '';
  if (action == 'insert') {
    var machine_no = document.getElementById("i_machine_no").value.trim();
    var equipment_no = document.getElementById("i_equipment_no").value.trim();
  } else if (action == 'update') {
    var machine_no = document.getElementById("u_machine_no").value.trim();
    var equipment_no = document.getElementById("u_equipment_no").value.trim();
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
          var pm_process = response_array.process;
          var machine_name = response_array.machine_name;
          var machine_spec = response_array.machine_spec;
          var car_model = response_array.car_model;
          var location = response_array.location;
          var grid = response_array.grid;
          var machine_no = response_array.machine_no;
          var equipment_no = response_array.equipment_no;
          var trd_no = response_array.trd_no;
          var ns_iv_no = response_array.ns_iv_no;
          var machine_status = response_array.machine_status;
          var registered = response_array.registered;

          if (registered == true) {
            if (action == 'insert') {
              document.getElementById("i_machine_no").value = machine_no;
              document.getElementById("i_equipment_no").value = equipment_no;
              document.getElementById("i_trd_no").value = trd_no;
              document.getElementById("i_ns-iv_no").value = ns_iv_no;
              document.getElementById("i_machine_name").value = machine_name;
              document.getElementById("i_machine_spec").value = machine_spec;
              document.getElementById("i_process").value = pm_process;
              document.getElementById("i_location").value = location;
              document.getElementById("i_grid").value = grid;
              document.getElementById("i_car_model").value = car_model;
            } else if (action == 'update') {
              document.getElementById("u_machine_no").value = machine_no;
              document.getElementById("u_equipment_no").value = equipment_no;
              document.getElementById("u_trd_no").value = trd_no;
              document.getElementById("u_ns-iv_no").value = ns_iv_no;
              document.getElementById("u_machine_name").value = machine_name;
              document.getElementById("u_machine_spec").value = machine_spec;
              document.getElementById("u_process").value = pm_process;
              document.getElementById("u_location").value = location;
              document.getElementById("u_grid").value = grid;
              document.getElementById("u_car_model").value = car_model;
              document.getElementById("u_machine_status").value = machine_status;
            }
          } else {
            swal('PM Plan Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
          }
        } catch(e) {
          console.log(response);
          swal('PM Plan Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const save_single_pm_plan = () => {
  var machine_no = document.getElementById("i_machine_no").value.trim();
  var equipment_no = document.getElementById("i_equipment_no").value.trim();
  var trd_no = document.getElementById("i_trd_no").value.trim();
  var ns_iv_no = document.getElementById("i_ns-iv_no").value.trim();
  var machine_name = document.getElementById("i_machine_name").value.trim();
  var machine_spec = document.getElementById("i_machine_spec").value.trim();
  var pm_process = document.getElementById("i_process").value.trim();
  var location = document.getElementById("i_location").value.trim();
  var grid = document.getElementById("i_grid").value.trim();
  var car_model = document.getElementById("i_car_model").value.trim();
  var pm_plan_year = document.getElementById("i_pm_plan_year").value.trim();
  var ww_no = document.getElementById("i_ww_no").value.trim();
  var frequency = document.getElementById("i_frequency").value;
  var ww_start_date = document.getElementById("i_ww_start_date").value;

  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_single_pm_plan',
      machine_no:machine_no,
      equipment_no:equipment_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      machine_name:machine_name,
      machine_spec:machine_spec,
      process:pm_process,
      location:location,
      grid:grid,
      car_model:car_model,
      pm_plan_year:pm_plan_year,
      ww_no:ww_no,
      frequency:frequency,
      ww_start_date:ww_start_date
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('PM Plan', 'Loading please wait...', {
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
          swal('PM Plan', 'Successfully Saved', 'success');
          $('#AddSinglePmPlanModal').modal('hide');
          get_pm_plan_years_datalist_search();
          get_all_ww_no_datalist_search();
        } else if (response == 'Machine Indentification Empty') {
          swal('PM Plan', 'Cannot add pm plan without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
        } else if (response == 'Forgotten Enter Key') {
          swal('PM Plan', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
        } else if (response == 'Unregistered Machine') {
          swal('PM Plan Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
        } else if (response == 'PM Plan Year Empty') {
          swal('PM Plan', 'Please fill out PM Plan Year', 'info');
        } else if (response == 'WW No. Empty') {
          swal('PM Plan', 'Please fill out Work Week No.', 'info');
        } else if (response == 'Frequency Not Set') {
          swal('PM Plan', 'Please set frequency', 'info');
        } else if (response == 'WW Start Date Not Set') {
          swal('PM Plan', 'Please set work week start date', 'info');
        } else if (response == 'Username Exists') {
          swal('PM Plan', 'Username Exists', 'info');
        } else {
          console.log(response);
          swal('PM Plan Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_single_pm_plan = () => {
  var id = document.getElementById("u_id").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();
  var trd_no = document.getElementById("u_trd_no").value.trim();
  var ns_iv_no = document.getElementById("u_ns-iv_no").value.trim();
  var machine_name = document.getElementById("u_machine_name").value.trim();
  var machine_spec = document.getElementById("u_machine_spec").value.trim();
  var pm_process = document.getElementById("u_process").value.trim();
  var location = document.getElementById("u_location").value.trim();
  var grid = document.getElementById("u_grid").value.trim();
  var car_model = document.getElementById("u_car_model").value.trim();
  var pm_plan_year = document.getElementById("u_pm_plan_year").value.trim();
  var ww_no = document.getElementById("u_ww_no").value.trim();
  var frequency = document.getElementById("u_frequency").value;
  var ww_start_date = document.getElementById("u_ww_start_date").value;
  var machine_status = document.getElementById("u_machine_status").value;
  var internal_comment = document.getElementById("u_internal_comment").value;

  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_single_pm_plan',
      id:id,
      machine_no:machine_no,
      equipment_no:equipment_no,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      machine_name:machine_name,
      machine_spec:machine_spec,
      process:pm_process,
      location:location,
      grid:grid,
      car_model:car_model,
      pm_plan_year:pm_plan_year,
      ww_no:ww_no,
      frequency:frequency,
      ww_start_date:ww_start_date,
      machine_status:machine_status,
      internal_comment:internal_comment
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('PM Plan', 'Loading please wait...', {
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
          swal('PM Plan', 'Successfully Saved', 'success');
          clear_single_pm_plan_info_fields();
          $('#SinglePmPlanInfoModal').modal('hide');
          get_pm_plan_years_datalist_search();
          get_all_ww_no_datalist_search();
          get_pm_plan(1);
        } else if (response == 'Machine Indentification Empty') {
          swal('PM Plan', 'Cannot add pm plan without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
        } else if (response == 'Forgotten Enter Key') {
          swal('PM Plan', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
        } else if (response == 'Unregistered Machine') {
          swal('PM Plan Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
        } else if (response == 'PM Plan Year Empty') {
          swal('PM Plan', 'Please fill out PM Plan Year', 'info');
        } else if (response == 'WW No. Empty') {
          swal('PM Plan', 'Please fill out Work Week No.', 'info');
        } else if (response == 'Frequency Not Set') {
          swal('PM Plan', 'Please set frequency', 'info');
        } else if (response == 'WW Start Date Not Set') {
          swal('PM Plan', 'Please set work week start date', 'info');
        } else if (response == 'Username Exists') {
          swal('PM Plan', 'Username Exists', 'info');
        } else {
          console.log(response);
          swal('PM Plan Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const delete_single_pm_plan = () => {
  var id = document.getElementById("u_id").value.trim();

  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_single_pm_plan',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('PM Plan', 'Loading please wait...', {
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
          swal('PM Plan', 'Data Deleted', 'info');
          clear_single_pm_plan_info_fields();
          get_pm_plan(1);
          $('#deleteDataModal').modal('hide');
        } else {
          console.log(response);
          swal('PM Plan Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$("#ExportPmPlanModal").on('hidden.bs.modal', e => {
  document.getElementById("export_pm_plan_year").value = '';
  document.getElementById("export_ww_no").value = '';
});

const export_pm_plan = () => {
  var pm_plan_year = document.getElementById("export_pm_plan_year").value;
  var ww_no = document.getElementById("export_ww_no").value;
  if (pm_plan_year != '') {
    window.open('../process/export/export_pm_plan.php?pm_plan_year='+pm_plan_year+'&ww_no='+ww_no,'_blank');
    $("#ExportPmPlanModal").modal("hide");
  } else {
    swal('Export PM Plan', 'Fill out PM Plan Year input field', 'info');
  }
}

const export_pm_plan_format = () => {
  window.open('../process/export/export_pm_plan_format.php','_blank');
}

const upload_pm_plan_csv = () => {
  var form_data = new FormData();
  var ins = document.getElementById('pm_plan_file').files.length;
  for (var x = 0; x < ins; x++) {
    form_data.append("file", document.getElementById('pm_plan_file').files[x]);
  }
  $.ajax({
    url: '../process/import/import_pm_plan.php',
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
          get_pm_plan_years_datalist_search();
          get_all_ww_no_datalist_search();
          $('#UploadPmPlanCsvModal').modal('hide');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
