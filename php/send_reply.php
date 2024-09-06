<?php
header('Content-Type: application/json');

// Database credentials
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$sender = $conn->real_escape_string($input['sender']);
$description = $conn->real_escape_string($input['description']);
$message = $conn->real_escape_string($input['message']);

// Debugging output to check received description
error_log("Received description: $description");

// Query to fetch receiver email based on description
$query = "SELECT email FROM boy WHERE dsp = '$description'";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $receiver = $row['email'];

        // Insert the message into the database
        $insertQuery = "INSERT INTO text (chat, sender, receiver) VALUES ('$message', '$sender', '$receiver')";
        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send message: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Receiver not found for description: ' . $description]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error executing query: ' . $conn->error]);
}

// Close the connection
$conn->close();
?>
