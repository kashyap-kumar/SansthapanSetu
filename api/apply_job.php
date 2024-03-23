<?php
// Database configuration
require_once "../dbconnect.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $job_id = $data["job_id"];
    $labour_id = $data["labour_id"];
    $employer_id = $data["employer_id"];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO job_applications (job_id, labour_id, employer_id, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iis", $job_id, $labour_id, $employer_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            "success" => true,
            "message" => "Application submitted successfully"
        ];
    } else {
        $response = [
            "success" => false,
            "message" => "Failed to submit application"
        ];
    }

    $stmt->close();
    $conn->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}
?>