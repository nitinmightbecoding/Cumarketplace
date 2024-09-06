<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receiver = $_GET['receiver'];

if (!$receiver) {
    echo json_encode([]);
    $conn->close();
    exit();
}

$sql = "SELECT DISTINCT sender FROM text WHERE receiver='$receiver'";
$result = $conn->query($sql);

$senders = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $senders[] = $row['sender'];
    }
}

echo json_encode($senders);

$conn->close();
?>
