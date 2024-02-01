// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_pm_plan_years_datalist_search();
  get_all_ww_no_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  load_notif_public_pm_concerns();
  realtime_load_notif_public_pm_concerns = setInterval(load_notif_public_pm_concerns, 5000);
});

const get_car_models_datalist_search = () => {
  $.ajax({
    url: 'process/admin/car-models_processor.php',
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
    url: 'process/admin/machines_processor.php',
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
    url: 'process/admin/pm-plan_processor.php',
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
    url: 'process/admin/pm-plan_processor.php',
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
    url: 'process/admin/machines_processor.php',
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
    url: 'process/admin/machines_processor.php',
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
  
  $.ajax({
    url: 'process/admin/work-week_processor.php',
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
      equipment_no: i_search_equipment_no
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
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: 'process/admin/work-week_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_ww',
        id: id,
        interface: 'Public',
        pm_plan_year: i_search_pm_plan_year,
        ww_opt: i_search_ww_opt,
        ww_no: i_search_ww_no,
        ww_start_date_from: i_search_ww_start_date_from,
        ww_start_date_to: i_search_ww_start_date_to,
        car_model: i_search_car_model,
        machine_name: i_search_machine_name,
        machine_no: i_search_machine_no,
        equipment_no: i_search_equipment_no,
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

const export_ww = () => {
  var pm_plan_year = document.getElementById("search_pm_plan_year").value;
  var ww_no = document.getElementById("search_ww_no").value;
  if (pm_plan_year != '') {
    window.open('process/export/export_work_week.php?pm_plan_year='+pm_plan_year+'&ww_no='+ww_no,'_blank');
  } else {
    swal('Export Work Week', 'Fill out PM Plan Year input field', 'info');
  }
}
