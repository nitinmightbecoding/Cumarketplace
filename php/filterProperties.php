<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and decode the input data
$input = json_decode(file_get_contents('php://input'), true);
$priceRange = $input['priceRange'];
$propertyType = $input['propertyType'];
$gender = $input['gender'];
$distanceRange = $input['distanceRange'];

// Coordinates of Chandigarh University
$cuLatitude = 30.7689; 
$cuLongitude = 76.5754;

// Prepare the SQL query
$sql = "SELECT *, 
    (6371 * acos(cos(radians($cuLatitude)) * cos(radians(lati)) * cos(radians(longi) - radians($cuLongitude)) + sin(radians($cuLatitude)) * sin(radians(lati)))) AS distance 
    FROM map 
    WHERE rent <= ? AND type = ? AND genderprefered = ? HAVING distance <= ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $priceRange, $propertyType, $gender, $distanceRange);
$stmt->execute();
$result = $stmt->get_result();

$properties = array();
while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
}

// Return JSON data
header('Content-Type: application/json');
echo json_encode($properties);

$stmt->close();
$conn->close();
?>
