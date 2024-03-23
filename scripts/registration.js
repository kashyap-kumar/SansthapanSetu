const registrationForm = document.getElementById("registrationForm");
const messageElement = document.getElementById("message");

registrationForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const name = document.getElementById("name").value;
    const phone = document.getElementById("phone").value;
    const city = document.getElementById("city").value;
    const gender = document.querySelector('input[name="gender"]:checked').value;
    const role = document.getElementById("role").value;

    await handleRegistration(email, password, name, phone, city, gender, role);
});

async function handleRegistration(email, password, name, phone, city, gender, role) {
    try {
        const response = await fetch("api/registration.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ email, password, name, phone, city, gender, role }),
        });

        const data = await response.json();

        if (data.success) {
            messageElement.textContent = data.message;
            // Redirect after 2 seconds
            setTimeout(function () {
                window.location.href = "login.html";
            }, 2000);
        } else {
            messageElement.textContent = data.message;
        }
    } catch (error) {
        messageElement.textContent = "Something wrong happened. Please try again later.";
        console.error(error);
    }
}
