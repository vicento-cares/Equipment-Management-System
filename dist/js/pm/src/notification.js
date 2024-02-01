// Notification Global Variables for Realtime
var realtime_load_notif_public_pm_concerns;
var realtime_load_notif_public_pm_concerns_page;
var realtime_load_notif_pending_rsir_page;
var realtime_load_notif_pm;
var realtime_load_notif_pm_new_pm_concerns_page;
var realtime_load_notif_pm_rsir_page;

const load_notif_pm = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pm'
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
      var notif_approved_rsir = "";
      var notif_disapproved_rsir = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_approved_rsir_val = sessionStorage.getItem('notif_approved_rsir');
      var notif_disapproved_rsir_val = sessionStorage.getItem('notif_disapproved_rsir');
      var notif_new_pm_concerns_body = "";
      var notif_approved_rsir_body = "";
      var notif_disapproved_rsir_body = "";
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
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_rsir > 0) {
            if (response_array.approved_rsir < 2) {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheet `;
            } else {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheets `;
            }
          } else {
            var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_rsir > 0) {
            if (response_array.disapproved_rsir < 2) {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheet `;
            } else {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-orange',
              body: notif_new_pm_concerns_body,
              title: 'New Schedules',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_approved_rsir_val != response_array.approved_rsir) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_approved_rsir_body,
              title: 'Approved Checksheets',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_disapproved_rsir_val != response_array.disapproved_rsir) {
            $(document).Toasts('create', {
              class: 'bg-danger',
              body: notif_disapproved_rsir_body,
              title: 'Disapproved Checksheets',
              icon: 'fas fa-times fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_approved_rsir', response_array.approved_rsir);
          sessionStorage.setItem('notif_disapproved_rsir', response_array.disapproved_rsir);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_approved_rsir', 0);
          sessionStorage.setItem('notif_disapproved_rsir', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_approved_rsir').html(notif_approved_rsir);
      $('#notif_disapproved_rsir').html(notif_disapproved_rsir);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_pm);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_pm_new_pm_concerns_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pm'
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
      var notif_approved_rsir = "";
      var notif_disapproved_rsir = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_approved_rsir_val = sessionStorage.getItem('notif_approved_rsir');
      var notif_disapproved_rsir_val = sessionStorage.getItem('notif_disapproved_rsir');
      var notif_new_pm_concerns_body = "";
      var notif_approved_rsir_body = "";
      var notif_disapproved_rsir_body = "";
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
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_rsir > 0) {
            if (response_array.approved_rsir < 2) {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheet `;
            } else {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheets `;
            }
          } else {
            var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_rsir > 0) {
            if (response_array.disapproved_rsir < 2) {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheet `;
            } else {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            if (notif_new_pm_concerns_val < response_array.new_pm_concerns) {
              $(document).Toasts('create', {
                class: 'bg-orange',
                body: notif_new_pm_concerns_body,
                title: 'New Schedules',
                icon: 'fas fa-exclamation-circle fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_new_pm_concerns(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_approved_rsir_val != response_array.approved_rsir) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_approved_rsir_body,
              title: 'Approved Checksheets',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_disapproved_rsir_val != response_array.disapproved_rsir) {
            $(document).Toasts('create', {
              class: 'bg-danger',
              body: notif_disapproved_rsir_body,
              title: 'Disapproved Checksheets',
              icon: 'fas fa-times fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_approved_rsir', response_array.approved_rsir);
          sessionStorage.setItem('notif_disapproved_rsir', response_array.disapproved_rsir);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_approved_rsir', 0);
          sessionStorage.setItem('notif_disapproved_rsir', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_approved_rsir').html(notif_approved_rsir);
      $('#notif_disapproved_rsir').html(notif_disapproved_rsir);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_pm_new_pm_concerns_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const load_notif_pm_rsir_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pm'
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
      var notif_approved_rsir = "";
      var notif_disapproved_rsir = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_approved_rsir_val = sessionStorage.getItem('notif_approved_rsir');
      var notif_disapproved_rsir_val = sessionStorage.getItem('notif_disapproved_rsir');
      var notif_new_pm_concerns_body = "";
      var notif_approved_rsir_body = "";
      var notif_disapproved_rsir_body = "";
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
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concern `;
            } else {
              var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> ${response_array.new_pm_concerns} new PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_new_pm_concerns_body = `${response_array.new_pm_concerns} new pm concerns `;
            }
          } else {
            var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.approved_rsir > 0) {
            if (response_array.approved_rsir < 2) {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheet `;
            } else {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_approved_rsir_body = `${response_array.approved_rsir} new approved checksheets `;
            }
          } else {
            var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_rsir > 0) {
            if (response_array.disapproved_rsir < 2) {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheet `;
            } else {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
              var notif_disapproved_rsir_body = `${response_array.disapproved_rsir} new disapproved checksheets `;
            }
          } else {
            var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_new_pm_concerns_val != response_array.new_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-orange',
              body: notif_new_pm_concerns_body,
              title: 'New Schedules',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
          }
          if (notif_approved_rsir_val != response_array.approved_rsir) {
            if (notif_approved_rsir_val < response_array.approved_rsir) {
              $(document).Toasts('create', {
                class: 'bg-success',
                body: notif_approved_rsir_body,
                title: 'Approved Checksheets',
                icon: 'fas fa-check fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_approved_rsir(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_disapproved_rsir_val != response_array.disapproved_rsir) {
            if (notif_disapproved_rsir_val < response_array.disapproved_rsir) {
              $(document).Toasts('create', {
                class: 'bg-danger',
                body: notif_disapproved_rsir_body,
                title: 'Disapproved Checksheets',
                icon: 'fas fa-times fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_disapproved_rsir(); // AUTOCLEAR NOTIF
            }
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_approved_rsir', response_array.approved_rsir);
          sessionStorage.setItem('notif_disapproved_rsir', response_array.disapproved_rsir);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_approved_rsir', 0);
          sessionStorage.setItem('notif_disapproved_rsir', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_approved_rsir').html(notif_approved_rsir);
      $('#notif_disapproved_rsir').html(notif_disapproved_rsir);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_pm_rsir_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

const update_notif_pm_badge = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pm'
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
      var notif_approved_rsir = "";
      var notif_disapproved_rsir = "";
      var notif_new_pm_concerns_val = sessionStorage.getItem('notif_new_pm_concerns');
      var notif_approved_rsir_val = sessionStorage.getItem('notif_approved_rsir');
      var notif_disapproved_rsir_val = sessionStorage.getItem('notif_disapproved_rsir');
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
          if (response_array.approved_rsir > 0) {
            if (response_array.approved_rsir < 2) {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheet <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> ${response_array.approved_rsir} new approved checksheets <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.disapproved_rsir > 0) {
            if (response_array.disapproved_rsir < 2) {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheet <span class="float-right text-muted text-sm"></span>`;
            } else {
              var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> ${response_array.disapproved_rsir} new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
            }
          } else {
            var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
          }
          sessionStorage.setItem('notif_new_pm_concerns', response_array.new_pm_concerns);
          sessionStorage.setItem('notif_approved_rsir', response_array.approved_rsir);
          sessionStorage.setItem('notif_disapproved_rsir', response_array.disapproved_rsir);
        } else {
          sessionStorage.setItem('notif_new_pm_concerns', 0);
          sessionStorage.setItem('notif_approved_rsir', 0);
          sessionStorage.setItem('notif_disapproved_rsir', 0);
          var notif_badge = `${icon}`;
          var notif_new_pm_concerns = `<i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_approved_rsir = `<i class="fas fa-check mr-2"></i> No new approved checksheets <span class="float-right text-muted text-sm"></span>`;
          var notif_disapproved_rsir = `<i class="fas fa-times mr-2"></i> No new disapproved checksheets <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_new_pm_concerns').html(notif_new_pm_concerns);
      $('#notif_approved_rsir').html(notif_approved_rsir);
      $('#notif_disapproved_rsir').html(notif_disapproved_rsir);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
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
        update_notif_pm_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const update_notif_approved_rsir = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_approved_rsir'
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
        update_notif_pm_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const update_notif_disapproved_rsir = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_disapproved_rsir'
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
        update_notif_pm_badge();
      }
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
  });
}

// Notifications
const load_notif_public_pm_concerns = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_public_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var badge = "";
      var notif_badge = "";
      var notif_done_pm_concerns = "";
      var notif_pending_pm_concerns = "";
      var notif_done_pm_concerns_val = sessionStorage.getItem('notif_done_pm_concerns');
      var notif_pending_pm_concerns_val = sessionStorage.getItem('notif_pending_pm_concerns');
      var notif_done_pm_concerns_body = "";
      var notif_pending_pm_concerns_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.total > 99) {
            var badge = `<span class="badge badge-danger navbar-badge">99+</span>`;
          } else {
            var badge = `<span class="badge badge-danger navbar-badge">${response_array.total}</span>`;
          }
          var notif_badge = `${icon}${badge}`;
          if (response_array.done_pm_concerns > 0) {
            if (response_array.done_pm_concerns < 2) {
              var notif_done_pm_concerns = `<i class="fas fa-check mr-2"></i> ${response_array.done_pm_concerns} new Done PM Concern <span class="float-right text-muted text-sm"></span>`;
              var notif_done_pm_concerns_body = `${response_array.done_pm_concerns} new done pm concern `;
            } else {
              var notif_done_pm_concerns = `<i class="fas fa-check mr-2"></i> ${response_array.done_pm_concerns} new Done PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_done_pm_concerns_body = `${response_array.done_pm_concerns} new done pm concerns `;
            }
          } else {
            var notif_done_pm_concerns = `<i class="fas fa-check mr-2"></i> No new Done PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (response_array.pending_pm_concerns > 0) {
            if (response_array.pending_pm_concerns < 2) {
              var notif_pending_pm_concerns = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_pm_concerns} new Pending PM Concern <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_pm_concerns_body = `${response_array.pending_pm_concerns} new pending pm concern `;
            } else {
              var notif_pending_pm_concerns = `<i class="fas fa-spinner mr-2"></i> ${response_array.pending_pm_concerns} new Pending PM Concerns <span class="float-right text-muted text-sm"></span>`;
              var notif_pending_pm_concerns_body = `${response_array.pending_pm_concerns} new pending pm concerns `;
            }
          } else {
            var notif_pending_pm_concerns = `<i class="fas fa-spinner mr-2"></i> No new Pending PM Concerns <span class="float-right text-muted text-sm"></span>`;
          }
          if (notif_done_pm_concerns_val != response_array.done_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-success',
              body: notif_done_pm_concerns_body,
              title: 'Done PM Concerns',
              icon: 'fas fa-check fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          if (notif_pending_pm_concerns_val != response_array.pending_pm_concerns) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_pending_pm_concerns_body,
              title: 'Pending PM Concerns',
              icon: 'fas fa-spinner fa-lg',
              autohide: true,
              delay: 3000
            });
          }
          sessionStorage.setItem('notif_done_pm_concerns', response_array.done_pm_concerns);
          sessionStorage.setItem('notif_pending_pm_concerns', response_array.pending_pm_concerns);
        } else {
          sessionStorage.setItem('notif_done_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_pm_concerns', 0);
          var notif_badge = `${icon}`;
          var notif_done_pm_concerns = `<i class="fas fa-check mr-2"></i> No new Done PM Concerns <span class="float-right text-muted text-sm"></span>`;
          var notif_pending_pm_concerns = `<i class="fas fa-spinner mr-2"></i> No new Pending PM Concerns <span class="float-right text-muted text-sm"></span>`;
        }
      } catch(e) {
        console.log(response);
        console.log(`Notification Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: ${response}`);
      }
      $('#notif_badge').html(notif_badge);
      $('#notif_done_pm_concerns').html(notif_done_pm_concerns);
      $('#notif_pending_pm_concerns').html(notif_pending_pm_concerns);
    }
  })
  .fail((jqXHR, textStatus, errorThrown) => {
    console.log(jqXHR);
    if (textStatus == "timeout") {
      console.log(`Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( Connection / Request Timeout )`);
      clearInterval(realtime_load_notif_public_pm_concerns);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// Notifications
const update_notif_public_pm_concerns = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_public_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var icon = `<i class="far fa-bell"></i>`;
      var notif_badge = `${icon}`;
      var notif_done_pm_concerns = `<i class="fas fa-check mr-2"></i> No new Done PM Concerns <span class="float-right text-muted text-sm"></span>`;
      var notif_pending_pm_concerns = `<i class="fas fa-spinner mr-2"></i> No new Pending PM Concerns <span class="float-right text-muted text-sm"></span>`;
      $('#notif_badge').html(notif_badge);
      $('#notif_done_pm_concerns').html(notif_done_pm_concerns);
      $('#notif_pending_pm_concerns').html(notif_pending_pm_concerns);
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
const load_notif_public_pm_concerns_page = () => {
  $.ajax({
    url: 'process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_public_pm_concerns'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_done_pm_concerns_val = sessionStorage.getItem('notif_done_pm_concerns');
      var notif_pending_pm_concerns_val = sessionStorage.getItem('notif_pending_pm_concerns');
      var notif_done_pm_concerns_body = "";
      var notif_pending_pm_concerns_body = "";
      try {
        let response_array = JSON.parse(response);
        if (response_array.total > 0) {
          if (response_array.done_pm_concerns > 0) {
            if (response_array.done_pm_concerns < 2) {
              var notif_done_pm_concerns_body = `${response_array.done_pm_concerns} new Done PM Concern `;
            } else {
              var notif_done_pm_concerns_body = `${response_array.done_pm_concerns} new Done PM Concerns `;
            }
          }
          if (response_array.pending_pm_concerns > 0) {
            if (response_array.pending_pm_concerns < 2) {
              var notif_pending_pm_concerns_body = `${response_array.pending_pm_concerns} new Pending PM Concern `;
            } else {
              var notif_pending_pm_concerns_body = `${response_array.pending_pm_concerns} new Pending PM Concerns `;
            }
          }
          if (notif_done_pm_concerns_val != response_array.done_pm_concerns) {
            if (notif_done_pm_concerns_val < response_array.done_pm_concerns) {
              $(document).Toasts('create', {
                class: 'bg-success',
                body: notif_done_pm_concerns_body,
                title: 'Done PM Concerns',
                icon: 'fas fa-check fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_public_pm_concerns(); // AUTOCLEAR NOTIF
            }
          }
          if (notif_pending_pm_concerns_val != response_array.pending_pm_concerns) {
            if (notif_pending_pm_concerns_val < response_array.pending_pm_concerns) {
              $(document).Toasts('create', {
                class: 'bg-warning',
                body: notif_pending_pm_concerns_body,
                title: 'Pending PM Concerns',
                icon: 'fas fa-spinner fa-lg',
                autohide: true,
                delay: 4800
              });
              update_notif_public_pm_concerns(); // AUTOCLEAR NOTIF
            }
          }
          sessionStorage.setItem('notif_done_pm_concerns', response_array.done_pm_concerns);
          sessionStorage.setItem('notif_pending_pm_concerns', response_array.pending_pm_concerns);
        } else {
          sessionStorage.setItem('notif_done_pm_concerns', 0);
          sessionStorage.setItem('notif_pending_pm_concerns', 0);
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
      clearInterval(realtime_load_notif_public_pm_concerns_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}

// APPROVERS NOTIFICATION

// Notifications
const update_notif_pending_rsir = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'update_notif_pending_rsir'
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
const load_notif_pending_rsir_page = () => {
  $.ajax({
    url: '../process/admin/notification_processor.php',
    type: 'POST',
    cache: false,
    data: {
      method: 'count_notif_pending_rsir'
    }, 
    beforeSend: (jqXHR, settings) => {
      jqXHR.url = settings.url;
      jqXHR.type = settings.type;
    }, 
    success: response => {
      var notif_pending_rsir_val = sessionStorage.getItem('notif_pending_rsir');
      var notif_pending_rsir_body = "";
      if (response > 0) {
        if (response < 2) {
          var notif_pending_rsir_body = `${response} pending checksheet `;
        } else {
          var notif_pending_rsir_body = `${response} pending checksheets `;
        }
        if (notif_pending_rsir_val != response) {
          if (notif_pending_rsir_val < response) {
            $(document).Toasts('create', {
              class: 'bg-warning',
              body: notif_pending_rsir_body,
              title: 'Pending Checksheets',
              icon: 'fas fa-exclamation-circle fa-lg',
              autohide: true,
              delay: 4800
            });
            update_notif_pending_rsir(); // AUTOCLEAR NOTIF
          }
        }
        sessionStorage.setItem('notif_pending_rsir', response);
      } else if (response < 1) {
        sessionStorage.setItem('notif_pending_rsir', 0);
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
      clearInterval(realtime_load_notif_pending_rsir_page);
      setTimeout(() => {window.location.reload()}, 5000);
    } else {
      console.log(`System Error!!! Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} )`);
    }
  });
}