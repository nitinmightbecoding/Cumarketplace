<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and escape form data
    $description = $conn->real_escape_string($_POST['productDescription']);
    $sellingPrice = $conn->real_escape_string($_POST['sellingPrice']);
    $uid = $conn->real_escape_string($_POST['contactName']);
    $email = $conn->real_escape_string($_POST['contactEmail']);
    $wano = $conn->real_escape_string($_POST['contactPhone']);
    $address = $conn->real_escape_string($_POST['address']);
    $localStorageEmail = $conn->real_escape_string($_POST['localStorageEmail']); // Retrieve and escape email from hidden input
    $rent = $conn->real_escape_string($_POST['rent']); // Retrieve and escape rent value

    // Handle the image upload
    $targetDir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION));
    $targetFile = $targetDir . uniqid() . '.' . $imageFileType; // Unique file name

    // Check if file is an image
    $check = getimagesize($_FILES['productImage']['tmp_name']);
    if ($check !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
            // Insert data into the buy table, including the rent value
            $sql_buy = "INSERT INTO buy (image, description, sp, wano, uid, email, address, rent) VALUES ('$targetFile', '$description', '$sellingPrice', '$wano', '$uid', '$email', '$address', '$rent')";

            if ($conn->query($sql_buy) === TRUE) {
                // Insert description into the boy table alongside the email
                // Match email from boy table with email from localStorageEmail
                $sql_boy = "INSERT INTO boy (email, dsp) SELECT email, '$description' FROM boy WHERE email = '$localStorageEmail' LIMIT 1";

                if ($conn->query($sql_boy) === TRUE) {
                    // Redirect to posted.html
                    header("Location: posted.html");
                    exit();
                } else {
                    echo "Error inserting into boy table: " . $conn->error;
                }
            } else {
                echo "Error inserting into buy table: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }

    $conn->close();
}
?>
