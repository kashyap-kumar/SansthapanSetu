const loginForm = document.getElementById("loginForm");
const messageElement = document.getElementById("message");

loginForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;

    await handleLogin(phone, password);
});

async function handleLogin(phone, password) {
    try {
        const response = await fetch("../api/employer_login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ phone, password }),
        });

        const data = await response.json();

        if (data.success) {
            // Redirect to the home feed
            window.location.href = "home.php";
        } else {
            messageElement.textContent = data.message;
        }
    } catch (error) {
        messageElement.textContent = "Something went wrong. Try again later.";
        console.error(error);
    }
}
