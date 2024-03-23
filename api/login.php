<?php

// database connection
require_once "../dbconnect.php";

// Start the session
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $phone = $data["phone"];
    $password = $data["password"];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM labours WHERE ph_no = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row["password"];

        // Verify the password
        if (password_verify($password, $hash)) {
            $_SESSION["authenticated"] = true;
            $response = [
                "success" => true,
                "message" => "Login successful"
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Invalid user ID or password"
            ];
        }
    } else {
        $response = [
            "success" => false,
            "message" => "Invalid user ID or password"
        ];
    }

    $stmt->close();
    $conn->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}

?>