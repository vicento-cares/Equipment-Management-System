// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  get_machines_datalist_search();
  get_machine_no_datalist();
  get_equipment_no_datalist();
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
      document.getElementById("sou_history_asset_names").innerHTML = response;
      document.getElementById("fat_history_item_descriptions").innerHTML = response;
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
      document.getElementById("sou_history_machines_no").innerHTML = response;
      document.getElementById("fat_history_machines_no").innerHTML = response;
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
      document.getElementById("sou_history_equipments_no").innerHTML = response;
      document.getElementById("fat_history_equipments_no").innerHTML = response;
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

$('#souTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_sou_history = el => {
  var id = el.dataset.id;
  var sou_no = el.dataset.sou_no;
  var kigyo_no = el.dataset.kigyo_no;
  var asset_name = el.dataset.asset_name;
  var sup_asset_name = el.dataset.sup_asset_name;
  var orig_asset_no = el.dataset.orig_asset_no;
  var sou_date = el.dataset.sou_date;
  var quantity = el.dataset.quantity;
  var managing_dept_code = el.dataset.managing_dept_code;
  var managing_dept_name = el.dataset.managing_dept_name;
  var install_area_code = el.dataset.install_area_code;
  var install_area_name = el.dataset.install_area_name;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var no_of_units = el.dataset.no_of_units;
  var ntc_or_sa = el.dataset.ntc_or_sa;
  var use_purpose = el.dataset.use_purpose;

  document.getElementById("sou_id").value = id;
  document.getElementById("sou_no").innerHTML = sou_no;
  document.getElementById("sou_kigyo_no").innerHTML = kigyo_no;
  document.getElementById("sou_asset_name").innerHTML = asset_name;
  document.getElementById("sou_sup_asset_name").innerHTML = sup_asset_name;
  document.getElementById("sou_orig_asset_no").innerHTML = orig_asset_no;
  document.getElementById("sou_date").innerHTML = sou_date;
  document.getElementById("sou_quantity").innerHTML = quantity;
  document.getElementById("sou_managing_dept_code").innerHTML = managing_dept_code;
  document.getElementById("sou_managing_dept_name").innerHTML = managing_dept_name;
  document.getElementById("sou_install_area_code").innerHTML = install_area_code;
  document.getElementById("sou_install_area_name").innerHTML = install_area_name;
  document.getElementById("sou_machine_no").innerHTML = machine_no;
  document.getElementById("sou_equipment_no").innerHTML = equipment_no;
  document.getElementById("sou_no_of_units").innerHTML = no_of_units;
  document.getElementById("sou_ntc_or_sa").innerHTML = ntc_or_sa;
  document.getElementById("sou_use_purpose").innerHTML = use_purpose;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'sou_mark_as_read',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Approver 3 Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_sou_history = () => {
  var date_updated_from = sessionStorage.getItem('sou_history_date_updated_from');
  var date_updated_to = sessionStorage.getItem('sou_history_date_updated_to');
  var asset_name = sessionStorage.getItem('sou_history_asset_name');
  var sou_no = sessionStorage.getItem('sou_history_no');
  var kigyo_no = sessionStorage.getItem('sou_history_kigyo_no');
  var machine_no = sessionStorage.getItem('sou_history_machine_no');
  var equipment_no = sessionStorage.getItem('sou_history_equipment_no');

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_sou_history',
      date_updated_from:date_updated_from,
      date_updated_to:date_updated_to,
      asset_name:asset_name,
      sou_no:sou_no,
      kigyo_no:kigyo_no,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("souData").childNodes.length);
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

const get_sou_history = option => {
  var id = 0;
  var date_updated_from = '';
  var date_updated_to = '';
  var asset_name = '';
  var sou_no = '';
  var kigyo_no = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var date_updated_from = document.getElementById("sou_history_date_updated_from").value;
      var date_updated_to = document.getElementById("sou_history_date_updated_to").value;
      var asset_name = document.getElementById("sou_history_asset_name").value.trim();
      var sou_no = document.getElementById("sou_history_no").value.trim();
      var kigyo_no = document.getElementById("sou_history_kigyo_no").value.trim();
      var machine_no = document.getElementById("sou_history_machine_no").value.trim();
      var equipment_no = document.getElementById("sou_history_equipment_no").value.trim();
      if (date_updated_from == '' || date_updated_to == '') {
        var continue_loading = false;
        swal('Approver 3', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("souData").lastChild.getAttribute("id");
      var date_updated_from = sessionStorage.getItem('sou_history_date_updated_from');
      var date_updated_to = sessionStorage.getItem('sou_history_date_updated_to');
      var asset_name = sessionStorage.getItem('sou_history_asset_name');
      var sou_no = sessionStorage.getItem('sou_history_no');
      var kigyo_no = sessionStorage.getItem('sou_history_kigyo_no');
      var machine_no = sessionStorage.getItem('sou_history_machine_no');
      var equipment_no = sessionStorage.getItem('sou_history_equipment_no');
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
        method: 'get_sou_history_a3',
        id: id,
        date_updated_from:date_updated_from,
        date_updated_to:date_updated_to,
        asset_name:asset_name,
        sou_no:sou_no,
        kigyo_no:kigyo_no,
        machine_no:machine_no,
        equipment_no:equipment_no,
        c:loader_count
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
            var loading = `<tr><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("souData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("souData").innerHTML = response;
            document.getElementById("loader_count").value = 25;
            sessionStorage.setItem('sou_history_date_updated_from', date_updated_from);
            sessionStorage.setItem('sou_history_date_updated_to', date_updated_to);
            sessionStorage.setItem('sou_history_asset_name', asset_name);
            sessionStorage.setItem('sou_history_no', sou_no);
            sessionStorage.setItem('sou_history_kigyo_no', kigyo_no);
            sessionStorage.setItem('sou_history_machine_no', machine_no);
            sessionStorage.setItem('sou_history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("souData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count").value = loader_count + 25;
            break;
          default:
        }
        count_sou_history();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("sou_history_date_updated_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_date_updated_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_asset_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_kigyo_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

document.getElementById("sou_history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_sou_history(1);
  }
});

$('#fatTable').on('click', 'tbody tr', e => {
  $(e.currentTarget).removeClass('bg-lime');
});

const get_details_fat_history = el => {
  var id = el.dataset.id;
  var fat_no = el.dataset.fat_no;
  var item_name = el.dataset.item_name;
  var item_description = el.dataset.item_description;
  var machine_no = el.dataset.machine_no;
  var equipment_no = el.dataset.equipment_no;
  var asset_tag_no = el.dataset.asset_tag_no;
  var prev_location_group = el.dataset.prev_location_group;
  var prev_location_loc = el.dataset.prev_location_loc;
  var prev_location_grid = el.dataset.prev_location_grid;
  var date_transfer = el.dataset.date_transfer;
  var new_location_group = el.dataset.new_location_group;
  var new_location_loc = el.dataset.new_location_loc;
  var new_location_grid = el.dataset.new_location_grid;
  var reason = el.dataset.reason;

  document.getElementById("fat_id").value = id;
  document.getElementById("fat_no").innerHTML = fat_no;
  document.getElementById("fat_item_name").innerHTML = item_name;
  document.getElementById("fat_item_description").innerHTML = item_description;
  document.getElementById("fat_machine_no").innerHTML = machine_no;
  document.getElementById("fat_equipment_no").innerHTML = equipment_no;
  document.getElementById("fat_asset_tag_no").innerHTML = asset_tag_no;
  document.getElementById("fat_prev_location_group").innerHTML = prev_location_group;
  document.getElementById("fat_prev_location_loc").innerHTML = prev_location_loc;
  document.getElementById("fat_prev_location_grid").innerHTML = prev_location_grid;
  document.getElementById("fat_date_transfer").innerHTML = date_transfer;
  document.getElementById("fat_new_location_group").innerHTML = new_location_group;
  document.getElementById("fat_new_location_loc").innerHTML = new_location_loc;
  document.getElementById("fat_new_location_grid").innerHTML = new_location_grid;
  document.getElementById("fat_reason").innerHTML = reason;

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'fat_mark_as_read',
      id:id
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        swal('Approver 3 Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`, 'error');
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

const count_fat_history = () => {
  var date_updated_from = sessionStorage.getItem('fat_history_date_updated_from');
  var date_updated_to = sessionStorage.getItem('fat_history_date_updated_to');
  var item_description = sessionStorage.getItem('fat_history_item_description');
  var fat_no = sessionStorage.getItem('fat_history_no');
  var item_name = sessionStorage.getItem('fat_history_item_name');
  var machine_no = sessionStorage.getItem('fat_history_machine_no');
  var equipment_no = sessionStorage.getItem('fat_history_equipment_no');

  $.ajax({
    url: '../process/admin/machine-checksheets_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_fat_history',
      date_updated_from:date_updated_from,
      date_updated_to:date_updated_to,
      item_description:item_description,
      fat_no:fat_no,
      item_name:item_name,
      machine_no:machine_no,
      equipment_no:equipment_no
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var total_rows = parseInt(response);
      let table_rows = parseInt(document.getElementById("fatData").childNodes.length);
      let loader_count2 = document.getElementById("loader_count2").value;
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

const get_fat_history = option => {
  var id = 0;
  var date_updated_from = '';
  var date_updated_to = '';
  var item_description = '';
  var fat_no = '';
  var item_name = '';
  var machine_no = '';
  var equipment_no = '';
  var loader_count2 = 0;
  var continue_loading = true;
  switch (option) {
    case 1:
      var date_updated_from = document.getElementById("fat_history_date_updated_from").value;
      var date_updated_to = document.getElementById("fat_history_date_updated_to").value;
      var item_description = document.getElementById("fat_history_item_description").value.trim();
      var fat_no = document.getElementById("fat_history_no").value.trim();
      var item_name = document.getElementById("fat_history_item_name").value.trim();
      var machine_no = document.getElementById("fat_history_machine_no").value.trim();
      var equipment_no = document.getElementById("fat_history_equipment_no").value.trim();
      if (date_updated_from == '' || date_updated_to == '') {
        var continue_loading = false;
        swal('Approver 3', 'Fill out all date fields', 'info');
      }
      break;
    case 2:
      var id = document.getElementById("fatData").lastChild.getAttribute("id");
      var date_updated_from = sessionStorage.getItem('fat_history_date_updated_from');
      var date_updated_to = sessionStorage.getItem('fat_history_date_updated_to');
      var item_description = sessionStorage.getItem('fat_history_item_description');
      var fat_no = sessionStorage.getItem('fat_history_no');
      var item_name = sessionStorage.getItem('fat_history_item_name');
      var machine_no = sessionStorage.getItem('fat_history_machine_no');
      var equipment_no = sessionStorage.getItem('fat_history_equipment_no');
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
        method: 'get_fat_history_a3',
        id: id,
        date_updated_from:date_updated_from,
        date_updated_to:date_updated_to,
        item_description:item_description,
        fat_no:fat_no,
        item_name:item_name,
        machine_no:machine_no,
        equipment_no:equipment_no,
        c:loader_count2
      }, 
      beforeSend: (jqXHR, settings) => {
        switch (option) {
          case 1:
            var loading = `<tr><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
            document.getElementById("fatData").innerHTML = loading;
            break;
          default:
        }
        jqXHR.url = settings.url;
        jqXHR.type = settings.type;
      }, 
      success: response => {
        switch (option) {
          case 1:
            document.getElementById("fatData").innerHTML = response;
            document.getElementById("loader_count2").value = 25;
            sessionStorage.setItem('fat_history_date_updated_from', date_updated_from);
            sessionStorage.setItem('fat_history_date_updated_to', date_updated_to);
            sessionStorage.setItem('fat_history_item_description', item_description);
            sessionStorage.setItem('fat_history_no', fat_no);
            sessionStorage.setItem('fat_history_item_name', item_name);
            sessionStorage.setItem('fat_history_machine_no', machine_no);
            sessionStorage.setItem('fat_history_equipment_no', equipment_no);
            break;
          case 2:
            document.getElementById("fatData").insertAdjacentHTML('beforeend', response);
            document.getElementById("loader_count2").value = loader_count2 + 25;
            break;
          default:
        }
        count_fat_history();
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR);
      swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
    });
  }
}

document.getElementById("fat_history_date_updated_from").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_date_updated_to").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_item_description").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_item_name").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_machine_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

document.getElementById("fat_history_equipment_no").addEventListener("keyup", e => {
  if (e.which === 13) {
    e.preventDefault();
    get_fat_history(1);
  }
});

const export_sou = () => {
  var date_updated_from = document.getElementById("sou_history_date_updated_from").value;
  var date_updated_to = document.getElementById("sou_history_date_updated_to").value;
  var asset_name = document.getElementById("sou_history_asset_name").value;
  var sou_no = document.getElementById("sou_history_no").value;
  var kigyo_no = document.getElementById("sou_history_kigyo_no").value;
  var machine_no = document.getElementById("sou_history_machine_no").value;
  var equipment_no = document.getElementById("sou_history_equipment_no").value;

  if (date_updated_from != '' && date_updated_to != '') {
    window.open('../process/export/export_sou.php?date_updated_from='+date_updated_from+'&date_updated_to='+date_updated_to+'&asset_name='+asset_name+'&sou_no='+sou_no+'&kigyo_no='+kigyo_no+'&machine_no='+machine_no+'&equipment_no='+equipment_no,'_blank');
  } else {
    swal('Approver 3', 'Fill out all date fields', 'info');
  }
}

const export_fat = () => {
  var id = document.getElementById("fat_id").value;
  window.open('../process/export/export_fat.php?id='+id,'_blank');
}
