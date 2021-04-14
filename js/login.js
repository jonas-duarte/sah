function validateLogin(email, password) {
  validate.email(email);
}

document.addEventListener("DOMContentLoaded", function () {
  const token = localStorage.getItem("token");

  if (token) {
    http.get(`/token?token=${token}`).then(() => {
      window.location.href = `/router.php/dashboard?token=${token}`;
    });
  }

  document
    .getElementById("loginForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const email = event.target.elements.email.value;
      const password = event.target.elements.password.value;

      try {
        validateLogin(email, password);

        http
          .post(`/login?email=${email}&password=${password}`)
          .then((token) => {
            localStorage.setItem("token", token);
            window.location.href = `/router.php/dashboard?token=${token}`;
          });
      } catch (error) {
        handleError(error);
      }
    });
});
