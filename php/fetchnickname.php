<?php
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

$sql = "SELECT nickname FROM boy WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $nickname = $result->fetch_assoc()['nickname'];
    echo json_encode(['nickname' => $nickname]);
} else {
    echo json_encode(['nickname' => '']);
}

$stmt->close();
$conn->close();
?>
