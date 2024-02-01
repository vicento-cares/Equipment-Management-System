document.addEventListener("DOMContentLoaded", () => {
  $.validator.setDefaults({
    submitHandler: () => {
      let username = document.getElementById("username").value;
      let password = document.getElementById("password").value;

      $.ajax({
        url: '../process/auth/sign_in.php',
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
            if (setup_approver_role == '1') {
              window.location.href = "../approver1/home.php";
            } else if (setup_approver_role == '2') {
              window.location.href = "../approver2/home.php";
            } else if (setup_approver_role == '3') {
              window.location.href = "../approver3/home.php";
            } else if (setup_approver_role == 'N/A') {
              window.location.href = "home.php";
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
