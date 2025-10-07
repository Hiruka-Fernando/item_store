document.addEventListener("DOMContentLoaded", function () {
    const signupForm = document.querySelector('form[action="php/signup.php"]');
    const passwordInput = document.getElementById("signup-password");
    const confirmInput = document.getElementById("signup-confirm");
    const passwordError = document.getElementById("password-error");
    const confirmError = document.getElementById("confirm-error");

    signupForm.addEventListener("submit", function (e) {
        let valid = true;

        // Check password length
        if (passwordInput.value.length < 6) {
            passwordError.textContent = "Password needs to be at least 6 characters.";
            passwordInput.classList.add("input-error");
            valid = false;
        } else {
            passwordError.textContent = "";
            passwordInput.classList.remove("input-error");
        }

        // Check password match
        if (passwordInput.value !== confirmInput.value) {
            confirmError.textContent = "Passwords do not match.";
            confirmInput.classList.add("input-error");
            valid = false;
        } else {
            confirmError.textContent = "";
            confirmInput.classList.remove("input-error");
        }

        if (!valid) {
            e.preventDefault(); // Stop form submission
        }
    });
});