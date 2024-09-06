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

$priceRange = $_POST['priceRange'];
$propertyType = $_POST['propertyType'];
$gender = $_POST['gender'];
$distanceRange = $_POST['distanceRange'];

// Chandigarh University coordinates
$cuLat = 30.7080; // Example latitude
$cuLon = 76.7192; // Example longitude

// SQL query to filter data
$sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( lati ) ) * cos( radians( longi ) - radians(?) ) + sin( radians(?) ) * sin( radians( lati ) ) ) AS distance
        FROM map
        WHERE rent <= ? AND
              type = ? AND
              genderprefered = ? AND
              ( 6371 * acos( cos( radians(?) ) * cos( radians( lati ) ) * cos( radians( longi ) - radians(?) ) + sin( radians(?) ) * sin( radians( lati ) ) ) <= ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("dddssssdd", $cuLat, $cuLon, $cuLat, $priceRange, $propertyType, $gender, $cuLat, $cuLon, $cuLat, $distanceRange);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
