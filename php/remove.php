<?php
// Ensure you have database connection details here
$servername = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email and description parameters exist in POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['description'])) {
    $email = $_POST['email'];
    $description = $_POST['description'];

    // Prepare SQL statement to delete matching description in buy table based on dsp in boy table
    $sqlDelete = "
        DELETE buy
        FROM buy
        JOIN boy ON buy.description = boy.dsp
        WHERE boy.email = ? AND buy.description = ?
    ";
    $stmtDelete = $conn->prepare($sqlDelete);

    if (!$stmtDelete) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute statement
    $stmtDelete->bind_param("ss", $email, $description);
    $stmtDelete->execute();

    // Check if deletion was successful
    if ($stmtDelete->affected_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }

    // Clean up
    $stmtDelete->close();
} else {
    // Invalid request
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>
