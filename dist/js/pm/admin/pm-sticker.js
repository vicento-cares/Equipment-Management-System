// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  if (getCookie('pm_role') != 'Admin') {
    document.getElementById("u_ww_next_date").setAttribute('disabled', true);
    document.getElementById("u_shift_engineer").setAttribute('disabled', true);
    document.getElementById("btnUpdatePmStickerContent").setAttribute('disabled', true);
    document.getElementById("btnUpdatePmStickerContent").style.display = 'none';
  }

  get_machines_datalist_search();
  get_pm_plan_years_datalist_search();
  get_all_ww_no_datalist_search();
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
      document.getElementById("sticker_machines").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_pm_plan_years_datalist_search = () => {
  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
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
      document.getElementById("sticker_pm_plan_years").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_all_ww_no_datalist_search = () => {
  $.ajax({
    url: '../process/admin/pm-plan_processor.php',
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
      document.getElementById("sticker_all_ww_no").innerHTML = response;
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
      document.getElementById("sticker_machines_no").innerHTML = response;
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
      document.getElementById("sticker_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const get_details = el => {
  var id = el.dataset.id;
  var pm_process = el.dataset.process;
  var machine_name = el.dataset.machine_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var pm_plan_year = el.dataset.pm_plan_year;
  var ww_no = el.dataset.ww_no;
  var manpower = el.dataset.manpower;
  var ww_start_date = el.dataset.ww_start_date;
  var ww_next_date = el.dataset.ww_next_date;
  var shift_engineer = el.dataset.shift_engineer;

  document.getElementById("u_id").value = id;
  document.getElementById("u_process").value = pm_process;
  document.getElementById("u_machine_name").value = machine_name;
  document.getElementById("u_machine_no").value = machine_no;
  document.getElementById("u_equipment_no").value = equipment_no;
  document.getElementById("u_pm_plan_year").value = pm_plan_year;
  document.getElementById("u_ww_no").value = ww_no;
  document.getElementById("u_manpower").value = manpower;
  document.getElementById("u_ww_start_date").value = ww_start_date;
  document.getElementById("u_ww_next_date").value = ww_next_date;
  document.getElementById("u_shift_engineer").value = shift_engineer;
}

const count_ww = () => {
  var i_sticker_pm_plan_year = sessionStorage.getItem('sticker_pm_plan_year');
  var i_sticker_ww_no = sessionStorage.getItem('sticker_ww_no');
  var i_sticker_machine_name = sessionStorage.getItem('sticker_machine_name');
  var i_sticker_machine_no = sessionStorage.getItem('sticker_machine_no');
  var i_sticker_equipment_no = sessionStorage.getItem('sticker_equipment_no');
  
  $.ajax({
    url: '../process/admin/pm-sticker_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_ww',
      pm_plan_year: i_sticker_pm_plan_year,
      ww_no: i_sticker_ww_no,
      machine_name: i_sticker_machine_name,
      machine_no: i_sticker_machine_no,
      equipment_no: i_sticker_equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("pmStickerData").childNodes.length);
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
        document.getElementById("btnPrintPmSticker").removeAttribute('disabled');
      } else {
        document.getElementById("counter_view_search").style.display = 'none';
        document.getElementById("counter_view").style.display = 'none';
        document.getElementById("btnPrintPmSticker").setAttribute('disabled', true);
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
  var i_sticker_pm_plan_year = '';
  var i_sticker_ww_no = '';
  var i_sticker_machine_name = '';
  var i_sticker_machine_no = '';
  var i_sticker_equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var i_sticker_pm_plan_year = document.getElementById("sticker_pm_plan_year").value.trim();
      var i_sticker_ww_no = document.getElementById("sticker_ww_no").value.trim();
      var i_sticker_machine_name = document.getElementById("sticker_machine_name").value.trim();
      var i_sticker_machine_no = document.getElementById("sticker_machine_no").value.trim();
      var i_sticker_equipment_no = document.getElementById("sticker_equipment_no").value.trim();
      if (i_sticker_pm_plan_year == '') {
        var continue_loading = false;
        swal('PM Sticker', 'Fill out PM Plan Year input field', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("pmStickerData").lastChild.getAttribute("id");
      var i_sticker_pm_plan_year = sessionStorage.getItem('sticker_pm_plan_year');
      var i_sticker_ww_no = sessionStorage.getItem('sticker_ww_no');
      var i_sticker_machine_name = sessionStorage.getItem('sticker_machine_name');
      var i_sticker_machine_no = sessionStorage.getItem('sticker_machine_no');
      var i_sticker_equipment_no = sessionStorage.getItem('sticker_equipment_no');
      var loader_count = parseInt(document.getElementById("loader_count").value);
      break;
    default:
  }
  if (continue_loading == true) {
    $.ajax({
      url: '../process/admin/pm-sticker_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'get_ww',
        id: id,
        pm_plan_year: i_sticker_pm_plan_year,
        ww_no: i_sticker_ww_no,
        machine_name: i_sticker_machine_name,
        machine_no: i_sticker_machine_no,
        equipment_no: i_sticker_equipment_no,
        c: loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
          case 3:
            var loading = `<tr><td colspan="11" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("pmStickerData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("pmStickerData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('sticker_pm_plan_year', i_sticker_pm_plan_year);
            sessionStorage.setItem('sticker_ww_no', i_sticker_ww_no);
            sessionStorage.setItem('sticker_machine_name', i_sticker_machine_name);
            sessionStorage.setItem('sticker_machine_no', i_sticker_machine_no);
            sessionStorage.setItem('sticker_equipment_no', i_sticker_equipment_no);
            break;
          case 2:
            document.getElementById("pmStickerData").insertAdjacentHTML('beforeend', response);
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

document.getElementById("sticker_pm_plan_year").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("sticker_ww_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("sticker_machine_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("sticker_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

document.getElementById("sticker_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_ww(1);
  }
});

// uncheck all
const uncheck_all_pm = () => {
  var select_all = document.getElementById('check_all_pm');
  select_all.checked = false;
  document.querySelectorAll(".singleCheck").forEach((el, i) => {
    el.checked = false;
  });
  get_checked_pm();
}
// check all
const select_all_pm_func = () => {
  var select_all = document.getElementById('check_all_pm');
  if (select_all.checked == true) {
    console.log('check');
    document.querySelectorAll(".singleCheck").forEach((el, i) => {
      el.checked = true;
    });
  } else {
    console.log('uncheck');
    document.querySelectorAll(".singleCheck").forEach((el, i) => {
      el.checked = false;
    }); 
  }
  get_checked_pm();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_pm = () => {
  var arr = [];
  document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
    arr.push(el.value);
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    document.getElementById("btnPrintSelPmSticker").removeAttribute('disabled');
    document.getElementById("btnUpdateSelPmSticker").removeAttribute('disabled');
  } else {
    document.getElementById("btnPrintSelPmSticker").setAttribute('disabled', true);
    document.getElementById("btnUpdateSelPmSticker").setAttribute('disabled', true);
  }
  document.getElementById("rows_selected").innerHTML = numberOfChecked;
}

$("#PmStickerContentModal").on('hidden.bs.modal', e => {
  document.getElementById("u_id").value = '';
  document.getElementById("u_process").value = '';
  document.getElementById("u_machine_name").value = '';
  document.getElementById("u_machine_no").value = '';
  document.getElementById("u_equipment_no").value = '';
  document.getElementById("u_pm_plan_year").value = '';
  document.getElementById("u_ww_no").value = '';
  document.getElementById("u_manpower").value = '';
  document.getElementById("u_ww_start_date").value = '';
  document.getElementById("u_ww_next_date").value = '';
  document.getElementById("u_shift_engineer").value = '';
});

$("#PmStickerUpdateModal").on('hidden.bs.modal', e => {
  document.getElementById("u_ww_next_date_update").value = '';
  document.getElementById("u_shift_engineer_update").value = '';
});

const update_pm_sticker_content = () => {
  var shift_engineer = document.getElementById("u_shift_engineer_update").value.trim();
  var ww_next_date = document.getElementById("u_ww_next_date_update").value;

  var arr = [];
  document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
    arr.push(el.value);
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    $.ajax({
      url: '../process/admin/pm-sticker_processor.php',
      type: 'POST',
      cache: false,
      data: {
        method: 'update_pm_sticker_content',
        arr:arr,
        shift_engineer:shift_engineer,
        ww_next_date:ww_next_date
      }, 
      beforeSend: (jqXHR, settings) => {
        swal('PM Sticker', 'Loading please wait...', {
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
            swal('PM Sticker', 'Successfully Saved', 'success');
            $('#PmStickerUpdateModal').modal('hide');
            get_ww(1);
            uncheck_all_pm();
          } else if (response == 'Next Date Not Set') {
            swal('PM Sticker', 'Please set PM Next Date', 'info');
          } else if (response == 'Shift Engineer Empty') {
            swal('PM Sticker', 'Please fill out Shift Engineer', 'info');
          } else {
            console.log(response);
            swal('PM Sticker Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
          }
        }, 500);
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  } else {
    swal('PM Sticker', `No checkbox checked`, 'info');
  }
}

const print_single_pm_sticker = () => {
  var id = document.getElementById("u_id").value.trim();
  window.open('../process/print/print_single_pm_sticker.php?id='+id,'_blank');
}

const print_all_pm_sticker = () => {
  var i_sticker_pm_plan_year = sessionStorage.getItem('sticker_pm_plan_year');
  var i_sticker_ww_no = sessionStorage.getItem('sticker_ww_no');
  if (i_sticker_pm_plan_year != '') {
    window.open('../process/print/print_all_pm_sticker.php?pm_plan_year='+i_sticker_pm_plan_year+'&&ww_no='+i_sticker_ww_no,'_blank');
  } else {
    swal('PM Sticker', 'Fill out PM Plan Year input field', 'info');
  }
}

const print_selected_pm_sticker = () => {
  var arr = [];
  document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
    arr.push(el.value);
  });
  console.log(arr);
  var numberOfChecked = arr.length;
  if (numberOfChecked > 0) {
    pm_sticker_id_arr = Object.values(arr);
    window.open('../process/print/print_selected_pm_sticker.php?pm_sticker_id_arr='+pm_sticker_id_arr,'_blank');
    uncheck_all_pm();
  } else {
    swal('PM Sticker Printing', `No checkbox checked`, 'info');
  }
}
