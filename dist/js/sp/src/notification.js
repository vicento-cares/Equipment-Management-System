// Notification Global Variables for Realtime
var realtime_load_notif_sp;
var realtime_load_notif_sp_pm_concerns_page;
var realtime_load_notif_sp_pending_mstprc_page;

const load_notif_sp = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_sp'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_pm_concerns = "";
      var notif_pending_mstprc = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      var notif_new_pm_concerns_body = "";
      var notif_pending_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_pm_concerns > 0) {
            if (response_array.new_pm_concerns < 2) {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concern <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.pending_mstprc > 0) {
            if (response_array.pending_mstprc < 2) {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approval <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approval `;
            } else {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approvals <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approvals `;
            }
          } else {
            var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-orange',
              body: notif_new_pm_concerns_body,
              title: 'New PM Concerns',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_pending_mstprc_val != response_array.pending_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_pending_mstprc_body,
              title: 'Pending Approvals',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_pending_mstprc', response_array.pending_mstprc);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_pending_mstprc').html(notif_pending_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_sp);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_sp_pm_concerns_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_sp'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_pm_concerns = "";
      var notif_pending_mstprc = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      var notif_new_pm_concerns_body = "";
      var notif_pending_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_pm_concerns > 0) {
            if (response_array.new_pm_concerns < 2) {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concern <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.pending_mstprc > 0) {
            if (response_array.pending_mstprc < 2) {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approval <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approval `;
            } else {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approvals <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approvals `;
            }
          } else {
            var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            if (notif_new_pm_concerns_val < response_array.new_pm_concerns) {
              $(document).Toasts('create', {
                class: 'bg-orange',
                body: notif_new_pm_concerns_body,
                title: 'New PM Concerns',
                icon: 'fas fa-exclamation-circle fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_new_pm_concerns(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_pending_mstprc_val != response_array.pending_mstprc) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_pending_mstprc_body,
              title: 'Pending Approvals',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_pending_mstprc', response_array.pending_mstprc);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_pending_mstprc').html(notif_pending_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_sp_pm_concerns_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_sp_pending_mstprc_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_sp'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_pm_concerns = "";
      var notif_pending_mstprc = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      var notif_new_pm_concerns_body = "";
      var notif_pending_mstprc_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_pm_concerns > 0) {
            if (response_array.new_pm_concerns < 2) {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concern <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new PM Concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.pending_mstprc > 0) {
            if (response_array.pending_mstprc < 2) {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approval <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approval `;
            } else {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approvals <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_mstprc_body = `${response_array.pending_mstprc} new pending approvals `;
            }
          } else {
            var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-orange',
              body: notif_new_pm_concerns_body,
              title: 'New PM Concerns',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_pending_mstprc_val != response_array.pending_mstprc) {
            if (notif_pending_mstprc_val < response_array.pending_mstprc) {
              $(document).Toasts('create', {
                class: 'bg-warning',
                body: notif_pending_mstprc_body,
                title: 'Pending Approvals',
                icon: 'fas fa-spinner fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_pending_mstprc(); // AUTOCLEAR NOTIF
            }
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_pending_mstprc', response_array.pending_mstprc);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_pending_mstprc').html(notif_pending_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_sp_pending_mstprc_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const update_notif_sp_badge = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_sp'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_new_pm_concerns = "";
      var notif_pending_mstprc = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_pending_mstprc_val = sessionStorage.getItem('notif_pending_mstprc');
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.new_pm_concerns > 0) {
            if (response_array.new_pm_concerns < 2) {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concern <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.pending_mstprc > 0) {
            if (response_array.pending_mstprc < 2) {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approval <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_mstprc} new pending approvals <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_pending_mstprc', response_array.pending_mstprc);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_mstprc', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_pending_mstprc = `<i class="fas fa-spinner mr-2"></i> No new pending approvals <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_pending_mstprc').html(notif_pending_mstprc);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
  });
}

// Notifications
const update_notif_new_pm_concerns = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_new_pm_concerns'
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
        update_notif_sp_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
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
      } else {
        update_notif_sp_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}
