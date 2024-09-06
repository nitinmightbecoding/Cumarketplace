<?php
header('Content-Type: application/json');

$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Get the email from the query string
$email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';

// Query to fetch nickname
$query = "SELECT nickname FROM boy WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'nickname' => $row['nickname']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nickname not found.']);
}

// Close the connection
$conn->close();
?>