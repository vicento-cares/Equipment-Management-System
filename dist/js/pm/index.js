// Global Variables for Realtime Tables
var realtime_get_pm_concerns_public;
var realtime_get_recent_pm_concerns_pending;
var realtime_get_no_spare_pm_concerns;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_machines_dropdown();
  load_i_problem_textarea();
  get_pm_concerns_public();
  get_recent_pm_concerns_pending();
  get_no_spare_pm_concerns();
  realtime_get_pm_concerns_public = setInterval(get_pm_concerns_public, 20000);
  realtime_get_recent_pm_concerns_pending = setInterval(get_recent_pm_concerns_pending, 20000);
  realtime_get_no_spare_pm_concerns = setInterval(get_no_spare_pm_concerns, 20000);
  get_machines_datalist_search();
  get_car_models_datalist_search();
  load_notif_public_pm_concerns_page();
  realtime_load_notif_public_pm_concerns_page = setInterval(load_notif_public_pm_concerns_page, 20000);
  update_notif_public_pm_concerns();
});

const get_car_models_datalist = (action, setup_process) => {
  $.ajax({
    url: 'process/admin/car-models_processor.php',
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

const get_machines_dropdown = () => {
  $.ajax({
    url: 'process/admin/machines_processor.php',
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
      document.getElementById("history_car_models").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#pmConcernsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-orange');
});

$('#pmConcernsRecentPendingTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-warning');
  $(e.currentTarget).removeClass('bg-success');
});

const get_details = el => {
  var id = el.dataset.id;
  var pm_concern_id = el.dataset.pm_concern_id;
  var machine_line = el.dataset.machine_line;
  var concern_date_time = el.dataset.concern_date_time;
  var request_by = el.dataset.request_by;
  var confirm_by = el.dataset.confirm_by;
  var problem = el.dataset.problem;
  var comment = el.dataset.comment;
  var status = el.dataset.status;

  document.getElementById("u_id").value = id;
  document.getElementById("u_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_machine_line").innerHTML = machine_line;
  document.getElementById("u_concern_date_time").innerHTML = concern_date_time;
  document.getElementById("u_request_by").innerHTML = request_by;
  document.getElementById("u_confirm_by").innerHTML = confirm_by;
  document.getElementById("u_problem").innerHTML = problem;
  document.getElementById("u_comment").innerHTML = comment;

  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pm_concern_mark_as_read_public',
      id:id,
      status:status
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

const get_details_history = el => {
  var id = el.dataset.id;
  var pm_concern_id = el.dataset.pm_concern_id;
  var machine_line = el.dataset.machine_line;
  var concern_date_time = el.dataset.concern_date_time;
  var request_by = el.dataset.request_by;
  var confirm_by = el.dataset.confirm_by;
  var problem = el.dataset.problem;
  var comment = el.dataset.comment;
  var status = el.dataset.status;

  document.getElementById("u_history_id").value = id;
  document.getElementById("u_history_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_history_machine_line").innerHTML = machine_line;
  document.getElementById("u_history_concern_date_time").innerHTML = concern_date_time;
  document.getElementById("u_history_request_by").innerHTML = request_by;
  document.getElementById("u_history_confirm_by").innerHTML = confirm_by;
  document.getElementById("u_history_problem").innerHTML = problem;
  document.getElementById("u_history_comment").innerHTML = comment;

  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pm_concern_mark_as_read_public',
      id:id,
      status:status
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

const count_pm_concerns = () => {
  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmConcernsData").childNodes.length);
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

const get_pm_concerns_public = () => {
  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_pm_concerns_public'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pmConcernsData").innerHTML = response;
      count_pm_concerns();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_pm_concerns_public);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const get_recent_pm_concerns_pending = () => {
  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_recent_pm_concerns_pending'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pmConcernsRecentPendingData").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_recent_pm_concerns_pending);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const get_details_no_spare = el => {
  var pm_concern_id = el.dataset.pm_concern_id;
  var concern_date_time = el.dataset.concern_date_time;

  document.getElementById("u_no_spare_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_no_spare_concern_date_time").innerHTML = concern_date_time;

  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_no_spare_by_pm_concerns_id_pm',
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
}

const count_no_spare_pm_concerns = () => {
  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
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
        let counter_view_search2 = "";
        if (total_rows < 2) {
          counter_view_search2 = `${total_rows} record found`;
        } else {
          counter_view_search2 = `${total_rows} records found`;
        }
        document.getElementById("counter_view_search2").innerHTML = counter_view_search2;
        document.getElementById("counter_view_search2").style.display = 'block';
      } else {
        document.getElementById("counter_view_search2").style.display = 'none';
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
    url: 'process/admin/pm-concerns_processor.php',
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

const load_i_problem_textarea = () => {
  setTimeout(() => {
    var max_length = document.getElementById("i_problem").getAttribute("maxlength");
    var problem_length = document.getElementById("i_problem").value.length;
    var i_problem_count = `${problem_length} / ${max_length}`;
    document.getElementById("i_problem_count").innerHTML = i_problem_count;
  }, 100);
}

const count_i_problem_char = () => {
  var max_length = document.getElementById("i_problem").getAttribute("maxlength");
  var problem_length = document.getElementById("i_problem").value.length;
  var i_problem_count = `${problem_length} / ${max_length}`;
  document.getElementById("i_problem_count").innerHTML = i_problem_count;
}

const clear_pm_concern_fields = () => {
  document.getElementById("i_machine_name").value = '';
  document.getElementById("i_car_model").value = '';
  document.getElementById("i_trd_no").value = '';
  document.getElementById("i_ns-iv_no").value = '';
  document.getElementById("i_request_by").value = '';
  document.getElementById("i_problem").value = '';
  document.getElementById("i_car_model").setAttribute('disabled', true);
  load_i_problem_textarea();
}

const get_machine_details = action => {
  var machine_name = '';
  if (action == 'insert') {
    var machine_name = document.getElementById("i_machine_name").value;
  } else if (action == 'update') {
    var machine_name = document.getElementById("u_machine_name").value;
  }
  if (machine_name != '') {
    $.ajax({
      url: 'process/admin/machines_processor.php',
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
          get_car_models_datalist(action, setup_process);
          if (action == 'insert') {
            document.getElementById("i_car_model").value = '';
            document.getElementById("i_car_model").removeAttribute('disabled');
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
            document.getElementById("u_car_model").removeAttribute('disabled');
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
            }
          }
        } catch(e) {
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
}

const send_pm_concern = () => {
  var machine_name = document.getElementById("i_machine_name").value;
  var car_model = document.getElementById("i_car_model").value.trim();
  var trd_no = document.getElementById("i_trd_no").value.trim();
  var ns_iv_no = document.getElementById("i_ns-iv_no").value.trim();
  var request_by = document.getElementById("i_request_by").value.trim();
  var problem = document.getElementById("i_problem").value;

  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'send_pm_concern',
      machine_name:machine_name,
      trd_no:trd_no,
      ns_iv_no:ns_iv_no,
      car_model:car_model,
      request_by:request_by,
      problem:problem
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
          swal('PM Concerns', 'PM Concern sent successfully', 'success');
          clear_pm_concern_fields();
          get_pm_concerns_public();
        } else if (response == 'Machine Name Empty') {
          swal('PM Concerns', 'Please fill out Machine Name', 'info');
        } else if (response == 'TRD No. Empty') {
          swal('PM Concerns', 'Please fill out TRD No.', 'info');
        } else if (response == 'NS-IV No. Empty') {
          swal('PM Concerns', 'Please fill out NS-IV No.', 'info');
        } else if (response == 'Car Model Empty') {
          swal('PM Concerns', 'Please fill out Car Model', 'info');
        } else if (response == 'Request By Empty') {
          swal('PM Concerns', 'Please fill out Request By', 'info');
        } else if (response == 'Problem Empty') {
          swal('PM Concerns', 'Please fill out Problem', 'info');
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

const count_pm_concerns_history = () => {
  var concern_date_from = sessionStorage.getItem('history_concern_date_from');
  var concern_date_to = sessionStorage.getItem('history_concern_date_to');
  var car_model = sessionStorage.getItem('history_car_model');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var pm_concern_id = sessionStorage.getItem('history_pm_concern_id');
  
  $.ajax({
    url: 'process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pm_concerns_history',
      concern_date_from: concern_date_from,
      concern_date_to: concern_date_to,
      car_model: car_model,
      machine_name: machine_name,
      pm_concern_id: pm_concern_id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmConcernsHistoryData").childNodes.length);
      let loader_count3 = document.getElementById("loader_count3").value;
      document.getElementById("counter_view3").style.display = 'none';
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
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_pm_concerns_history = option => {
  var id = 0;
  var concern_date_from = '';
  var concern_date_to = '';
  var machine_name = '';
  var car_model = '';
  var pm_concern_id = '';
  var loader_count3 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var concern_date_from = document.getElementById("history_concern_date_from").value.trim();
      var concern_date_to = document.getElementById("history_concern_date_to").value.trim();
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var car_model = document.getElementById("history_car_model").value.trim();
      var pm_concern_id = document.getElementById("history_pm_concern_id").value.trim();
      if (concern_date_from == '' || concern_date_to == '') {
        var continue_loading = false;
        swal('PM Concerns', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("pmConcernsHistoryData").lastChild.getAttribute("id");
      var concern_date_from = sessionStorage.getItem('history_concern_date_from');
      var concern_date_to = sessionStorage.getItem('history_concern_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var car_model = sessionStorage.getItem('history_car_model');
      var pm_concern_id = sessionStorage.getItem('history_pm_concern_id');
      var loader_count3 = parseInt(document.getElementById("loader_count3").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: 'process/admin/pm-concerns_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_pm_concerns_history',
        id: id,
        concern_date_from: concern_date_from,
        concern_date_to: concern_date_to,
        machine_name: machine_name,
        car_model: car_model,
        pm_concern_id: pm_concern_id,
        c: loader_count3
      }, 
      beforeSend: (jqXHR, settings) => {
        if (option == 1) {
          var loading = `<tr><td colspan="12" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
          document.getElementById("pmConcernsHistoryData").innerHTML = loading;
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("pmConcernsHistoryData").innerHTML = response;
            document.getElementById("loader_count3").value = 25;
            sessionStorage.setItem('history_concern_date_from', concern_date_from);
            sessionStorage.setItem('history_concern_date_to', concern_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_car_model', car_model);
            sessionStorage.setItem('history_pm_concern_id', pm_concern_id);
            break;
          case 2:
            document.getElementById("pmConcernsHistoryData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count3").value = loader_count3 + 25;
            break;
          default:
        }
        count_pm_concerns_history();
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
    get_pm_concerns_history(1);
  }
});

document.getElementById("history_concern_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_concerns_history(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_concerns_history(1);
  }
});

document.getElementById("history_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_concerns_history(1);
  }
});

document.getElementById("history_pm_concern_id").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_concerns_history(1);
  }
});

const export_pm_concerns_history = () => {
  var concern_date_from = document.getElementById("history_concern_date_from").value;
  var concern_date_to = document.getElementById("history_concern_date_to").value;
  var machine_name = document.getElementById("history_machine_name").value;
  var car_model = document.getElementById("history_car_model").value;
  var pm_concern_id = document.getElementById("history_pm_concern_id").value;

  if (concern_date_from != '' && concern_date_to != '') {
    window.open('process/export/export_pm_concerns_history.php?concern_date_from='+concern_date_from+'&concern_date_to='+concern_date_to+'&machine_name='+machine_name+'&car_model='+car_model+'&pm_concern_id='+pm_concern_id,'_blank');
  } else {
    swal('Export PM Concerns', 'Fill out all date fields', 'info');
  }
}
