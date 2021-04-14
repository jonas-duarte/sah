function validateLogin(login, password) {
    validate.email(login);
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById("loginForm").addEventListener("submit", function (event) {

        const login = event.target.elements.email.value;
        const password = event.target.elements.password.value;

        console.log(login, password)
        try {
            validateLogin(login, password)
        } catch (error) {
            handleError(error)
            event.preventDefault();
        }
    });
});
