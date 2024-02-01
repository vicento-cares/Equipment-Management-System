// Global Variables for Realtime Tables
var realtime_get_no_spare_pm_concerns;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_no_spare_pm_concerns();
  realtime_get_no_spare_pm_concerns = setInterval(get_no_spare_pm_concerns, 10000);
  
  get_machines_datalist_search();
  get_car_models_datalist_search();

  load_notif_sp_pm_concerns_page();
  realtime_load_notif_sp_pm_concerns_page = setInterval(load_notif_sp_pm_concerns_page, 10000);
  update_notif_new_pm_concerns();
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

const get_details_no_spare = el => {
  var id = el.dataset.id;
  var pm_concern_id = el.dataset.pm_concern_id;
  var concern_date_time = el.dataset.concern_date_time;

  document.getElementById("u_no_spare_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_no_spare_concern_date_time").innerHTML = concern_date_time;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_no_spare_by_pm_concerns_id_sp',
      pm_concern_id:pm_concern_id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("NoSparePmConcernPartsData").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pm_concern_mark_as_read',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('PM Concerns Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#noSparePmConcernsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-orange');
});

const get_details_no_spare_info = el => {
  var id = el.dataset.id;
  var machine_line = el.dataset.machine_line;
  var pm_concern_id = el.dataset.pm_concern_id;
  var concern_date_time = el.dataset.concern_date_time;
  var request_by = el.dataset.request_by;
  var confirm_by = el.dataset.confirm_by;
  var problem = el.dataset.problem;
  var comment = el.dataset.comment;
  var parts_code = el.dataset.parts_code;
  var quantity = el.dataset.quantity;
  var po_date = el.dataset.po_date;
  var po_no = el.dataset.po_no;
  var no_spare_status = el.dataset.no_spare_status;
  var date_arrived = el.dataset.date_arrived;

  document.getElementById("u_no_spare_id").value = id;
  document.getElementById("u_no_spare_machine_line").innerHTML = machine_line;
  document.getElementById("u_no_spare_pm_concern_id2").innerHTML = pm_concern_id;
  document.getElementById("u_no_spare_concern_date_time2").innerHTML = concern_date_time;
  document.getElementById("u_no_spare_request_by").innerHTML = request_by;
  document.getElementById("u_no_spare_confirm_by").innerHTML = confirm_by;
  document.getElementById("u_no_spare_problem").innerHTML = problem;
  document.getElementById("u_no_spare_comment_view").innerHTML = comment;
  document.getElementById("u_no_spare_parts_code").innerHTML = parts_code;
  document.getElementById("u_no_spare_quantity").innerHTML = quantity;
  document.getElementById("u_no_spare_po_date").value = po_date;
  document.getElementById("u_no_spare_po_no").value = po_no;
  document.getElementById("u_no_spare_status").value = no_spare_status;
  document.getElementById("u_no_spare_date_arrived").value = date_arrived;

  setTimeout(() => {$('#NoSparePmConcernInfoModal').modal('show');}, 400);
}

const count_no_spare_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_no_spare_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("noSparePmConcernsData").childNodes.length);
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

const get_no_spare_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_no_spare_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("noSparePmConcernsData").innerHTML = response;
      count_no_spare_pm_concerns();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_no_spare_pm_concerns);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const clear_no_spare_pm_concern_info_fields = () => {
  document.getElementById("u_no_spare_po_date").value = '';
  document.getElementById("u_no_spare_po_no").value = '';
  document.getElementById("u_no_spare_status").value = '';
  document.getElementById("u_no_spare_date_arrived").value = '';
}

