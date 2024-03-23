<?php
// initialize a session
session_start();

// check if the user is already logged in or not, if not, redirect to login page
if (!isset($_SESSION["employer_authenticated"]) || $_SESSION["employer_authenticated"] !== true) {
    header("location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="home.css">
    <link rel="shortcut icon" href="../logo.png" type="image/x-icon">
    <title>Employer Panel | SansthapanSetu</title>
</head>
<body>
    <h1>Employer Panel</h1>
    <section id="postjob">
        <input type="text" id="location" placeholder="Enter location" required>
        <select name="type" id="type" required>
            <option value="Plumber">Plumber</option>
            <option value="Painter">Painter</option>
            <option value="Electrician">Electrician</option>
            <option value="Welder">Welder</option>
            <option value="Construction Worker">Construction Worker</option>
            <option value="Carpenter">Carpenter</option>
        </select>
        <textarea name="" id="desc" cols="30" rows="10" placeholder="Enter description" required></textarea>
        <button onclick="postJob()">Post</button>
    </section>

    <script>
        function postJob() {
            const type = document.getElementById("type").value;
            const location = document.getElementById("location").value;
            const description = document.getElementById("desc").value;

            const data = {
                type: type,
                employer_id: <?= $_SESSION["employer_id"] ?>,
                location: location,
                description: description
            };

            fetch('../api/post_job.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                    alert(data.message);
                } else {
                    console.error(data.message);
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(data.message);
            });
        }
    </script>
</body>
</html>