<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

$email = $_GET['email'];

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("SELECT nickname FROM boy WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($nickname);
$stmt->fetch();

$response = array('nickname' => $nickname);
echo json_encode($response);

$stmt->close();
$conn->close();
?>