const save_no_spare_details = () => {
  var id = document.getElementById("u_no_spare_id").value;
  var pm_concern_id = document.getElementById("u_no_spare_pm_concern_id2").innerHTML;
  var po_date = document.getElementById("u_no_spare_po_date").value.trim();
  var po_no = document.getElementById("u_no_spare_po_no").value.trim();
  var date_arrived = document.getElementById("u_no_spare_date_arrived").value.trim();

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_no_spare_details',
      id:id,
      pm_concern_id:pm_concern_id,
      po_date:po_date,
      po_no:po_no,
      date_arrived:date_arrived
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('PM Concerns', 'Loading please wait...', {
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
          swal('PM Concerns', 'Successfully Saved', 'success');
          get_no_spare_pm_concerns();
          clear_no_spare_pm_concern_info_fields();
          $('#NoSparePmConcernInfoModal').modal('hide');
          setTimeout(() => {$('#NoSparePmConcernModal').modal('show');}, 400);
        } else if (response == 'PO Date Not Set') {
          swal('PM Concerns', 'Please set PO Date', 'info');
        } else if (response == 'PO No. Empty') {
          swal('PM Concerns', 'Please fill out PO No.', 'info');
        } else {
          console.log(response);
          swal('PM Concerns Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_no_spare_history = () => {
  var concern_date_from = sessionStorage.getItem('history_concern_date_from');
  var concern_date_to = sessionStorage.getItem('history_concern_date_to');
  var car_model = sessionStorage.getItem('history_car_model');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var pm_concern_id = sessionStorage.getItem('history_pm_concern_id');
  var pm_concern_status = sessionStorage.getItem('history_pm_concern_status');
  
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_no_spare_history',
      concern_date_from: concern_date_from,
      concern_date_to: concern_date_to,
      car_model: car_model,
      machine_name: machine_name,
      pm_concern_id: pm_concern_id,
      pm_concern_status: pm_concern_status
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("noSpareHistoryData").childNodes.length);
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

const get_no_spare_history = option => {
  var id = 0;
  var concern_date_from = '';
  var concern_date_to = '';
  var machine_name = '';
  var car_model = '';
  var pm_concern_id = '';
  var pm_concern_status = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var concern_date_from = document.getElementById("history_concern_date_from").value.trim();
      var concern_date_to = document.getElementById("history_concern_date_to").value.trim();
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var car_model = document.getElementById("history_car_model").value.trim();
      var pm_concern_id = document.getElementById("history_pm_concern_id").value.trim();
      var pm_concern_status = document.getElementById("history_pm_concern_status").value.trim();
      if (concern_date_from == '' || concern_date_to == '') {
        var continue_loading = false;
        swal('PM Concerns', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("noSpareHistoryData").lastChild.getAttribute("id");
      var concern_date_from = sessionStorage.getItem('history_concern_date_from');
      var concern_date_to = sessionStorage.getItem('history_concern_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var car_model = sessionStorage.getItem('history_car_model');
      var pm_concern_id = sessionStorage.getItem('history_pm_concern_id');
      var pm_concern_status = sessionStorage.getItem('history_pm_concern_status');
      var loader_count2 = parseInt(document.getElementById("loader_count2").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/pm-concerns_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_no_spare_history',
        id: id,
        concern_date_from: concern_date_from,
        concern_date_to: concern_date_to,
        machine_name: machine_name,
        car_model: car_model,
        pm_concern_id: pm_concern_id,
        pm_concern_status: pm_concern_status,
        c: loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="16" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          document.getElementById("noSpareHistoryData").innerHTML = loading;
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("noSpareHistoryData").innerHTML = response;
            document.getElementById("loader_count2").value = 25;
            sessionStorage.setItem('history_concern_date_from', concern_date_from);
            sessionStorage.setItem('history_concern_date_to', concern_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_car_model', car_model);
            sessionStorage.setItem('history_pm_concern_id', pm_concern_id);
            sessionStorage.setItem('history_pm_concern_status', pm_concern_status);
            break;
          case 2:
            document.getElementById("noSpareHistoryData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count2").value = loader_count2 + 25;
            break;
          default:
        }
        count_no_spare_history();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("history_concern_date_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_no_spare_history(1);
  }
});

document.getElementById("history_concern_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_no_spare_history(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_no_spare_history(1);
  }
});

document.getElementById("history_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_no_spare_history(1);
  }
});

document.getElementById("history_pm_concern_id").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_no_spare_history(1);
  }
});

const export_no_spare_history = () => {
  var concern_date_from = document.getElementById("history_concern_date_from").value;
  var concern_date_to = document.getElementById("history_concern_date_to").value;
  var machine_name = document.getElementById("history_machine_name").value;
  var car_model = document.getElementById("history_car_model").value;
  var pm_concern_id = document.getElementById("history_pm_concern_id").value;
  var pm_concern_status = document.getElementById("history_pm_concern_status").value;

  if (concern_date_from != '' && concern_date_to != '') {
    window.open('../process/export/export_pm_no_spare_history.php?concern_date_from='+concern_date_from+'&concern_date_to='+concern_date_to+'&machine_name='+machine_name+'&car_model='+car_model+'&pm_concern_id='+pm_concern_id+'&pm_concern_status='+pm_concern_status,'_blank');
  } else {
    swal('Export PM Concerns', 'Fill out all date fields', 'info');
  }
}