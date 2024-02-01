// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('setup_role') != 'Admin') {
    document.getElementById("btnGoAddUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnGoAddUnusedMachine").style.display = 'none';
    document.getElementById("btnAddUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnAddUnusedMachine").style.display = 'none';

    document.getElementById("u_status").setAttribute('disabled', true);
    document.getElementById("u_reserved_for").setAttribute('disabled', true);
    document.getElementById("u_remarks").setAttribute('disabled', true);
    document.getElementById("u_pic").setAttribute('disabled', true);
    document.getElementById("u_target_date").setAttribute('disabled', true);
    document.getElementById("u_unused_machine_location").setAttribute('disabled', true);
    document.getElementById("btnUpdateUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnUpdateUnusedMachine").style.display = 'none';
    document.getElementById("btnSoldUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnSoldUnusedMachine").style.display = 'none';
    document.getElementById("btnBorrowedUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnBorrowedUnusedMachine").style.display = 'none';
    document.getElementById("btnDisposeUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnDisposeUnusedMachine").style.display = 'none';
    document.getElementById("btnResetBorrowedUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnResetBorrowedUnusedMachine").style.display = 'none';
  }

  get_unused_machines(1);
  get_car_models_datalist_search();
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
  get_accounts_setup_dropdown();

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
      document.getElementById("i_machines_no").innerHTML = response;
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
      document.getElementById("i_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_accounts_setup_dropdown = () => {
  $.ajax({
    url: '../process/admin/admin-accounts_processor.php',
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
      document.getElementById("i_pic").innerHTML = response;
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
  var disposed = el.dataset.disposed;
  var borrowed = el.dataset.borrowed;
  var sold = el.dataset.sold;

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

  if (getCookie('setup_role') == 'Admin') {
    document.getElementById("u_status").setAttribute('disabled', true);
    document.getElementById("u_reserved_for").setAttribute('disabled', true);
    document.getElementById("u_remarks").setAttribute('disabled', true);
    document.getElementById("u_pic").setAttribute('disabled', true);
    document.getElementById("u_target_date").setAttribute('disabled', true);
    
    document.getElementById("u_unused_machine_location").setAttribute('disabled', true);
    document.getElementById("btnUpdateUnusedMachine").style.display = 'none';
    document.getElementById("btnSoldUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnSoldUnusedMachine").style.display = 'none';
    document.getElementById("btnBorrowedUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnBorrowedUnusedMachine").style.display = 'none';
    document.getElementById("btnDisposeUnusedMachine").setAttribute('disabled', true);
    document.getElementById("btnDisposeUnusedMachine").style.display = 'none';
    if (borrowed == 1) {
      document.getElementById("btnResetBorrowedUnusedMachine").removeAttribute('disabled');
      document.getElementById("btnResetBorrowedUnusedMachine").style.display = 'block';
    } else if (disposed == 1 || sold == 1) {
      document.getElementById("btnResetBorrowedUnusedMachine").setAttribute('disabled', true);
      document.getElementById("btnResetBorrowedUnusedMachine").style.display = 'none';
    } else {
      document.getElementById("u_status").removeAttribute('disabled');
      document.getElementById("u_reserved_for").removeAttribute('disabled');
      document.getElementById("u_remarks").removeAttribute('disabled');
      document.getElementById("u_pic").removeAttribute('disabled');
      document.getElementById("u_target_date").removeAttribute('disabled');
      document.getElementById("u_unused_machine_location").removeAttribute('disabled');

      document.getElementById("btnUpdateUnusedMachine").removeAttribute('disabled');
      document.getElementById("btnUpdateUnusedMachine").style.display = 'block';
      document.getElementById("btnSoldUnusedMachine").removeAttribute('disabled');
      document.getElementById("btnSoldUnusedMachine").style.display = 'block';
      document.getElementById("btnBorrowedUnusedMachine").removeAttribute('disabled');
      document.getElementById("btnBorrowedUnusedMachine").style.display = 'block';
      document.getElementById("btnDisposeUnusedMachine").removeAttribute('disabled');
      document.getElementById("btnDisposeUnusedMachine").style.display = 'block';
      document.getElementById("btnResetBorrowedUnusedMachine").setAttribute('disabled', true);
      document.getElementById("btnResetBorrowedUnusedMachine").style.display = 'none';
    }
  }
}

const count_unused_machines = () => {
  var i_search_machine_no = sessionStorage.getItem('search_machine_no');
  var i_search_equipment_no = sessionStorage.getItem('search_equipment_no');
  var i_search_machine_name = sessionStorage.getItem('search_machine_name');
  var i_search_status = sessionStorage.getItem('search_status');
  var i_search_car_model = sessionStorage.getItem('search_car_model');
  var i_search_unused_machine_location = sessionStorage.getItem('search_unused_machine_location');

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
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
      url: '../process/admin/unused-machines_processor.php',
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

$("#AddUnusedMachineModal").on('hidden.bs.modal', e => {
  document.getElementById("i_machine_no").value = '';
  document.getElementById("i_equipment_no").value = '';
  document.getElementById("i_car_model").value = '';
  document.getElementById("i_machine_name").value = '';
  document.getElementById("i_process").value = '';
  document.getElementById("i_asset_tag_no").value = '';
  document.getElementById("i_status").value = '';
  document.getElementById("i_reserved_for").value = '';
  document.getElementById("i_remarks").value = '';
  document.getElementById("i_pic").value = '';
  document.getElementById("i_target_date").value = '';
  document.getElementById("i_unused_machine_location").value = '';
});

const clear_unused_machine_info_fields = () => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_car_model").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_asset_tag_no").value = '';
  document.getElementById("u_status").value = '';
  document.getElementById("u_reserved_for").value = '';
  document.getElementById("u_remarks").value = '';
  document.getElementById("u_pic").value = '';
  document.getElementById("u_target_date").value = '';
  document.getElementById("u_unused_machine_location").value = '';
}

document.getElementById("i_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('insert');
  } else {
    document.getElementById("i_equipment_no").value = '';
    document.getElementById("i_car_model").value = '';
    document.getElementById("i_machine_name").value = '';
    document.getElementById("i_process").value = '';
    document.getElementById("i_asset_tag_no").value = '';
  }
});

