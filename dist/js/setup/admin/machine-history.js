// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  load_notif_setup();
  realtime_load_notif_setup = setInterval(load_notif_setup, 5000);
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
      document.getElementById("history_car_models").innerHTML = response;
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

const count_machine_history = () => {
  var history_date_from = sessionStorage.getItem('history_date_from');
  var history_date_to = sessionStorage.getItem('history_date_to');
  var car_model = sessionStorage.getItem('history_car_model');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var machine_no = sessionStorage.getItem('history_machine_no');
  var equipment_no = sessionStorage.getItem('history_equipment_no');
  
  $.ajax({
    url: '../process/admin/machine-history_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_machine_history',
      history_date_from: history_date_from,
      history_date_to: history_date_to,
      car_model: car_model,
      machine_name: machine_name,
      machine_no: machine_no,
      equipment_no: equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("machineHistoryData").childNodes.length);
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

const get_machine_history = option => {
  var id = 0;
  var history_date_from = '';
  var history_date_to = '';
  var car_model = '';
  var machine_name = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var history_date_from = document.getElementById("history_date_from").value.trim();
      var history_date_to = document.getElementById("history_date_to").value.trim();
      var car_model = document.getElementById("history_car_model").value.trim();
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var machine_no = document.getElementById("history_machine_no").value.trim();
      var equipment_no = document.getElementById("history_equipment_no").value.trim();
      if ((history_date_from == '' && history_date_to != '') || (history_date_from != '' && history_date_to == '')) {
        var continue_loading = false;
        swal('Machine History', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("machineHistoryData").lastChild.getAttribute("id");
      var history_date_from = sessionStorage.getItem('history_date_from');
      var history_date_to = sessionStorage.getItem('history_date_to');
      var car_model = sessionStorage.getItem('history_car_model');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var machine_no = sessionStorage.getItem('history_machine_no');
      var equipment_no = sessionStorage.getItem('history_equipment_no');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/machine-history_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_machine_history',
        id: id,
        history_date_from: history_date_from,
        history_date_to: history_date_to,
        car_model: car_model,
        machine_name: machine_name,
        machine_no: machine_no,
        equipment_no: equipment_no,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="18" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("machineHistoryData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("machineHistoryData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('history_date_from', history_date_from);
            sessionStorage.setItem('history_date_to', history_date_to);
            sessionStorage.setItem('history_car_model', car_model);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_machine_no', machine_no);
            sessionStorage.setItem('history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("machineHistoryData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_machine_history();
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
    get_machine_history(1);
  }
});

document.getElementById("history_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_history(1);
  }
});

document.getElementById("history_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_history(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_history(1);
  }
});

document.getElementById("history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_history(1);
  }
});

document.getElementById("history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_history(1);
  }
});

const export_machine_history = () => {
  var history_date_from = document.getElementById("history_date_from").value.trim();
  var history_date_to = document.getElementById("history_date_to").value.trim();
  var car_model = document.getElementById("history_car_model").value.trim();
  var machine_name = document.getElementById("history_machine_name").value.trim();
  var machine_no = document.getElementById("history_machine_no").value.trim();
  var equipment_no = document.getElementById("history_equipment_no").value.trim();
  if ((history_date_from == '' && history_date_to != '') || (history_date_from != '' && history_date_to == '')) {
    swal('Machine History', 'Fill out all date fields', 'info');
  } else {
    window.open('../process/export/export_machine_history.php?history_date_from='+history_date_from+'&history_date_to='+history_date_to+'&car_model='+car_model+'&machine_name='+machine_name+'&machine_no='+machine_no+'&equipment_no='+equipment_no,'_blank');
  }
}
