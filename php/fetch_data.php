<?php
$servername = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 1: Retrieve email ID from GET parameter
$email = $_GET['email'];

// Step 2: Fetch 'dsp' column data from 'boy' table based on email
$sqlBoy = "SELECT dsp FROM boy WHERE email = ?";
$stmtBoy = $conn->prepare($sqlBoy);
$stmtBoy->bind_param("s", $email);
$stmtBoy->execute();
$resultBoy = $stmtBoy->get_result();

if ($resultBoy->num_rows > 0) {
    while ($rowBoy = $resultBoy->fetch_assoc()) {
        $dsp = $rowBoy['dsp'];

        // Step 3: Fetch data from 'buy' table where 'description' matches 'dsp'
        $sqlBuy = "SELECT * FROM buy WHERE description = ?";
        $stmtBuy = $conn->prepare($sqlBuy);
        $stmtBuy->bind_param("s", $dsp);
        $stmtBuy->execute();
        $resultBuy = $stmtBuy->get_result();

        // Displaying the fetched data
        while ($rowBuy = $resultBuy->fetch_assoc()) {
            echo "<div class='box' data-id='" . $rowBuy['id'] . "'>";
            echo "<p>Description: " . $rowBuy['description'] . "</p>";
            if (!empty($rowBuy['image'])) {
                echo "<img src='" . $rowBuy['image'] . "' alt='Image' style='max-width:100%;height:auto;'>";
            }
            echo "<button class='remove-btn' data-id='" . $rowBuy['id'] . "'>Remove</button>";
            echo "</div>";
        }

        $stmtBuy->close();
    }
}

$stmtBoy->close();
$conn->close();
?>