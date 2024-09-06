<?php
$servername = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all flats data
    $stmt = $pdo->query('SELECT * FROM map');
    $flats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data in JSON format
    echo json_encode($flats);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
