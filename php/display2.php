<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sender = $_GET['sender'];
$receiver = $_GET['receiver'];

if (!$sender || !$receiver) {
    echo json_encode([]);
    $conn->close();
    exit();
}

// Modified SQL to include the dspp column (image path)
$sql = "SELECT sender, chat, dspp FROM text WHERE (sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender') ORDER BY id ASC";
$result = $conn->query($sql);

$chats = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $chats[] = $row; // This will now include 'sender', 'chat', and 'dspp'
    }
}

echo json_encode($chats);

$conn->close();
?>
