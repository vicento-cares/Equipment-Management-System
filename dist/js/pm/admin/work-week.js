// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('pm_role') != 'Admin') {
    document.getElementById("search_manpower").setAttribute('disabled', true);
    
    document.getElementById("u_sched_start_date_time").removeAttribute('disabled');
    document.getElementById("u_sched_end_date_time").removeAttribute('disabled');
    document.getElementById("u_manpower").setAttribute('disabled', true);
    document.getElementById("btnUpdateWWContent").removeAttribute('disabled');
    document.getElementById("btnUpdateWWContent").style.display = 'block';
    document.getElementById("btnSetAsDoneWW").removeAttribute('disabled');
    document.getElementById("btnSetAsDoneWW").style.display = 'block';
    document.getElementById("btnConfirmAsDoneWW").setAttribute('disabled', true);
    document.getElementById("btnConfirmAsDoneWW").style.display = 'none';
  } else if (getCookie('pm_role') == 'Admin') {
    document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
    document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
    document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
    document.getElementById("btnUpdateWWContent").style.display = 'none';
  }
  
  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_pm_plan_years_datalist_search();
  get_all_ww_no_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  get_manpower_dropdown_search();
  get_accounts_pm_dropdown();

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
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_manpower_dropdown_search = () => {
  $.ajax({
    url: '../process/admin/work-week_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fetch_manpower_dropdown_search'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("search_manpowers").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_accounts_pm_dropdown = () => {
  $.ajax({
    url: '../process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_accounts_pm_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("u_manpower").innerHTML = response;
      document.getElementById("u_manpower_update").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const check_ww_opt = () => {
  let search_ww_opt = document.getElementsByName('search_ww_opt');
  if (search_ww_opt[0].checked) {
    document.getElementById("search_ww_no").removeAttribute('disabled');
    document.getElementById("search_ww_start_date_from").setAttribute('disabled', true);
    document.getElementById("search_ww_start_date_to").setAttribute('disabled', true);
  } else if (search_ww_opt[1].checked) {
    document.getElementById("search_ww_no").setAttribute('disabled', true);
    document.getElementById("search_ww_start_date_from").removeAttribute('disabled');
    document.getElementById("search_ww_start_date_to").removeAttribute('disabled');
  }
}

const get_details = el => {
  var id = el.dataset.id;
  var pm_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var car_model = el.dataset.car_model;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var pm_plan_year = el.dataset.pm_plan_year;
  var ww_no = el.dataset.ww_no;
  var frequency = el.dataset.frequency;
  var manpower = el.dataset.manpower;
  var ww_start_date = el.dataset.ww_start_date;
  var sched_start_date_time = el.dataset.sched_start_date_time;
  var sched_end_date_time = el.dataset.sched_end_date_time;
  var pm_status = el.dataset.pm_status;
  var machine_status = el.dataset.machine_status;

  document.getElementById("u_id").value = id;
  document.getElementById("u_process").value = pm_process;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_car_model").value = car_model;
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_pm_plan_year").value = pm_plan_year;
  document.getElementById("u_ww_no").value = ww_no;
  document.getElementById("u_frequency").value = frequency;
  document.getElementById("u_manpower").value = manpower;
  document.getElementById("u_ww_start_date").value = ww_start_date;
  document.getElementById("u_sched_start_date_time").value = sched_start_date_time;
  document.getElementById("u_sched_end_date_time").value = sched_end_date_time;
  document.getElementById("u_pm_status").value = pm_status;
  document.getElementById("u_machine_status").value = machine_status;

  if (manpower != '' && sched_start_date_time != '' && sched_end_date_time != '') {
    if (getCookie('pm_role') != 'Admin') {
      switch (pm_status) {
        case '':
          document.getElementById("u_sched_start_date_time").removeAttribute('disabled');
          document.getElementById("u_sched_end_date_time").removeAttribute('disabled');
          document.getElementById("btnUpdateWWContent").removeAttribute('disabled');
          document.getElementById("btnUpdateWWContent").style.display = 'block';
          document.getElementById("btnSetAsDoneWW").removeAttribute('disabled');
          document.getElementById("btnSetAsDoneWW").style.display = 'block';
          break;
        case 'Waiting For Confirmation':
        case 'Done':
          document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
          document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").style.display = 'none';
          document.getElementById("btnSetAsDoneWW").setAttribute('disabled', true);
          document.getElementById("btnSetAsDoneWW").style.display = 'none';
          break;
        default:
      }
    } else {
      switch (pm_status) {
        case '':
          document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
          document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
          document.getElementById("u_manpower").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").style.display = 'none';
          document.getElementById("btnConfirmAsDoneWW").setAttribute('disabled', true);
          document.getElementById("btnConfirmAsDoneWW").style.display = 'none';
          break;
        case 'Done':
          document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
          document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
          document.getElementById("u_manpower").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").style.display = 'none';
          document.getElementById("btnConfirmAsDoneWW").setAttribute('disabled', true);
          document.getElementById("btnConfirmAsDoneWW").style.display = 'none';
          break;
        case 'Waiting For Confirmation':
          document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
          document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
          document.getElementById("u_manpower").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
          document.getElementById("btnUpdateWWContent").style.display = 'none';
          document.getElementById("btnConfirmAsDoneWW").removeAttribute('disabled');
          document.getElementById("btnConfirmAsDoneWW").style.display = 'block';
          break;
        default:
      }
    }
  } else {
    if (getCookie('pm_role') == 'Admin') {
      document.getElementById("u_sched_start_date_time").setAttribute('disabled', true);
      document.getElementById("u_sched_end_date_time").setAttribute('disabled', true);
      document.getElementById("u_manpower").setAttribute('disabled', true);
      document.getElementById("btnUpdateWWContent").setAttribute('disabled', true);
      document.getElementById("btnUpdateWWContent").style.display = 'none';
    }
    document.getElementById("btnSetAsDoneWW").setAttribute('disabled', true);
    document.getElementById("btnSetAsDoneWW").style.display = 'none';
    document.getElementById("btnConfirmAsDoneWW").setAttribute('disabled', true);
    document.getElementById("btnConfirmAsDoneWW").style.display = 'none';
  }
}

const count_ww = () => {
  var i_search_pm_plan_year = sessionStorage.getItem('search_pm_plan_year');
  var search_ww_opt = sessionStorage.getItem('search_ww_opt');
  var i_search_ww_no = '';
  var i_search_ww_start_date_from = '';
  var i_search_ww_start_date_to = '';
  if (search_ww_opt == 1) {
    var i_search_ww_no = sessionStorage.getItem('search_ww_no');
  } else if (search_ww_opt == 2) {
    var i_search_ww_start_date_from = sessionStorage.getItem('search_ww_start_date_from');
    var i_search_ww_start_date_to = sessionStorage.getItem('search_ww_start_date_to');
  }
  var i_search_car_model = sessionStorage.getItem('search_car_model');
  var i_search_machine_name = sessionStorage.getItem('search_machine_name');
  var i_search_machine_no = sessionStorage.getItem('search_machine_no');
  var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
  var i_search_manpower = sessionStorage.getItem('search_manpower');
  
  $.ajax({
    url: '../process/admin/work-week_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_ww',
      pm_plan_year: i_search_pm_plan_year,
      ww_opt: search_ww_opt,
      ww_no: i_search_ww_no,
      ww_start_date_from: i_search_ww_start_date_from,
      ww_start_date_to: i_search_ww_start_date_to,
      car_model: i_search_car_model,
      machine_name: i_search_machine_name,
      machine_no: i_search_machine_no,
      equipment_no: i_search_equipment_no,
      manpower: i_search_manpower
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("workWeekData").childNodes.length);
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

const get_ww = option => {
  var id = 0;
  var i_search_pm_plan_year = '';
  var i_search_ww_opt = '';
  var i_search_ww_no = '';
  var i_search_ww_start_date_from = '';
  var i_search_ww_start_date_to = '';
  var i_search_car_model = '';
  var i_search_machine_name = '';
  var i_search_machine_no = '';
  var i_search_equipment_no = '';
  var i_search_manpower = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var i_search_pm_plan_year = document.getElementById("search_pm_plan_year").value.trim();
      var search_ww_opt = document.getElementsByName('search_ww_opt');
      if (search_ww_opt[0].checked) {
        var i_search_ww_opt = document.getElementById('search_ww_opt_by_ww_no').value;
        var i_search_ww_no = document.getElementById("search_ww_no").value.trim();
      } else if (search_ww_opt[1].checked) {
        var i_search_ww_opt = document.getElementById('search_ww_opt_by_date_range').value;
        var i_search_ww_start_date_from = document.getElementById("search_ww_start_date_from").value;
        var i_search_ww_start_date_to = document.getElementById("search_ww_start_date_to").value;
      }
      var i_search_car_model = document.getElementById("search_car_model").value.trim();
      var i_search_machine_name = document.getElementById("search_machine_name").value.trim();
      var i_search_machine_no = document.getElementById("search_machine_no").value.trim();
      var i_search_equipment_no = document.getElementById("search_equipment_no").value.trim();
      var i_search_manpower = document.getElementById("search_manpower").value.trim();
      if (i_search_pm_plan_year == '') {
        var continue_loading = false;
        swal('Work Week', 'Fill out PM Plan Year input field', 'info');
      } else if (i_search_ww_opt == '') {
        var continue_loading = false;
        swal('Work Week', 'Please check search by WW No. or by date range', 'info');
      } else if (i_search_ww_start_date_from != '' && i_search_ww_start_date_to == '') {
        var continue_loading = false;
        swal('Work Week', 'Fill out all date field', 'info');
      } else if (i_search_ww_start_date_from == '' && i_search_ww_start_date_to != '') {
        var continue_loading = false;
        swal('Work Week', 'Fill out all date field', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("workWeekData").lastChild.getAttribute("id");
      var i_search_pm_plan_year = sessionStorage.getItem('search_pm_plan_year');
      var search_ww_opt = sessionStorage.getItem('search_ww_opt');
      var i_search_ww_opt = search_ww_opt;
      if (search_ww_opt == 1) {
        var i_search_ww_no = sessionStorage.getItem('search_ww_no');
      } else if (search_ww_opt == 2) {
        var i_search_ww_start_date_from = sessionStorage.getItem('search_ww_start_date_from');
        var i_search_ww_start_date_to = sessionStorage.getItem('search_ww_start_date_to');
      }
      var i_search_car_model = sessionStorage.getItem('search_car_model');
      var i_search_machine_name = sessionStorage.getItem('search_machine_name');
      var i_search_machine_no = sessionStorage.getItem('search_machine_no');
      var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
      var i_search_manpower = sessionStorage.getItem('search_manpower');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/work-week_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_ww',
        id: id,
        interface: 'Admin',
        pm_plan_year: i_search_pm_plan_year,
        ww_opt: i_search_ww_opt,
        ww_no: i_search_ww_no,
        ww_start_date_from: i_search_ww_start_date_from,
        ww_start_date_to: i_search_ww_start_date_to,
        car_model: i_search_car_model,
        machine_name: i_search_machine_name,
        machine_no: i_search_machine_no,
        equipment_no: i_search_equipment_no,
        manpower: i_search_manpower,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="12" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("workWeekData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("workWeekData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('search_pm_plan_year', i_search_pm_plan_year);
            sessionStorage.setItem('search_ww_opt', i_search_ww_opt);
            sessionStorage.setItem('search_ww_no', i_search_ww_no);
            sessionStorage.setItem('search_ww_start_date_from', i_search_ww_start_date_from);
            sessionStorage.setItem('search_ww_start_date_to', i_search_ww_start_date_to);
            sessionStorage.setItem('search_car_model', i_search_car_model);
            sessionStorage.setItem('search_machine_name', i_search_machine_name);
            sessionStorage.setItem('search_machine_no', i_search_machine_no);
            sessionStorage.setItem('search_equipment_no', i_search_equipment_no);
            sessionStorage.setItem('search_manpower', i_search_manpower);
            break;
          case 2:
            document.getElementById("workWeekData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_ww();
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
    get_ww(1);
  }
});

document.getElementById("search_ww_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("search_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("search_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("search_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("search_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("search_manpower").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

// uncheck all
const uncheck_all_pm = () => {
  var select_all = document.getElementById('check_all_pm');
  select_all.checked = false;
  document.querySelectorAll(".singleCheck").forEach((el, i) => {
    el.checked = false;
  });
  get_checked_pm();
}
// check all
const select_all_pm_func = () => {
  var select_all = document.getElementById('check_all_pm');
  if (select_all.checked == true) {
    console.log('check');
    document.querySelectorAll(".singleCheck").forEach((el, i) => {
      el.checked = true;
    });
  } else {
    console.log('uncheck');
    document.querySelectorAll(".singleCheck").forEach((el, i) => {
      el.checked = false;
    }); 
  }
  get_checked_pm();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_pm = () => {
  var arr = [];
  document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
    arr.push(el.value);
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    if (getCookie('pm_role') != 'Admin') {
      document.getElementById("btnUpdateSelWW").setAttribute('disabled', true);
    } else {
      document.getElementById("btnUpdateSelWW").removeAttribute('disabled');
    }
  } else {
    document.getElementById("btnUpdateSelWW").setAttribute('disabled', true);
  }
  document.getElementById("rows_selected").innerHTML = numberOfChecked;
}

$("#WWContentModal").on('hidden.bs.modal', e => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_process").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_car_model").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_pm_plan_year").value = '';
  document.getElementById("u_ww_no").value = '';
  document.getElementById("u_frequency").value = '';
  document.getElementById("u_manpower").value = '';
  document.getElementById("u_ww_start_date").value = '';
  document.getElementById("u_sched_start_date_time").value = '';
  document.getElementById("u_sched_end_date_time").value = '';
  document.getElementById("u_pm_status").value = '';
  document.getElementById("u_machine_status").value = '';
});

$("#WWUpdateContentModal").on('hidden.bs.modal', e => {
  document.getElementById("u_manpower_update").value = '';
});

const update_ww_manpower = () => {
  var manpower = document.getElementById("u_manpower_update").value.trim();

  var arr = [];
  document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
    arr.push(el.value);
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $.ajax({
      url: '../process/admin/work-week_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'update_ww_manpower',
        arr:arr,
        manpower:manpower
      }, 
      beforeSend: (jqXHR, settings) => {
        swal('Work Week', 'Loading please wait...', {
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
            swal('Work Week', 'Successfully Saved', 'success');
            $('#WWUpdateContentModal').modal('hide');
            get_ww(1);
            uncheck_all_pm();
          } else if (response == 'Manpower Not Set') {
            swal('Work Week', 'Please set Manpower', 'info');
          } else {
            console.log(response);
            swal('Work Week Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
          }
        }, 500);
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    swal('Work Week', `No checkbox checked`, 'info');
  }
}

const update_ww_content = () => {
  var id = document.getElementById("u_id").value.trim();
  var manpower = document.getElementById("u_manpower").value.trim();
  var sched_start_date_time = document.getElementById("u_sched_start_date_time").value;
  var sched_end_date_time = document.getElementById("u_sched_end_date_time").value;

  $.ajax({
    url: '../process/admin/work-week_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_ww_content',
      id:id,
      manpower:manpower,
      sched_start_date_time:sched_start_date_time,
      sched_end_date_time:sched_end_date_time
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Work Week', 'Loading please wait...', {
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
          swal('Work Week', 'Successfully Saved', 'success');
          $('#WWContentModal').modal('hide');
          get_ww(1);
        } else if (response == 'Start Date Time Not Set') {
          swal('Work Week', 'Please set Start Date & Time', 'info');
        } else if (response == 'End Date Time Not Set') {
          swal('Work Week', 'Please set End Date & Time', 'info');
        } else if (response == 'Manpower Empty') {
          swal('Work Week', 'Please fill out Manpower Field', 'info');
        } else {
          console.log(response);
          swal('Work Week Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const export_ww = () => {
  var pm_plan_year = document.getElementById("search_pm_plan_year").value;
  var ww_no = document.getElementById("search_ww_no").value;
  if (pm_plan_year != '') {
    window.open('../process/export/export_work_week.php?pm_plan_year='+pm_plan_year+'&ww_no='+ww_no,'_blank');
  } else {
    swal('Export Work Week', 'Fill out PM Plan Year input field', 'info');
  }
}

const set_as_done_ww = () => {
  var id = document.getElementById("u_id").value.trim();

  $.ajax({
    url: '../process/admin/work-week_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_as_done_ww',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Work Week', 'Loading please wait...', {
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
          swal('Work Week', 'Set as Done Successfully', 'success');
          $('#WWContentModal').modal('hide');
          get_ww(1);
        } else if (response == 'RSIR Not Found') {
          swal('Work Week Error', 'Your checksheet related to this work week is not found on PM Records. Please make PM RSIR checksheet before set as done', 'error');
        } else if (response == 'Updated RSIR Not Found') {
          swal('Work Week Error', 'Your updated checksheet related to this work week is not found on PM Records. Please make newer PM RSIR checksheet before set as done', 'error');
        } else {
          console.log(response);
          swal('Work Week Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const confirm_as_done_ww = () => {
  var id = document.getElementById("u_id").value.trim();

  $.ajax({
    url: '../process/admin/work-week_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'confirm_as_done_ww',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Work Week', 'Loading please wait...', {
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
          swal('Work Week', 'Confirm as Done Successfully', 'success');
          $('#WWContentModal').modal('hide');
          get_ww(1);
        } else {
          console.log(response);
          swal('Work Week Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}
