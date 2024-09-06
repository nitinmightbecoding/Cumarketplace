<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$sender = $data['sender'];
$receiver = $data['receiver'];
$chat = $data['chat'];

if (!$sender || !$receiver || !$chat) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    $conn->close();
    exit();
}

$sql = "INSERT INTO text (sender, receiver, chat) VALUES ('$sender', '$receiver', '$chat')";
$conn->query($sql);

echo json_encode(['status' => 'success']);

$conn->close();
?>
