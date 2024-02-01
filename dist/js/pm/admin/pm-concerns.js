// Global Variables for Realtime Tables
var realtime_get_pm_concerns;
var realtime_get_pending_pm_concerns;
var realtime_get_no_spare_pm_concerns;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_pm_concerns();
  get_pending_pm_concerns();
  get_no_spare_pm_concerns();
  realtime_get_pm_concerns = setInterval(get_pm_concerns, 10000);
  realtime_get_pending_pm_concerns = setInterval(get_pending_pm_concerns, 30000);
  realtime_get_no_spare_pm_concerns = setInterval(get_no_spare_pm_concerns, 30000);
  get_machines_datalist_search();
  get_car_models_datalist_search();
  load_notif_pm_new_pm_concerns_page();
  realtime_load_notif_pm_new_pm_concerns_page = setInterval(load_notif_pm_new_pm_concerns_page, 10000);
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

$('#pmConcernsTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-orange');
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
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'pm_concern_mark_as_read',
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

const get_details_pending_info = el => {
  var id = el.dataset.id;
  var pm_concern_id = el.dataset.pm_concern_id;
  var machine_line = el.dataset.machine_line;
  var concern_date_time = el.dataset.concern_date_time;
  var request_by = el.dataset.request_by;
  var confirm_by = el.dataset.confirm_by;
  var problem = el.dataset.problem;
  var comment = el.dataset.comment;
  var status = el.dataset.status;

  document.getElementById("u_pending_id").value = id;
  document.getElementById("u_pending_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_pending_machine_line").innerHTML = machine_line;
  document.getElementById("u_pending_concern_date_time").innerHTML = concern_date_time;
  document.getElementById("u_pending_request_by").innerHTML = request_by;
  document.getElementById("u_pending_confirm_by").innerHTML = confirm_by;
  document.getElementById("u_pending_problem").innerHTML = problem;
  document.getElementById("u_pending_comment_view").innerHTML = comment;
}

const count_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
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

const get_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_pm_concerns'
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
      clearInterval(realtime_get_pm_concerns);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const count_pending_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pending_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pendingPmConcernsData").childNodes.length);
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

const get_pending_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_pending_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pendingPmConcernsData").innerHTML = response;
      count_pending_pm_concerns();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_pending_pm_concerns);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const get_details_no_spare = el => {
  var id = el.dataset.id;
  var pm_concern_id = el.dataset.pm_concern_id;
  var concern_date_time = el.dataset.concern_date_time;

  document.getElementById("u_no_spare_pending_id").value = id;
  document.getElementById("u_no_spare_pm_concern_id").innerHTML = pm_concern_id;
  document.getElementById("u_no_spare_concern_date_time").innerHTML = concern_date_time;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
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

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'check_all_no_spare_status',
      pm_concern_id:pm_concern_id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response == 'CLOSE') {
        document.getElementById("btnSetDoneNoSparePmConcern").removeAttribute('disabled');
        document.getElementById("btnSetDoneNoSparePmConcern").style.display = 'block';
      } else if (response == 'OPEN') {
        document.getElementById("btnSetDoneNoSparePmConcern").setAttribute('disabled', true);
        document.getElementById("btnSetDoneNoSparePmConcern").style.display = 'none';
      } else {
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
        let counter_view_search3 = "";
        if (total_rows < 2) {
          counter_view_search3 = `${total_rows} record found`;
        } else {
          counter_view_search3 = `${total_rows} records found`;
        }
        document.getElementById("counter_view_search3").innerHTML = counter_view_search3;
        document.getElementById("counter_view_search3").style.display = 'block';
      } else {
        document.getElementById("counter_view_search3").style.display = 'none';
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

const clear_pm_concern_info_fields = () => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_pm_concern_id").innerHTML = '';
  document.getElementById("u_machine_line").innerHTML = '';
  document.getElementById("u_concern_date_time").innerHTML = '';
  document.getElementById("u_request_by").innerHTML = '';
  document.getElementById("u_confirm_by").innerHTML = '';
  document.getElementById("u_problem").innerHTML = '';
  document.getElementById("u_comment").innerHTML = '';
}

