<?php
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

// Check if POST parameters exist
if (isset($_POST['email']) && isset($_POST['description'])) {
    $email = $_POST['email'];
    $description = $_POST['description'];

    // Sanitize input
    $email = $conn->real_escape_string($email);
    $description = $conn->real_escape_string($description);

    // Step 1: Fetch 'dsp' column data from 'boy' table based on email
    $sqlBoy = "SELECT dsp FROM boy WHERE email = ?";
    $stmtBoy = $conn->prepare($sqlBoy);
    $stmtBoy->bind_param("s", $email);
    $stmtBoy->execute();
    $resultBoy = $stmtBoy->get_result();

    if ($resultBoy->num_rows > 0) {
        while ($rowBoy = $resultBoy->fetch_assoc()) {
            $dsp = $rowBoy['dsp'];

            // Step 2: Delete data from 'buy' table where 'description' matches 'dsp'
            // Using LIKE for partial matching
            $sqlDelete = "DELETE FROM buy WHERE description LIKE ? AND description LIKE ?";
            $likeDsp = "%{$dsp}%";
            $likeDescription = "%{$description}%";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("ss", $likeDsp, $likeDescription);
            $stmtDelete->execute();

            // Check if deletion was successful
            if ($stmtDelete->affected_rows > 0) {
                echo "Successfully deleted";
            } else {
                echo "No rows found matching the description.";
            }

            $stmtDelete->close();
        }
    } else {
        echo "No rows found in 'boy' table matching the email.";
    }

    $stmtBoy->close();
} else {
    echo "Invalid request. Email or description parameter is missing.";
}

// Close connection
$conn->close();
?>
