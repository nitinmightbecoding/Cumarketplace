<?php
// Database connection details
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];
$description = $_GET['description'];

$response = ['success' => false];

// Fetch the nickname from the `buy` table based on the email
$query = "SELECT nickname FROM buy WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($nickname);
if ($stmt->fetch()) {
    $response['nickname'] = $nickname;
    $response['success'] = true;
}
$stmt->close();

// Fetch the receiver email from the `boy` table based on the description
$query = "SELECT email FROM boy WHERE dsp = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $description);
$stmt->execute();
$stmt->bind_result($receiver);
if ($stmt->fetch()) {
    $response['receiver'] = $receiver;
    $response['success'] = true;
}
$stmt->close();

$conn->close();

echo json_encode($response);
?>
