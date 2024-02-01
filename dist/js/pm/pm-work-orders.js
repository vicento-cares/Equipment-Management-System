// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();

  load_notif_public_pm_concerns();
  realtime_load_notif_public_pm_concerns = setInterval(load_notif_public_pm_concerns, 5000);
});

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
      document.getElementById("history_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var wo_id = el.dataset.wo_id;
  var pm_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var file_name = el.dataset.file_name;
  var file_url = el.dataset.file_url;

  document.getElementById("u_id").value = id;
  document.getElementById("u_wo_id").innerHTML = wo_id;
  document.getElementById("u_process").innerHTML = pm_process;
  document.getElementById("u_machine_name").innerHTML = machine_name;
  document.getElementById("u_machine_no").innerHTML = machine_no;
  document.getElementById("u_equipment_no").innerHTML = equipment_no;
  document.getElementById("u_file_name").innerHTML = file_name;
  document.getElementById("u_file_url").value = file_url;
}

const count_work_orders = () => {
  var wo_date_from = sessionStorage.getItem('history_wo_date_from');
  var wo_date_to = sessionStorage.getItem('history_wo_date_to');
  var machine_name = sessionStorage.getItem('history_machine_name');
  var machine_no = sessionStorage.getItem('history_machine_no');
  var equipment_no = sessionStorage.getItem('history_equipment_no');
  
  $.ajax({
    url: 'process/admin/pm-work-orders_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_work_orders',
      wo_date_from: wo_date_from,
      wo_date_to: wo_date_to,
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
      let table_rows = parseInt(document.getElementById("workOrderData").childNodes.length);
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

const get_work_orders = option => {
  var id = 0;
  var wo_date_from = '';
  var wo_date_to = '';
  var machine_name = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var wo_date_from = document.getElementById("history_wo_date_from").value.trim();
      var wo_date_to = document.getElementById("history_wo_date_to").value.trim();
      var machine_name = document.getElementById("history_machine_name").value.trim();
      var machine_no = document.getElementById("history_machine_no").value.trim();
      var equipment_no = document.getElementById("history_equipment_no").value.trim();
      if (wo_date_from == '' || wo_date_to == '') {
        var continue_loading = false;
        swal('Work Order', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("workOrderData").lastChild.getAttribute("id");
      var wo_date_from = sessionStorage.getItem('history_wo_date_from');
      var wo_date_to = sessionStorage.getItem('history_wo_date_to');
      var machine_name = sessionStorage.getItem('history_machine_name');
      var machine_no = sessionStorage.getItem('history_machine_no');
      var equipment_no = sessionStorage.getItem('history_equipment_no');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: 'process/admin/pm-work-orders_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_work_orders',
        id: id,
        wo_date_from: wo_date_from,
        wo_date_to: wo_date_to,
        machine_name: machine_name,
        machine_no: machine_no,
        equipment_no: equipment_no,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="6" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("workOrderData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("workOrderData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('history_wo_date_from', wo_date_from);
            sessionStorage.setItem('history_wo_date_to', wo_date_to);
            sessionStorage.setItem('history_machine_name', machine_name);
            sessionStorage.setItem('history_machine_no', machine_no);
            sessionStorage.setItem('history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("workOrderData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_work_orders();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("history_wo_date_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_work_orders(1);
  }
});

document.getElementById("history_wo_date_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_work_orders(1);
  }
});

document.getElementById("history_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_work_orders(1);
  }
});

document.getElementById("history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_work_orders(1);
  }
});

document.getElementById("history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_work_orders(1);
  }
});

$("#WorkOrderDetailsModal").on('hidden.bs.modal', e => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_wo_id").innerHTML = '';
  document.getElementById("u_process").innerHTML = '';
  document.getElementById("u_machine_name").innerHTML = '';
  document.getElementById("u_machine_no").innerHTML = '';
  document.getElementById("u_equipment_no").innerHTML = '';
  document.getElementById("u_file_name").innerHTML = '';
  document.getElementById("u_file_url").value = '';
});

const download_work_order = () => {
  var file_url = document.getElementById("u_file_url").value;
  window.open(file_url,'_blank');
}