const clear_pending_pm_concern_info_fields = () => {
  document.getElementById("u_pending_id").value = '';
  document.getElementById("u_pending_pm_concern_id").innerHTML = '';
  document.getElementById("u_pending_machine_line").innerHTML = '';
  document.getElementById("u_pending_concern_date_time").innerHTML = '';
  document.getElementById("u_pending_request_by").innerHTML = '';
  document.getElementById("u_pending_confirm_by").innerHTML = '';
  document.getElementById("u_pending_problem").innerHTML = '';
  document.getElementById("u_pending_comment_view").innerHTML = '';
}

const set_done_pm_concern = () => {
  var id = document.getElementById("u_id").value.trim();
  var pm_concern_id = document.getElementById("u_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_done_pm_concern',
      id:id,
      pm_concern_id:pm_concern_id
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
          swal('PM Concerns', 'Set as Done Successfully', 'success');
          get_pm_concerns();
          clear_pm_concern_info_fields();
          $('#PmConcernInfoModal').modal('hide');
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

const set_done_pending_pm_concern = () => {
  var id = document.getElementById("u_pending_id").value.trim();
  var pm_concern_id = document.getElementById("u_pending_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_done_pm_concern',
      id:id,
      pm_concern_id:pm_concern_id
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
          swal('PM Concerns', 'Set as Done Successfully', 'success');
          get_pending_pm_concerns();
          clear_pending_pm_concern_info_fields();
          $('#PendingPmConcernInfoModal').modal('hide');
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

const set_done_no_spare_pm_concern = () => {
  var id = document.getElementById("u_no_spare_pending_id").value.trim();
  var pm_concern_id = document.getElementById("u_no_spare_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_done_pm_concern',
      id:id,
      pm_concern_id:pm_concern_id
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
          swal('PM Concerns', 'Set as Done Successfully', 'success');
          get_no_spare_pm_concerns();
          $('#NoSparePmConcernModal').modal('hide');
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

$("#PendingPmConcernModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("u_pending_comment").getAttribute("maxlength");
    var comment_length = document.getElementById("u_pending_comment").value.length;
    var u_pending_comment_count = `${comment_length} / ${max_length}`;
    document.getElementById("u_pending_comment_count").innerHTML = u_pending_comment_count;
  }, 100);
});

const count_u_pending_comment_char = () => {
  var max_length = document.getElementById("u_pending_comment").getAttribute("maxlength");
  var comment_length = document.getElementById("u_pending_comment").value.length;
  var u_pending_comment_count = `${comment_length} / ${max_length}`;
  document.getElementById("u_pending_comment_count").innerHTML = u_pending_comment_count;
  if (comment_length > 0) {
    document.getElementById("btnSetPendingPmConcern").removeAttribute('disabled');
  } else {
    document.getElementById("btnSetPendingPmConcern").setAttribute('disabled', true);
  }
}

$("#PendingPmConcernModal").on('hidden.bs.modal', e => {
  document.getElementById("u_pending_comment").value = '';
});

const set_pending_pm_concern = () => {
  var id = document.getElementById("u_id").value.trim();
  var comment = document.getElementById("u_pending_comment").value.trim();

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_pending_pm_concern',
      id:id,
      comment:comment
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
          swal('PM Concerns', 'Set as Pending Successfully', 'success');
          get_pm_concerns();
          get_pending_pm_concerns();
          $('#PendingPmConcernModal').modal('hide');
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

$("#PendingNoSparePmConcernModal").on('show.bs.modal', e => {
  display_no_spare_parts();
});

const add_no_spare_parts = () => {
  var pm_concern_id = document.getElementById("u_pm_concern_id").innerHTML;
  var parts_code = document.getElementById("i_parts_code").value.trim();
  var quantity = document.getElementById("i_quantity").value.trim();

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'add_no_spare_parts',
      pm_concern_id:pm_concern_id,
      parts_code:parts_code,
      quantity:quantity
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
          display_no_spare_parts();
          document.getElementById("i_parts_code").value = '';
          document.getElementById("i_quantity").value = '';
        } else if (response == 'Parts Code Empty') {
          swal('PM Concerns', 'Please fill out Parts Code', 'info');
        } else if (response == 'Quantity Empty') {
          swal('PM Concerns', 'Please fill out Quantity', 'info');
        } else if (response == 'Max Spare Parts Reached') {
          swal('PM Concerns Error', 'The maximum spare parts reached!!! Only 6 parts per concern', 'error');
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

const display_no_spare_parts = () => {
  var pm_concern_id = document.getElementById("u_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'display_no_spare_parts',
      pm_concern_id:pm_concern_id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("pendingNoSparePmConcernsData").innerHTML = response;
      let table_rows = parseInt(document.getElementById("pendingNoSparePmConcernsData").childNodes.length);
      if (table_rows > 0) {
        document.getElementById("btnSetPendingNoSparePmConcern").removeAttribute('disabled');
      } else {
        document.getElementById("btnSetPendingNoSparePmConcern").setAttribute('disabled', true);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const delete_no_spare_parts = el => {
  var id = el.dataset.id;
  var pm_concern_id = document.getElementById("u_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_no_spare_parts',
      id:id,
      pm_concern_id:pm_concern_id
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
          display_no_spare_parts();
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

const set_pending_no_spare_pm_concern = () => {
  var pm_concern_id = document.getElementById("u_pm_concern_id").innerHTML;

  $.ajax({
    url: '../process/admin/pm-concerns_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'set_pending_no_spare_pm_concern',
      pm_concern_id:pm_concern_id
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
          swal('PM Concerns', 'Set as Pending (NO SPARE) Successfully', 'success');
          get_pm_concerns();
          get_no_spare_pm_concerns();
          $('#PendingNoSparePmConcernModal').modal('hide');
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
    url: '../process/admin/pm-concerns_processor.php',
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
      let loader_count4 = document.getElementById("loader_count4").value;
      document.getElementById("counter_view4").style.display = 'none';
      let counter_view4 = "";
      if (total_rows != 0) {
        let counter_view_search4 = "";
        if (total_rows < 2) {
          counter_view_search4 = `${total_rows} record found`;
          counter_view4 = `${table_rows} row of ${total_rows} record`;
        } else {
          counter_view_search4 = `${total_rows} records found`;
          counter_view4 = `${table_rows} rows of ${total_rows} records`;
        }
        document.getElementById("counter_view_search4").innerHTML = counter_view_search4;
        document.getElementById("counter_view_search4").style.display = 'block';
        document.getElementById("counter_view4").innerHTML = counter_view4;
        document.getElementById("counter_view4").style.display = 'block';
      } else {
        document.getElementById("counter_view_search4").style.display = 'none';
        document.getElementById("counter_view4").style.display = 'none';
      }

      if (total_rows == 0) {
        document.getElementById("search_more_data4").style.display = 'none';
      } else if (total_rows > loader_count4) {
        document.getElementById("search_more_data4").style.display = 'block';
      } else if (total_rows <= loader_count4) {
        document.getElementById("search_more_data4").style.display = 'none';
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
  var loader_count4 = 0;
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
      var loader_count4 = parseInt(document.getElementById("loader_count4").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/pm-concerns_processor.php',
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
        c: loader_count4
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
            document.getElementById("loader_count4").value = 25;
            sessionStorage.setItem('history_concern_date_from', concern_date_from);
            sessionStorage.setItem('history_concern_date_to', concern_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_car_model', car_model);
            sessionStorage.setItem('history_pm_concern_id', pm_concern_id);
            break;
          case 2:
            document.getElementById("pmConcernsHistoryData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count4").value = loader_count4 + 25;
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
    window.open('../process/export/export_pm_concerns_history.php?concern_date_from='+concern_date_from+'&concern_date_to='+concern_date_to+'&machine_name='+machine_name+'&car_model='+car_model+'&pm_concern_id='+pm_concern_id,'_blank');
  } else {
    swal('Export PM Concerns', 'Fill out all date fields', 'info');
  }
}
