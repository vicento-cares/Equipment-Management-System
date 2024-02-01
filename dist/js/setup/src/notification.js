// Notification Global Variables for Realtime
var realtime_load_notif_public_act_sched;
var realtime_load_notif_public_act_sched_page;
var realtime_load_notif_pending_mstprc;
var realtime_load_notif_pending_mstprc_page;
var realtime_load_notif_setup;
var realtime_load_notif_setup_new_act_sched_page;
var realtime_load_notif_setup_mstprc_page;

const load_notif_setup = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_setup'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_act_sched = "";
      var notif_approved_mstprc = "";
      var notif_disapproved_mstprc = "";
      var notif_new_act_sched_val = sessionStorage.getItem('notif_new_act_sched');
      var notif_approved_mstprc_val = sessionStorage.getItem('notif_approved_mstprc');
      var notif_disapproved_mstprc_val = sessionStorage.getItem('notif_disapproved_mstprc');
      var notif_new_act_sched_body = "";
      var notif_approved_mstprc_body = "";
      var notif_disapproved_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_act_sched > 0) {
            if (response_array.new_act_sched < 2) {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule request <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule request `;
            } else {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule requests <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule requests `;
            }
          } else {
            var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_mstprc > 0) {
            if (response_array.approved_mstprc < 2) {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheet `;
            } else {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheets `;
            }
          } else {
            var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_mstprc > 0) {
            if (response_array.disapproved_mstprc < 2) {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheet `;
            } else {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_act_sched_val != response_array.new_act_sched) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_new_act_sched_body,
              title: 'New Schedules',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_approved_mstprc_val != response_array.approved_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_approved_mstprc_body,
              title: 'Approved Checksheets',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_disapproved_mstprc_val != response_array.disapproved_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-danger',
              body: notif_disapproved_mstprc_body,
              title: 'Disapproved Checksheets',
              icon: 'fas fa-times fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_act_sched', response_array.new_act_sched);
          sessionStorage.setItem('notif_approved_mstprc', response_array.approved_mstprc);
          sessionStorage.setItem('notif_disapproved_mstprc', response_array.disapproved_mstprc);
        } else {
          sessionStorage.setItem('notif_new_act_sched', 0);
          sessionStorage.setItem('notif_approved_mstprc', 0);
          sessionStorage.setItem('notif_disapproved_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No schedule requests <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_act_sched').html(notif_new_act_sched);
      $('#notif_approved_mstprc').html(notif_approved_mstprc);
      $('#notif_disapproved_mstprc').html(notif_disapproved_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_setup);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_setup_new_act_sched_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_setup'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_act_sched = "";
      var notif_approved_mstprc = "";
      var notif_disapproved_mstprc = "";
      var notif_new_act_sched_val = sessionStorage.getItem('notif_new_act_sched');
      var notif_approved_mstprc_val = sessionStorage.getItem('notif_approved_mstprc');
      var notif_disapproved_mstprc_val = sessionStorage.getItem('notif_disapproved_mstprc');
      var notif_new_act_sched_body = "";
      var notif_approved_mstprc_body = "";
      var notif_disapproved_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_act_sched > 0) {
            if (response_array.new_act_sched < 2) {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule request <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule request `;
            } else {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule requests <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule requests `;
            }
          } else {
            var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_mstprc > 0) {
            if (response_array.approved_mstprc < 2) {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheet `;
            } else {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheets `;
            }
          } else {
            var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_mstprc > 0) {
            if (response_array.disapproved_mstprc < 2) {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheet `;
            } else {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_act_sched_val != response_array.new_act_sched) {
            if (notif_new_act_sched_val < response_array.new_act_sched) {
              $(document).Toasts('create', {
                class: 'bg-warning',
                body: notif_new_act_sched_body,
                title: 'New Schedules',
                icon: 'fas fa-spinner fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_new_act_sched(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_approved_mstprc_val != response_array.approved_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_approved_mstprc_body,
              title: 'Approved Checksheets',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_disapproved_mstprc_val != response_array.disapproved_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-danger',
              body: notif_disapproved_mstprc_body,
              title: 'Disapproved Checksheets',
              icon: 'fas fa-times fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_act_sched', response_array.new_act_sched);
          sessionStorage.setItem('notif_approved_mstprc', response_array.approved_mstprc);
          sessionStorage.setItem('notif_disapproved_mstprc', response_array.disapproved_mstprc);
        } else {
          sessionStorage.setItem('notif_new_act_sched', 0);
          sessionStorage.setItem('notif_approved_mstprc', 0);
          sessionStorage.setItem('notif_disapproved_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_act_sched').html(notif_new_act_sched);
      $('#notif_approved_mstprc').html(notif_approved_mstprc);
      $('#notif_disapproved_mstprc').html(notif_disapproved_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_setup_new_act_sched_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_setup_mstprc_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_setup'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_act_sched = "";
      var notif_approved_mstprc = "";
      var notif_disapproved_mstprc = "";
      var notif_new_act_sched_val = sessionStorage.getItem('notif_new_act_sched');
      var notif_approved_mstprc_val = sessionStorage.getItem('notif_approved_mstprc');
      var notif_disapproved_mstprc_val = sessionStorage.getItem('notif_disapproved_mstprc');
      var notif_new_act_sched_body = "";
      var notif_approved_mstprc_body = "";
      var notif_disapproved_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_act_sched > 0) {
            if (response_array.new_act_sched < 2) {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule request <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule request `;
            } else {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule requests <span class="float-right text-muted text-sm"></span>`;
              var notif_new_act_sched_body = `${response_array.new_act_sched} new schedule requests `;
            }
          } else {
            var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_mstprc > 0) {
            if (response_array.approved_mstprc < 2) {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheet `;
            } else {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_mstprc_body = `${response_array.approved_mstprc} new approved checksheets `;
            }
          } else {
            var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_mstprc > 0) {
            if (response_array.disapproved_mstprc < 2) {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheet `;
            } else {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_mstprc_body = `${response_array.disapproved_mstprc} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_act_sched_val != response_array.new_act_sched) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_new_act_sched_body,
              title: 'New Schedules',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_approved_mstprc_val != response_array.approved_mstprc) {
            if (notif_approved_mstprc_val < response_array.approved_mstprc) {
              $(document).Toasts('create', {
                class: 'bg-success',
                body: notif_approved_mstprc_body,
                title: 'Approved Checksheets',
                icon: 'fas fa-check fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_approved_mstprc(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_disapproved_mstprc_val != response_array.disapproved_mstprc) {
            if (notif_disapproved_mstprc_val < response_array.disapproved_mstprc) {
              $(document).Toasts('create', {
                class: 'bg-danger',
                body: notif_disapproved_mstprc_body,
                title: 'Disapproved Checksheets',
                icon: 'fas fa-times fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_disapproved_mstprc(); // AUTOCLEAR NOTIF
            }
          }
          sessionStorage.setItem('notif_new_act_sched', response_array.new_act_sched);
          sessionStorage.setItem('notif_approved_mstprc', response_array.approved_mstprc);
          sessionStorage.setItem('notif_disapproved_mstprc', response_array.disapproved_mstprc);
        } else {
          sessionStorage.setItem('notif_new_act_sched', 0);
          sessionStorage.setItem('notif_approved_mstprc', 0);
          sessionStorage.setItem('notif_disapproved_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_act_sched').html(notif_new_act_sched);
      $('#notif_approved_mstprc').html(notif_approved_mstprc);
      $('#notif_disapproved_mstprc').html(notif_disapproved_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_setup_mstprc_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const update_notif_setup_badge = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_setup'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_act_sched = "";
      var notif_approved_mstprc = "";
      var notif_disapproved_mstprc = "";
      var notif_new_act_sched_val = sessionStorage.getItem('notif_new_act_sched');
      var notif_approved_mstprc_val = sessionStorage.getItem('notif_approved_mstprc');
      var notif_disapproved_mstprc_val = sessionStorage.getItem('notif_disapproved_mstprc');
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_act_sched > 0) {
            if (response_array.new_act_sched < 2) {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule request <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> ${response_array.new_act_sched} new schedule requests <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_mstprc > 0) {
            if (response_array.approved_mstprc < 2) {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> ${response_array.approved_mstprc} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_mstprc > 0) {
            if (response_array.disapproved_mstprc < 2) {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_mstprc} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          sessionStorage.setItem('notif_new_act_sched', response_array.new_act_sched);
          sessionStorage.setItem('notif_approved_mstprc', response_array.approved_mstprc);
          sessionStorage.setItem('notif_disapproved_mstprc', response_array.disapproved_mstprc);
        } else {
          sessionStorage.setItem('notif_new_act_sched', 0);
          sessionStorage.setItem('notif_approved_mstprc', 0);
          sessionStorage.setItem('notif_disapproved_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_act_sched = `<i class="fas fa-spinner mr-2"></i> No new schedule requests <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_mstprc = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_mstprc = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_act_sched').html(notif_new_act_sched);
      $('#notif_approved_mstprc').html(notif_approved_mstprc);
      $('#notif_disapproved_mstprc').html(notif_disapproved_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const update_notif_new_act_sched = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_new_act_sched'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      } else {
        update_notif_setup_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const update_notif_approved_mstprc = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_approved_mstprc'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      } else {
        update_notif_setup_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const update_notif_disapproved_mstprc = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_disapproved_mstprc'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      } else {
        update_notif_setup_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notif_public_act_sched = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_public_act_sched'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_accepted_act_sched = "";
      var notif_declined_act_sched = "";
      var notif_accepted_act_sched_val = sessionStorage.getItem('notif_accepted_act_sched');
      var notif_declined_act_sched_val = sessionStorage.getItem('notif_declined_act_sched');
      var notif_accepted_act_sched_body = "";
      var notif_declined_act_sched_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.accepted_act_sched > 0) {
            if (response_array.accepted_act_sched < 2) {
              var notif_accepted_act_sched = `<i class="fas fa-check mr-2"></i> ${response_array.accepted_act_sched} new accepted schedule <span class="float-right text-muted text-sm"></span>`;
              var notif_accepted_act_sched_body = `${response_array.accepted_act_sched} new accepted schedule `;
            } else {
              var notif_accepted_act_sched = `<i class="fas fa-check mr-2"></i> ${response_array.accepted_act_sched} new accepted schedules <span class="float-right text-muted text-sm"></span>`;
              var notif_accepted_act_sched_body = `${response_array.accepted_act_sched} new accepted schedules `;
            }
          } else {
            var notif_accepted_act_sched = `<i class="fas fa-check mr-2"></i> No new accepted schedules <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.declined_act_sched > 0) {
            if (response_array.declined_act_sched < 2) {
              var notif_declined_act_sched = `<i class="fas fa-times mr-2"></i> ${response_array.declined_act_sched} new declined schedule <span class="float-right text-muted text-sm"></span>`;
              var notif_declined_act_sched_body = `${response_array.declined_act_sched} new declined schedule `;
            } else {
              var notif_declined_act_sched = `<i class="fas fa-times mr-2"></i> ${response_array.declined_act_sched} new declined Schedules <span class="float-right text-muted text-sm"></span>`;
              var notif_declined_act_sched_body = `${response_array.declined_act_sched} new declined schedules `;
            }
          } else {
            var notif_declined_act_sched = `<i class="fas fa-times mr-2"></i> No new declined schedules <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_accepted_act_sched_val != response_array.accepted_act_sched) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_accepted_act_sched_body,
              title: 'Accepted Schedules',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          if (notif_declined_act_sched_val != response_array.declined_act_sched) {
            $(document).Toasts('create', {
              class: 'bg-danger',
              body: notif_declined_act_sched_body,
              title: 'Declined Schedules',
              icon: 'fas fa-times fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          sessionStorage.setItem('notif_accepted_act_sched', response_array.accepted_act_sched);
          sessionStorage.setItem('notif_declined_act_sched', response_array.declined_act_sched);
        } else {
          sessionStorage.setItem('notif_accepted_act_sched', 0);
          sessionStorage.setItem('notif_declined_act_sched', 0);
          var notif_badge = `${icon}`;
          var notif_accepted_act_sched = `<i class="fas fa-check mr-2"></i> No new accepted schedules <span class="float-right text-muted text-sm"></span>`;
          var notif_declined_act_sched = `<i class="fas fa-times mr-2"></i> No new declined schedules <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_accepted_act_sched').html(notif_accepted_act_sched);
      $('#notif_declined_act_sched').html(notif_declined_act_sched);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_public_act_sched);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const update_notif_public_act_sched = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_public_act_sched'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var notif_badge = `${icon}`;
      var notif_accepted_act_sched = `<i class="fas fa-check mr-2"></i> No new accepted schedules <span class="float-right text-muted text-sm"></span>`;
      var notif_declined_act_sched = `<i class="fas fa-times mr-2"></i> No new declined schedules <span class="float-right text-muted text-sm"></span>`;
      $('#notif_badge').html(notif_badge);
      $('#notif_accepted_act_sched').html(notif_accepted_act_sched);
      $('#notif_declined_act_sched').html(notif_declined_act_sched);
      if (response != '') {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notif_public_act_sched_page = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_public_act_sched'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_accepted_act_sched_val = sessionStorage.getItem('notif_accepted_act_sched');
      var notif_declined_act_sched_val = sessionStorage.getItem('notif_declined_act_sched');
      var notif_accepted_act_sched_body = "";
      var notif_declined_act_sched_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.accepted_act_sched > 0) {
            if (response_array.accepted_act_sched < 2) {
              var notif_accepted_act_sched_body = `${response_array.accepted_act_sched} new accepted schedule `;
            } else {
              var notif_accepted_act_sched_body = `${response_array.accepted_act_sched} new accepted schedules `;
            }
          }
          if (response_array.declined_act_sched > 0) {
            if (response_array.declined_act_sched < 2) {
              var notif_declined_act_sched_body = `${response_array.declined_act_sched} new declined schedule `;
            } else {
              var notif_declined_act_sched_body = `${response_array.declined_act_sched} new declined schedules `;
            }
          }
          if (notif_accepted_act_sched_val != response_array.accepted_act_sched) {
            if (notif_accepted_act_sched_val < response_array.accepted_act_sched) {
              $(document).Toasts('create', {
                class: 'bg-success',
                body: notif_accepted_act_sched_body,
                title: 'Accepted Schedules',
                icon: 'fas fa-check fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_public_act_sched(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_declined_act_sched_val != response_array.declined_act_sched) {
            if (notif_declined_act_sched_val < response_array.declined_act_sched) {
              $(document).Toasts('create', {
                class: 'bg-danger',
                body: notif_declined_act_sched_body,
                title: 'Declined Schedules',
                icon: 'fas fa-times fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_public_act_sched(); // AUTOCLEAR NOTIF
            }
          }
          sessionStorage.setItem('notif_accepted_act_sched', response_array.accepted_act_sched);
          sessionStorage.setItem('notif_declined_act_sched', response_array.declined_act_sched);
        } else {
          sessionStorage.setItem('notif_accepted_act_sched', 0);
          sessionStorage.setItem('notif_declined_act_sched', 0);
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_public_act_sched_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// APPROVERS NOTIFICATION

// Notifications
const load_notif_pending_mstprc = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pending_mstprc'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      var notif_pending_mstprc_body = "";
      if (response > 0) {
        if (response < 2) {
          var notif_pending_mstprc_body = `${response} pending checksheet `;
        } else {
          var notif_pending_mstprc_body = `${response} pending checksheets `;
        }
        if (notif_pending_mstprc_val != response) {
          $(document).Toasts('create', {
            class: 'bg-warning',
            body: notif_pending_mstprc_body,
            title: 'Pending Checksheets',
            icon: 'fas fa-exclamation-circle fa-lg',
            autohide: true,
            delay: 4800
          });
        }
        sessionStorage.setItem('notif_pending_mstprc', response);
      } else if (response < 1) {
        sessionStorage.setItem('notif_pending_mstprc', 0);
      } else {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_pending_mstprc);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const update_notif_pending_mstprc = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_pending_mstprc'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      if (response != '') {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notif_pending_mstprc_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pending_mstprc'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      var notif_pending_mstprc_body = "";
      if (response > 0) {
        if (response < 2) {
          var notif_pending_mstprc_body = `${response} pending checksheet `;
        } else {
          var notif_pending_mstprc_body = `${response} pending checksheets `;
        }
        if (notif_pending_mstprc_val != response) {
          if (notif_pending_mstprc_val < response) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_pending_mstprc_body,
              title: 'Pending Checksheets',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
            update_notif_pending_mstprc(); // AUTOCLEAR NOTIF
          }
        }
        sessionStorage.setItem('notif_pending_mstprc', response);
      } else if (response < 1) {
        sessionStorage.setItem('notif_pending_mstprc', 0);
      } else {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
    } 
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_pending_mstprc_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}