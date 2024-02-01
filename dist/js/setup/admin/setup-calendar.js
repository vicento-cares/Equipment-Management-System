// Global Variables for Realtime Tables
var realtime_get_requested_setup_activities;

// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_setup_activities_years();
  get_setup_activities_months();
  get_requested_setup_activities();
  setTimeout(get_setup_activities, 500);
  realtime_get_requested_setup_activities = setInterval(get_requested_setup_activities, 5000);
  load_notif_setup_new_act_sched_page();
  realtime_load_notif_setup_new_act_sched_page = setInterval(load_notif_setup_new_act_sched_page, 5000);
  update_notif_new_act_sched();
});

const get_setup_activities_years = () => {
  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_setup_activities_years'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("search_year").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_setup_activities_months = () => {
  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_setup_activities_months'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("search_month").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#setupActReqTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_req = el => {
  var id = el.dataset.id;
  var car_model = el.dataset.car_model;
  var requestor_name = el.dataset.requestor_name;
  var activity_date = el.dataset.activity_date;
  var activity_details = el.dataset.activity_details;
  var activity_status = el.dataset.activity_status;
  
  document.getElementById("u_req_id").value = id;
  document.getElementById("u_req_car_model").value = car_model;
  document.getElementById("u_req_requestor_name").value = requestor_name;
  document.getElementById("u_req_activity_date").value = activity_date;
  document.getElementById("u_req_act_sched_details").value = activity_details;

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'setup_activities_mark_as_read',
      id:id,
      activity_status:activity_status
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Setup Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_requested_setup_activities = () => {
  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_requested_setup_activities'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      
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

const get_requested_setup_activities = () => {
  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_requested_setup_activities'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("setupActReqData").innerHTML = response;
      count_requested_setup_activities();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_get_requested_setup_activities);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`);
    }
  });
}

const clear_req_act_sched_info_fields = () => {
  document.getElementById("u_req_id").value = '';
  document.getElementById("u_req_car_model").value = '';
  document.getElementById("u_req_requestor_name").value = '';
  document.getElementById("u_req_activity_date").value = '';
  document.getElementById("u_req_act_sched_details").value = '';
}

$("#DeclineSchedModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("u_decline_reason").getAttribute("maxlength");
    var comment_length = document.getElementById("u_decline_reason").value.length;
    var u_decline_reason_count = `${comment_length} / ${max_length}`;
    document.getElementById("u_decline_reason_count").innerHTML = u_decline_reason_count;
  }, 100);
});

const count_decline_reason_char = () => {
  var max_length = document.getElementById("u_decline_reason").getAttribute("maxlength");
  var comment_length = document.getElementById("u_decline_reason").value.length;
  var u_decline_reason_count = `${comment_length} / ${max_length}`;
  document.getElementById("u_decline_reason_count").innerHTML = u_decline_reason_count;
  if (comment_length > 0) {
    document.getElementById("btnDeclineSched").removeAttribute('disabled');
  } else {
    document.getElementById("btnDeclineSched").setAttribute('disabled', true);
  }
}

const accept_activity_schedule = () => {
  var id = document.getElementById("u_req_id").value.trim();

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'accept_activity_schedule',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Set Up Calendar', 'Loading please wait...', {
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
          swal('Set Up Calendar', 'Accepted Successfully', 'success');
          get_requested_setup_activities();
          clear_req_act_sched_info_fields();
          $('#ReqActSchedInfoModal').modal('hide');
        } else {
          console.log(response);
          swal('Set Up Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const decline_activity_schedule = () => {
  var id = document.getElementById("u_req_id").value.trim();
  var decline_reason = document.getElementById("u_decline_reason").value.trim();

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'decline_activity_schedule',
      id:id,
      decline_reason:decline_reason
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Set Up Calendar', 'Loading please wait...', {
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
          swal('Set Up Calendar', 'Declined Successfully', 'success');
          get_requested_setup_activities();
          clear_req_act_sched_info_fields();
          $('#DeclineSchedModal').modal('hide');
        } else {
          console.log(response);
          swal('Set Up Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var activity_date = el.dataset.activity_date;
  var activity_details = el.dataset.activity_details;
  
  document.getElementById("u_id").value = id;
  document.getElementById("u_activity_date").value = activity_date;
  document.getElementById("u_act_sched_details").value = activity_details;
}

const count_setup_activities = () => {
  var setup_activity_year = sessionStorage.getItem('search_year');
  var setup_activity_month = sessionStorage.getItem('search_month');

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_setup_activities',
      setup_activity_year: setup_activity_year,
      setup_activity_month: setup_activity_month
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      
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

const get_setup_activities = () => {
  var setup_activity_year = document.getElementById("search_year").value;
  var setup_activity_month = document.getElementById("search_month").value;
  
  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_setup_activities',
      setup_activity_year: setup_activity_year,
      setup_activity_month: setup_activity_month
    }, 
    beforeSend: (jqXHR, settings) => {
      var loading = `<tr><td colspan="2" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
      document.getElementById("setupActivityData").innerHTML = loading;
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("setupActivityData").innerHTML = response;
      sessionStorage.setItem('search_year', setup_activity_year);
      sessionStorage.setItem('search_month', setup_activity_month);
      count_setup_activities();
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$("#AddActSchedModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("i_act_sched_details").getAttribute("maxlength");
    var comment_length = document.getElementById("i_act_sched_details").value.length;
    var i_act_sched_details_count = `${comment_length} / ${max_length}`;
    document.getElementById("i_act_sched_details_count").innerHTML = i_act_sched_details_count;
  }, 100);
});

