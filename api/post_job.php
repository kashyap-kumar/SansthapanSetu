<?php
// Database configuration
require_once "../dbconnect.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $type = $data["type"];
    $employer_id = $data["employer_id"];
    $location = $data["location"];
    $description = $data["description"];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO jobs (type, employer_id, location, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $type, $employer_id, $location, $description);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            "success" => true,
            "message" => "Job posted successfully"
        ];
    } else {
        $response = [
            "success" => false,
            "message" => "Failed to post job"
        ];
    }

    $stmt->close();
    $conn->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}
?>