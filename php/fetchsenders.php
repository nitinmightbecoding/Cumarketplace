<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receiver = $_GET['receiver'];

$sql = "SELECT DISTINCT sender AS email FROM text WHERE receiver = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $receiver);
$stmt->execute();
$result = $stmt->get_result();

$senders = [];
while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $sql2 = "SELECT nickname FROM boy WHERE email = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
        $nickname = $result2->fetch_assoc()['nickname'];
        $senders[] = ['email' => $email, 'nickname' => $nickname];
    }
    $stmt2->close();
}

echo json_encode($senders);

$stmt->close();
$conn->close();
?>