const count_act_sched_details_char_insert = () => {
  var max_length = document.getElementById("i_act_sched_details").getAttribute("maxlength");
  var comment_length = document.getElementById("i_act_sched_details").value.length;
  var i_act_sched_details_count = `${comment_length} / ${max_length}`;
  document.getElementById("i_act_sched_details_count").innerHTML = i_act_sched_details_count;
  if (comment_length > 0) {
    document.getElementById("btnSaveActSched").removeAttribute('disabled');
  } else {
    document.getElementById("btnSaveActSched").setAttribute('disabled', true);
  }
}
$("#AddActSchedModal").on('hidden.bs.modal', e => {
  document.getElementById("i_activity_date").value = '';
  document.getElementById("i_act_sched_details").value = '';
});

$("#ActSchedInfoModal").on('show.bs.modal', e => {
  setTimeout(() => {
    var max_length = document.getElementById("u_act_sched_details").getAttribute("maxlength");
    var comment_length = document.getElementById("u_act_sched_details").value.length;
    var u_act_sched_details_count = `${comment_length} / ${max_length}`;
    document.getElementById("u_act_sched_details_count").innerHTML = u_act_sched_details_count;
  }, 100);
});

const count_act_sched_details_char_update = () => {
  var max_length = document.getElementById("u_act_sched_details").getAttribute("maxlength");
  var comment_length = document.getElementById("u_act_sched_details").value.length;
  var u_act_sched_details_count = `${comment_length} / ${max_length}`;
  document.getElementById("u_act_sched_details_count").innerHTML = u_act_sched_details_count;
  if (comment_length > 0) {
    document.getElementById("btnUpdateActSched").removeAttribute('disabled');
  } else {
    document.getElementById("btnUpdateActSched").setAttribute('disabled', true);
  }
}

const clear_act_sched_info_fields = () => {
  document.getElementById("u_activity_date").value = '';
  document.getElementById("u_act_sched_details").value = '';
}

const save_act_sched = () => {
  var activity_date = document.getElementById("i_activity_date").value;
  var activity_details = document.getElementById("i_act_sched_details").value.trim();

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_act_sched',
      activity_date:activity_date,
      activity_details:activity_details
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Set Up Calendar', 'Loading please wait...', {
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
          swal('Set Up Calendar', 'Successfully Added', 'success');
          get_setup_activities();
          $('#AddActSchedModal').modal('hide');
        } else if (response == 'Activity Date Not Set') {
          swal('Set Up Calendar', 'Please set Date of Activity', 'info');
        } else if (response == 'Activity Details Empty') {
          swal('Set Up Calendar', 'Please fill out Activity Schedule Details', 'info');
        } else {
          console.log(response);
          swal('Set Up Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_act_sched = () => {
  var id = document.getElementById("u_id").value.trim();
  var activity_date = document.getElementById("u_activity_date").value;
  var activity_details = document.getElementById("u_act_sched_details").value.trim();

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_act_sched',
      id:id,
      activity_date:activity_date,
      activity_details:activity_details
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Set Up Calendar', 'Loading please wait...', {
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
          swal('Set Up Calendar', 'Successfully Updated', 'success');
          get_setup_activities();
          clear_act_sched_info_fields();
          $('#ActSchedInfoModal').modal('hide');
        } else if (response == 'Activity Date Not Set') {
          swal('Set Up Calendar', 'Please set Date of Activity', 'info');
        } else if (response == 'Activity Details Empty') {
          swal('Set Up Calendar', 'Please fill out Activity Schedule Details', 'info');
        } else {
          console.log(response);
          swal('Set Up Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const delete_act_sched = () => {
  var id = document.getElementById("u_id").value.trim();

  $.ajax({
    url: '../process/admin/setup-calendar_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'delete_act_sched',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Set Up Calendar', 'Loading please wait...', {
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
          swal('Set Up Calendar', 'Schedule Deleted Successfully', 'info');
          get_setup_activities();
          clear_act_sched_info_fields();
          $('#deleteActSchedModal').modal('hide');
        } else {
          console.log(response);
          swal('Set Up Calendar Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}