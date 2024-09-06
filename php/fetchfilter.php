<?php
// Database connection
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the connection uses UTF-8 encoding
$conn->set_charset("utf8");

// Get the property type from the request and trim whitespace
$type = isset($_GET['type']) ? trim($_GET['type']) : '';

// Check if the type is empty and return an empty array if so
if (empty($type)) {
    header('Content-Type: application/json');
    echo json_encode([]); // Return an empty array
    exit();
}

// Prepare the SQL statement
$sql = "SELECT * FROM map WHERE LOWER(type) = LOWER(?)";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if (!$stmt) {
    die("Error in SQL preparation: " . $conn->error);
}

// Bind the parameter and execute the statement
$stmt->bind_param("s", $type);
$stmt->execute();

// Check for errors in execution
if ($stmt->error) {
    die("Error in SQL execution: " . $stmt->error);
}

// Fetch the result
$result = $stmt->get_result();

$flats = array();
while ($row = $result->fetch_assoc()) {
    $flats[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($flats);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
