// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  load_notif_pm();
  realtime_load_notif_pm = setInterval(load_notif_pm, 5000);
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

const get_details_machine_checksheets_history = el => {
  var rsir_no = el.dataset.rsir_no;
  var rsir_type = el.dataset.rsir_type;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var rsir_date = el.dataset.rsir_date;
  var rsir_process_status = el.dataset.rsir_process_status;

  var judgement_of_eq = el.dataset.judgement_of_eq;
  var judgement_of_prod = el.dataset.judgement_of_prod;
  var repair_details = el.dataset.repair_details;
  var inspected_by = el.dataset.inspected_by;
  var repair_date = el.dataset.repair_date;
  var confirmed_by = el.dataset.confirmed_by;
  var repaired_by = el.dataset.repaired_by;
  var judgement_by = el.dataset.judgement_by;
  var next_pm_date = el.dataset.next_pm_date;

  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  var disapproved_by = el.dataset.disapproved_by;
  var disapproved_by_role = el.dataset.disapproved_by_role;
  var disapproved_comment = el.dataset.disapproved_comment;

  document.getElementById("history_rsir_no2").innerHTML = rsir_no;
  document.getElementById("history_rsir_type2").innerHTML = rsir_type;
  document.getElementById("history_rsir_machine_name2").innerHTML = machine_name;
  document.getElementById("history_rsir_machine_no2").innerHTML = machine_no;
  document.getElementById("history_rsir_equipment_no2").innerHTML = equipment_no;
  document.getElementById("history_rsir_date2").innerHTML = rsir_date;

  document.getElementById("history_rsir_judgement_of_eq").innerHTML = judgement_of_eq;
  document.getElementById("history_rsir_repair_details").innerHTML = repair_details;
  document.getElementById("history_rsir_judgement_of_prod").innerHTML = judgement_of_prod;
  document.getElementById("history_rsir_confirmed_by").innerHTML = confirmed_by;
  document.getElementById("history_rsir_repair_date").innerHTML = repair_date;
  document.getElementById("history_rsir_inspected_by").innerHTML = inspected_by;
  document.getElementById("history_rsir_repaired_by").innerHTML = repaired_by;
  document.getElementById("history_rsir_judgement_by").innerHTML = judgement_by;
  document.getElementById("history_rsir_next_pm_date").innerHTML = next_pm_date;

  document.getElementById("history_rsir_file_name").innerHTML = file_name;
  document.getElementById("history_rsir_file_url").value = file_url;

  document.getElementById("history_rsir_disapproved_by").innerHTML = disapproved_by;
  document.getElementById("history_rsir_disapproved_by_role").innerHTML = disapproved_by_role;
  document.getElementById("history_rsir_disapproved_comment").innerHTML = disapproved_comment;
}

const count_pm_records = () => {
  var history_date_from = sessionStorage.getItem('history_date_from');
  var history_date_to = sessionStorage.getItem('history_date_to');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var rsir_no = sessionStorage.getItem('history_rsir_no');
  var machine_no = sessionStorage.getItem('history_machine_no');
  var equipment_no = sessionStorage.getItem('history_equipment_no');
  
  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_pm_records',
      rsir_date_from:history_date_from,
      rsir_date_to:history_date_to,
      machine_name:machine_name,
      rsir_no:rsir_no,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmRecordsData").childNodes.length);
      let loader_count = document.getElementById("loader_count").value;
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

const get_pm_records = option => {
  var id = 0;
  var history_date_from = '';
  var history_date_to = '';
  var machine_name = '';
  var rsir_no = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var history_date_from = document.getElementById("history_date_from").value;
      var history_date_to = document.getElementById("history_date_to").value;
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var rsir_no = document.getElementById("history_rsir_no").value.trim();
      var machine_no = document.getElementById("history_machine_no").value.trim();
      var equipment_no = document.getElementById("history_equipment_no").value.trim();
      if (history_date_from == '' || history_date_to == '') {
        var continue_loading = false;
        swal('Machine Checksheets', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("pmRecordsData").lastChild.getAttribute("id");
      var history_date_from = sessionStorage.getItem('history_date_from');
      var history_date_to = sessionStorage.getItem('history_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var rsir_no = sessionStorage.getItem('history_rsir_no');
      var machine_no = sessionStorage.getItem('history_machine_no');
      var equipment_no = sessionStorage.getItem('history_equipment_no');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/machine-checksheets_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_pm_records',
        id:id,
        rsir_date_from:history_date_from,
        rsir_date_to:history_date_to,
        machine_name:machine_name,
        rsir_no:rsir_no,
        machine_no:machine_no,
        equipment_no:equipment_no,
        c:loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
            var loading = `<tr><td colspan="7" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("pmRecordsData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("pmRecordsData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('history_date_from', history_date_from);
            sessionStorage.setItem('history_date_to', history_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_rsir_no', rsir_no);
            sessionStorage.setItem('history_machine_no', machine_no);
            sessionStorage.setItem('history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("pmRecordsData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_pm_records();
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
    get_pm_records(1);
  }
});

document.getElementById("history_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records(1);
  }
});

document.getElementById("history_rsir_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records(1);
  }
});

document.getElementById("history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records(1);
  }
});

document.getElementById("history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_pm_records(1);
  }
});

const download_rsir_history = () => {
  var file_url = document.getElementById("history_rsir_file_url").value;
  window.open(file_url,'_blank');
}