document.getElementById("i_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('insert');
  } else {
    document.getElementById("i_machine_no").value = '';
    document.getElementById("i_car_model").value = '';
    document.getElementById("i_machine_name").value = '';
    document.getElementById("i_process").value = '';
    document.getElementById("i_asset_tag_no").value = '';
  }
});

document.getElementById("u_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('update');
  } else {
    document.getElementById("u_equipment_no").value = '';
    document.getElementById("u_car_model").value = '';
    document.getElementById("u_machine_name").value = '';
    document.getElementById("u_asset_tag_no").value = '';
  }
});

document.getElementById("u_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_machine_details_by_id('update');
  } else {
    document.getElementById("u_machine_no").value = '';
    document.getElementById("u_car_model").value = '';
    document.getElementById("u_machine_name").value = '';
    document.getElementById("u_asset_tag_no").value = '';
  }
});

const get_machine_details_by_id = action => {
  var machine_no = '';
  var equipment_no = '';
  if (action == 'insert') {
    var machine_no = document.getElementById("i_machine_no").value.trim();
    var equipment_no = document.getElementById("i_equipment_no").value.trim();
  } else if (action == 'update') {
    var machine_no = document.getElementById("u_machine_no").value.trim();
    var equipment_no = document.getElementById("u_equipment_no").value.trim();
  }

  if (machine_no != '' || equipment_no != '') {
    $.ajax({
      url: '../process/admin/machines_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_machine_details_by_id',
        machine_no:machine_no,
        equipment_no:equipment_no
      }, 
      beforeSend: (jqXHR, settings) => {
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        try {
          let response_array = JSON.parse(response);
          var setup_process = response_array.process;
          var machine_name = response_array.machine_name;
          var car_model = response_array.car_model;
          var machine_no = response_array.machine_no;
          var equipment_no = response_array.equipment_no;
          var asset_tag_no = response_array.asset_tag_no;
          var registered = response_array.registered;

          if (registered == true) {
            if (action == 'insert') {
              document.getElementById("i_machine_no").value = machine_no;
              document.getElementById("i_equipment_no").value = equipment_no;
              document.getElementById("i_asset_tag_no").value = asset_tag_no;
              document.getElementById("i_machine_name").value = machine_name;
              document.getElementById("i_process").value = setup_process;
              document.getElementById("i_car_model").value = car_model;
            } else if (action == 'update') {
              document.getElementById("u_machine_no").value = machine_no;
              document.getElementById("u_equipment_no").value = equipment_no;
              document.getElementById("u_asset_tag_no").value = asset_tag_no;
              document.getElementById("u_machine_name").value = machine_name;
              document.getElementById("u_process").value = setup_process;
              document.getElementById("u_car_model").value = car_model;
            }
          } else {
            swal('Unused Machines Error', `Machine No. or Equipment No. not found / registered!!!`, 'error');
          }
        } catch(e) {
          console.log(response);
          swal('Unused Machines Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

const save_unused_machine = () => {
  var machine_no = document.getElementById("i_machine_no").value.trim();
  var equipment_no = document.getElementById("i_equipment_no").value.trim();
  var car_model = document.getElementById("i_car_model").value;
  var machine_name = document.getElementById("i_machine_name").value;
  var asset_tag_no = document.getElementById("i_asset_tag_no").value;
  var status = document.getElementById("i_status").value.trim();
  var reserved_for = document.getElementById("i_reserved_for").value.trim();
  var remarks = document.getElementById("i_remarks").value.trim();
  var pic = document.getElementById("i_pic").value;
  var target_date = document.getElementById("i_target_date").value;
  var unused_machine_location = document.getElementById("i_unused_machine_location").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'save_unused_machine',
      machine_no:machine_no,
      equipment_no:equipment_no,
      car_model:car_model,
      machine_name:machine_name,
      asset_tag_no:asset_tag_no,
      status:status,
      reserved_for:reserved_for,
      remarks:remarks,
      pic:pic,
      target_date:target_date,
      unused_machine_location:unused_machine_location
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Successfully Saved', 'success');
          get_unused_machines(1);
          $('#AddUnusedMachineModal').modal('hide');
        } else if (response == 'Machine Indentification Empty') {
          swal('Unused Machines', 'Cannot add unused machine without unique identifier information! Please fill out either Machine No. or Equipment No.', 'info');
        } else if (response == 'Forgotten Enter Key') {
          swal('Unused Machines', 'Please press Enter Key after typing Machine No. or Equipment No.', 'info');
        } else if (response == 'Unregistered Machine') {
          swal('Unused Machines Error', 'Machine No. or Equipment No. not found / registered!!!', 'error');
        } else if (response == 'Status Empty') {
          swal('Unused Machines', 'Please fill out Status field', 'info');
        } else if (response == 'Reserved For Empty') {
          swal('Unused Machines', 'Please fill out Reserved For field', 'info');
        } else if (response == 'PIC Not Set') {
          swal('Unused Machines', 'Please set PIC', 'info');
        } else if (response == 'Target Date Not Set') {
          swal('Unused Machines', 'Please set Target Date', 'info');
        } else if (response == 'Unused Machine Location Empty') {
          swal('Unused Machines', 'Please fill out Unused Machine Location field', 'info');
        } else if (response == 'Not For Unused') {
          swal('Unused Machines Error', 'Cannot Add to Unused Machines! It could be recently Unused, Sold, Disposed, Borrowed or New Machine.', 'error');
        } else {
          console.log(response);
          swal('Unused Machines', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const update_unused_machine = () => {
  var id = document.getElementById("u_id").value;
  var status = document.getElementById("u_status").value.trim();
  var reserved_for = document.getElementById("u_reserved_for").value.trim();
  var remarks = document.getElementById("u_remarks").value.trim();
  var pic = document.getElementById("u_pic").value;
  var target_date = document.getElementById("u_target_date").value;
  var unused_machine_location = document.getElementById("u_unused_machine_location").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_unused_machine',
      id:id,
      status:status,
      reserved_for:reserved_for,
      remarks:remarks,
      pic:pic,
      target_date:target_date,
      unused_machine_location:unused_machine_location
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Updated Successfully', 'success');
          get_unused_machines(1);
          clear_unused_machine_info_fields();
          $('#UnusedMachineInfoModal').modal('hide');
        } else if (response == 'Status Empty') {
          swal('Unused Machines', 'Please fill out Status field', 'info');
        } else if (response == 'Reserved For Empty') {
          swal('Unused Machines', 'Please fill out Reserved For field', 'info');
        } else if (response == 'PIC Not Set') {
          swal('Unused Machines', 'Please set PIC', 'info');
        } else if (response == 'Target Date Not Set') {
          swal('Unused Machines', 'Please set Target Date', 'info');
        } else if (response == 'Unused Machine Location Empty') {
          swal('Unused Machines', 'Please fill out Unused Machine Location field', 'info');
        } else {
          console.log(response);
          swal('Unused Machines', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const dispose_machine = () => {
  var id = document.getElementById("u_id").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();
  var status_date = document.getElementById("disposed_date").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'dispose_machine',
      id:id,
      machine_no:machine_no,
      equipment_no:equipment_no,
      status_date:status_date
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Successfully Marked', 'info');
          get_unused_machines(1);
          clear_unused_machine_info_fields();
          $('#DisposeMachineModal').modal('hide');
        } else if (response == 'Status Date Time Not Set') {
          swal('Unused Machines', 'Please fill out date field', 'info');
        } else {
          console.log(response);
          swal('Unused Machines Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const borrowed_machine = () => {
  var id = document.getElementById("u_id").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();
  var status_date = document.getElementById("borrowed_date").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'borrowed_machine',
      id:id,
      machine_no:machine_no,
      equipment_no:equipment_no,
      status_date:status_date
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Successfully Marked', 'info');
          get_unused_machines(1);
          clear_unused_machine_info_fields();
          $('#BorrowedMachineModal').modal('hide');
        } else if (response == 'Status Date Time Not Set') {
          swal('Unused Machines', 'Please fill out date field', 'info');
        } else {
          console.log(response);
          swal('Unused Machines Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const sold_machine = () => {
  var id = document.getElementById("u_id").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();
  var status_date = document.getElementById("sold_date").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'sold_machine',
      id:id,
      machine_no:machine_no,
      equipment_no:equipment_no,
      status_date:status_date
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Successfully Marked', 'info');
          get_unused_machines(1);
          clear_unused_machine_info_fields();
          $('#SoldMachineModal').modal('hide');
        } else if (response == 'Status Date Time Not Set') {
          swal('Unused Machines', 'Please fill out date field', 'info');
        } else {
          console.log(response);
          swal('Unused Machines Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const reset_unused_machine = () => {
  var id = document.getElementById("u_id").value.trim();
  var machine_no = document.getElementById("u_machine_no").value.trim();
  var equipment_no = document.getElementById("u_equipment_no").value.trim();

  $.ajax({
    url: '../process/admin/unused-machines_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'reset_unused_machine',
      id:id,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      swal('Unused Machines', 'Loading please wait...', {
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
          swal('Unused Machines', 'Reset Unused Machine Successfully', 'info');
          get_unused_machines(1);
          clear_unused_machine_info_fields();
          $('#ResetBorrowedMachineModal').modal('hide');
        } else {
          console.log(response);
          swal('Unused Machines Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
        }
      }, 500);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const export_unused_machines_csv = () => {
  var machine_no = sessionStorage.getItem('search_machine_no');
  var equipment_no = sessionStorage.getItem('search_equipment_no');
  var machine_name = sessionStorage.getItem('search_machine_name');
  var status = sessionStorage.getItem('search_status');
  var car_model = sessionStorage.getItem('search_car_model');
  var unused_machine_location = sessionStorage.getItem('search_unused_machine_location');

  window.open('../process/export/export_unused_machines.php?&machine_no='+machine_no+
    '&equipment_no='+equipment_no+'&machine_name='+machine_name+'&car_model='+car_model+
    '&status='+status+'&unused_machine_location='+unused_machine_location,'_blank');
}