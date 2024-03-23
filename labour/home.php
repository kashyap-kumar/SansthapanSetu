<?php
// initialize a session
session_start();

// check if the user is already logged in or not, if not, redirect to login page
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang="en">
        <!-- metatags -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- bootstrap and font awesome -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
            integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <link rel="shortcut icon" href="../logo.png" type="image/x-icon">

        <link type="text/css" rel="stylesheet" href="home.css" />
        <title>সংস্থাপনসেতু</title>
    </head>
    <body>
        <!-- header section -->
        <header>
            <div class="header-child">
                <a id="labour-photo" class="labour-photo" href="profile.html"><a href="profile.html"> </a></a>
                <div id="labour-info" class="labour-info">
                    <h1 id="labour-name"><?= $_SESSION["labour_name"] ?></h1>
                    <p id="labour-phno">Phone: <?= $_SESSION["labour_phone"] ?></p>
                    <!-- <p id="labour-work">Programmer</p> -->
                </div>
            </div>
        </header>

        <div class="container">

            <!-- job search bar -->
            <div class="searchbar-container">
                <input type="text" placeholder="Search here" id="search-bar" />
                <button onclick="">Search</button>
            </div>
            
            <!-- job cards -->
            <div id="jobcard-container" class="jobcard-container">

                <?php
                    require "../dbconnect.php";
                    $sql = "SELECT * FROM jobs ORDER BY RAND() LIMIT 3"; // Select 3 random job entries from the database
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                ?>
                    <div class="job">
                        <h1 id="job-title"><?= $row["type"] ?></h1>
                        <p id="address"><i class="fa-solid fa-location-dot"></i>   <?= $row["location"] ?></p>
                        <p id="address"><i class="fa-solid fa-circle-info"></i>   <?= $row["description"] ?></p>
                        <!-- <p id="ph-no">8822898554</p> -->

                        <div class="btn-container">
                            <button onclick='handleApply(this, <?= $row["id"] ?>, <?= $row["employer_id"] ?>, <?= $_SESSION["labour_id"] ?>)'>Apply now</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- learning section -->
            <div class="learning-section">
                <div class="learn-card">
                    <h1>Learn your work</h1>
                    <div class="btn-container">
                        <a href="learnYourWork.html">
                            <button>Click here</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer section -->
        <footer>
            <div class="row">
                <p class="copyright text-center" style="font-size: 12px">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    সংস্থাপনসেতু. All rights reserved.
                </p>
                <p class="text-center mb-0">
                    Made With <i class="fa-solid fa-heart" style="color: #eac146"></i> by Hostel 2, AEC
                </p>
            </div>
        </footer>

        <script>
            function handleApply(elm, job_id, employer_id, labour_id) {
                if(elm.innerText == "Applied") return;

                fetch('../api/apply_job.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ job_id, labour_id, employer_id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                        alert(data.message);
                        elm.innerText = "Applied";
                        elm.style.cursor = "not-allowed";
                    } else {
                        console.error(data.message);
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Something went wrong. Try again later.")
                });
            }
        </script>
    </body>
</html>