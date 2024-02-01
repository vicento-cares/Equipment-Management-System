// Logout Function
const logout = url => {
  var loading = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" id="loading"></span>`;
  document.getElementById("logout").insertAdjacentHTML('afterbegin', loading);
  document.getElementById("logout").setAttribute('disabled', true);
  document.getElementById("logoutClose").setAttribute('disabled', true);
  window.location.href = url;
}