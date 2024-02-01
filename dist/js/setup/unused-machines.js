// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_unused_machines(1);
  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  get_accounts_setup_dropdown();

  load_notif_public_act_sched();
  realtime_load_notif_public_act_sched = setInterval(load_notif_public_act_sched, 5000);
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

const get_accounts_setup_dropdown = () => {
  $.ajax({
    url: 'process/admin/admin-accounts_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'get_accounts_setup_dropdown'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      document.getElementById("u_pic").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var car_model = el.dataset.car_model;
  var asset_tag_no = el.dataset.asset_tag_no;
  var status = el.dataset.status;
  var reserved_for = el.dataset.reserved_for;
  var remarks = el.dataset.remarks;
  var pic = el.dataset.pic;
  var unused_machine_location = el.dataset.unused_machine_location;
  var target_date = el.dataset.target_date;

  document.getElementById("u_id").value = id;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_car_model").value = car_model;
  document.getElementById("u_asset_tag_no").value = asset_tag_no;
  document.getElementById("u_status").value = status;
  document.getElementById("u_reserved_for").value = reserved_for;
  document.getElementById("u_remarks").value = remarks;
  document.getElementById("u_pic").value = pic;
  document.getElementById("u_unused_machine_location").value = unused_machine_location;
  document.getElementById("u_target_date").value = target_date;
}

const count_unused_machines = () => {
  var i_search_machine_no = sessionStorage.getItem('search_machine_no');
  var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
  var i_search_machine_name = sessionStorage.getItem('search_machine_name');
  var i_search_status = sessionStorage.getItem('search_status');
  var i_search_car_model = sessionStorage.getItem('search_car_model');
  var i_search_unused_machine_location = sessionStorage.getItem('search_unused_machine_location');

  $.ajax({
    url: 'process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_unused_machines',
      machine_no: i_search_machine_no,
      equipment_no: i_search_equipment_no,
      machine_name: i_search_machine_name,
      status: i_search_status,
      car_model: i_search_car_model,
      unused_machine_location: i_search_unused_machine_location
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("unusedMachinesData").childNodes.length);
      let loader_count = document.getElementById("loader_count").value;
      if (i_search_machine_no == '' && i_search_equipment_no == '' 
        && i_search_machine_name == '' && i_search_status == '' 
        && i_search_car_model == '' && i_search_unused_machine_location == '') {
        document.getElementById("counter_view_search").style.display = 'none';
        document.getElementById("search_more_data").style.display = 'none';
        let counter_view = "";
        if (total_rows != 0) {
          if (total_rows < 2) {
            counter_view = `${table_rows} row of ${total_rows} record`;
          } else {
            counter_view = `${table_rows} rows of ${total_rows} records`;
          }
          document.getElementById("counter_view").innerHTML = counter_view;
          document.getElementById("counter_view").style.display = 'block';
        } else {
          document.getElementById("counter_view").style.display = 'none';
        }

        if (total_rows == 0) {
          document.getElementById("load_more_data").style.display = 'none';
        } else if (total_rows > loader_count) {
          document.getElementById("load_more_data").style.display = 'block';
        } else if (total_rows <= loader_count) {
          document.getElementById("load_more_data").style.display = 'none';
        }
      } else {
        document.getElementById("counter_view").style.display = 'none';
        document.getElementById("load_more_data").style.display = 'none';
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
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_unused_machines = option => {
  var id = 0;
  var i_search_machine_no = '';
  var i_search_equipment_no = '';
  var i_search_machine_name = '';
  var i_search_status = '';
  var i_search_car_model = '';
  var i_search_unused_machine_location = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 2:
      var id = document.getElementById("unusedMachinesData").lastChild.getAttribute("id");
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    case 3:
      var i_search_machine_no = document.getElementById("search_machine_no").value.trim();
      var i_search_equipment_no = document.getElementById("search_equipment_no").value.trim();
      var i_search_machine_name = document.getElementById("search_machine_name").value.trim();
      var i_search_status = document.getElementById("search_status").value.trim();
      var i_search_car_model = document.getElementById("search_car_model").value.trim();
      var i_search_unused_machine_location = document.getElementById("search_unused_machine_location").value.trim();
      if (i_search_machine_no == '' && i_search_equipment_no == '' 
        && i_search_machine_name == '' && i_search_status == '' 
        && i_search_car_model == '' && i_search_unused_machine_location == '') {
        var continue_loading = false;
        swal('Unused Machines Search', 'Fill out any input field', 'info');
      }
      break;
    case 4:
      var id = document.getElementById("unusedMachinesData").lastChild.getAttribute("id");
      var i_search_machine_no = sessionStorage.getItem('search_machine_no');
      var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
      var i_search_machine_name = sessionStorage.getItem('search_machine_name');
      var i_search_status = sessionStorage.getItem('search_status');
      var i_search_car_model = sessionStorage.getItem('search_car_model');
      var i_search_unused_machine_location = sessionStorage.getItem('search_unused_machine_location');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: 'process/admin/unused-machines_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_unused_machines',
        id: id,
        machine_no: i_search_machine_no,
        equipment_no: i_search_equipment_no,
        machine_name: i_search_machine_name,
        status: i_search_status,
        car_model: i_search_car_model,
        unused_machine_location: i_search_unused_machine_location,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="12" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("unusedMachinesData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("unusedMachinesData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('search_machine_no', '');
            sessionStorage.setItem('search_equipment_no', '');
            sessionStorage.setItem('search_machine_name', '');
            sessionStorage.setItem('search_status', '');
            sessionStorage.setItem('search_car_model', '');
            sessionStorage.setItem('search_unused_machine_location', '');
            break;
          case 3:
            document.getElementById("unusedMachinesData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('search_machine_no', i_search_machine_no);
            sessionStorage.setItem('search_equipment_no', i_search_equipment_no);
            sessionStorage.setItem('search_machine_name', i_search_machine_name);
            sessionStorage.setItem('search_status', i_search_status);
            sessionStorage.setItem('search_car_model', i_search_car_model);
            sessionStorage.setItem('search_unused_machine_location', i_search_unused_machine_location);
            break;
          case 2:
          case 4:
            document.getElementById("unusedMachinesData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_unused_machines();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("search_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

document.getElementById("search_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

document.getElementById("search_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

document.getElementById("search_status").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

document.getElementById("search_car_model").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

document.getElementById("search_unused_machine_location").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_unused_machines(3);
  }
});

$("#UnusedMachineInfoModal").on('hidden.bs.modal', e => {
  document.getElementById("u_id").value = '';
});

const export_unused_machines_csv = () => {
  var machine_no = sessionStorage.getItem('search_machine_no');
  var equipment_no = sessionStorage.getItem('search_equipment_no');
  var machine_name = sessionStorage.getItem('search_machine_name');
  var status = sessionStorage.getItem('search_status');
  var car_model = sessionStorage.getItem('search_car_model');
  var unused_machine_location = sessionStorage.getItem('search_unused_machine_location');

  window.open('process/export/export_unused_machines.php?&machine_no='+machine_no+
    '&equipment_no='+equipment_no+'&machine_name='+machine_name+'&car_model='+car_model+
    '&status='+status+'&unused_machine_location='+unused_machine_location,'_blank');
}
