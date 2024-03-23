<?php

require_once "../dbconnect.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"];
    $password = $data["password"];
    $name = $data["name"];
    $phone = $data["phone"];
    $phone = $data["phone"];
    $city = $data["city"];
    $gender = $data["gender"];
    $role = $data["role"];

    // Check if the email already exists
    if($role == "labour") 
        $stmt = $conn->prepare("SELECT * FROM labours WHERE ph_no = ?");
    else
        $stmt = $conn->prepare("SELECT * FROM employers WHERE ph_no = ?");
        
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = [
            "success" => false,
            "message" => "Phone number already registered"
        ];
    } else {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `labours` (`ph_no`, `name`, `email`, `city`, `gender`, `password`) VALUES (?, ?, ?, ?, ?, ?)";

        // Insert the new user into the database
        if($role == "labour") {
            $stmt = $conn->prepare("INSERT INTO `labours` (`ph_no`, `name`, `email`, `city`, `gender`, `password`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $phone, $name, $email, $city, $gender, $hash);
        } else {
            $stmt = $conn->prepare("INSERT INTO `employers` (`ph_no`, `name`, `email`, `city`, `password`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $phone, $name, $email, $city, $hash);
        }

        $stmt->execute();

        $response = [
            "success" => true,
            "message" => "Registration successful"
        ];
    }

    $stmt->close();
    $conn->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}

?>