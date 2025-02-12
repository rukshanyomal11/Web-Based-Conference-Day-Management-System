document.querySelector("form").addEventListener("submit", function(e) {
    // Prevent form submission initially
    e.preventDefault();

    // Get form values
    const userRole = document.getElementById("user-role").value;
    const emailAddress = document.getElementById("email-address").value.trim();
    const password = document.getElementById("password").value.trim();

    // Regular expression for email validation
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Reset error messages
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((msg) => msg.textContent = "");

    let isValid = true;

    // Validate User Role
    if (!userRole) {
        document.querySelector("#user-role-error").textContent = "Please select your role.";
        isValid = false;
    }

    // Validate Email Address
    if (!emailRegex.test(emailAddress)) {
        document.querySelector("#email-address-error").textContent = "Please enter a valid email address.";
        isValid = false;
    }

    // Validate Password
    if (!password) {
        document.querySelector("#password-error").textContent = "Password is required.";
        isValid = false;
    }

    // If all validations are passed, submit the form
    if (isValid) {
        e.target.submit();
    }
});
