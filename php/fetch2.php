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

$sql = "SELECT DISTINCT receiver FROM text WHERE sender='$sender'";
$result = $conn->query($sql);

$receivers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $receivers[] = $row['receiver'];
    }
}

echo json_encode($receivers);

$conn->close();
?>
