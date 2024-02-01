document.addEventListener("DOMContentLoaded", () => {
  $.validator.setDefaults({
    submitHandler: () => {
      let username = document.getElementById("username").value;
      let password = document.getElementById("password").value;
      let account_type = document.getElementById("account_type").value;
      let url = '';

      if (account_type == 'Setup') {
        url = '../setup/process/auth/sign_in.php';
      } else if (account_type == 'PM') {
        url = '../pm/process/auth/sign_in.php';
      } else if (account_type == 'SP') {
        url = '../sp/process/auth/sign_in.php';
      }

      $.ajax({
        url: url,
        type: 'POST',
        cache: false,
        data: {
          username: username,
          password: password
        }, 
        beforeSend: (jqXHR, settings) => {
          var loading = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" id="loading"></span>`;
          document.getElementById("login").insertAdjacentHTML('afterbegin', loading);
          document.getElementById("login").setAttribute('disabled', true);
          jqXHR.url = settings.url;
          jqXHR.type = settings.type;
        }, 
        success: response => {
          if (response == 'success') {
            var setup_approver_role = getCookie('setup_approver_role');
            var pm_role = getCookie('pm_role');
            var sp_role = getCookie('sp_role');
            if (account_type == 'Setup') {
              if (setup_approver_role == '1') {
                window.location.href = "../setup/approver1/home.php";
              } else if (setup_approver_role == '2') {
                window.location.href = "../setup/approver2/home.php";
              } else if (setup_approver_role == '3') {
                window.location.href = "../setup/approver3/home.php";
              } else if (setup_approver_role == 'N/A') {
                window.location.href = "../setup/admin/home.php";
              }
            } else if (account_type == 'PM') {
              if (pm_role == 'Prod') {
                window.location.href = "../pm/prod/home.php";
              } else if (pm_role == 'QA') {
                window.location.href = "../pm/qa/home.php";
              } else if (pm_role == 'Admin' || pm_role == 'PM') {
                window.location.href = "../pm/admin/home.php";
              }
            } else if (account_type == 'SP') {
              if (sp_role == 'Admin' || sp_role == 'SP') {
                window.location.href = "../sp/admin/approver-2.php";
              }
            } else {
              console.log('System Error! Call IT Personnel Immediately!!! They will fix it right away. Cookie Role Error');
            }
            document.getElementById("username").value = '';
            document.getElementById("password").value = '';
          } else {
            if (response == 'failed') {
              swal('Account Information', `Sign In Failed. Maybe an incorrect credential or account not found`, 'info');
            } else {
              swal('System Error', `Error: ${response}`, 'error');
            }
            document.getElementById("loading").remove();
            document.getElementById("login").removeAttribute('disabled');
          }
        }
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.log(jqXHR);
        swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
        document.getElementById("loading").remove();
        document.getElementById("login").removeAttribute('disabled');
      });
    }
  });
  $('#quickForm').validate({
    rules: {
      username: {
        required: true
        /*email: true*/
      },
      password: {
        required: true
        /*minlength: 5*/
      },
      account_type: {
        required: true
      }
    },
    messages: {
      username: {
        required: "Please enter a username"
        /*email: "Please enter a valid email address"*/
      },
      password: {
        required: "Please provide a password"
        /*minlength: "Your password must be at least 5 characters long"*/
      },
      account_type: {
        required: "Please select account type"
      }
    },
    errorElement: 'span',
    errorPlacement: (error, element) => {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: (element, errorClass, validClass) => {
      element.classList.add('is-invalid');
    },
    unhighlight: (element, errorClass, validClass) => {
      element.classList.remove('is-invalid');
    }
  });
});
