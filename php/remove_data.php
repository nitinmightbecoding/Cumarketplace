 <?php
header('Content-Type: application/json');

$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Get the email from the GET request
$email = $_GET['email'] ?? '';

if ($email) {
    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Fetch all non-empty dsp values from the boy table based on the email
    $sql = $conn->prepare("SELECT dsp FROM boy WHERE email = ? AND dsp <> ''");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    $deletedRows = 0;

    while ($row = $result->fetch_assoc()) {
        $dsp = $row['dsp'];
        
        // Delete the rows in the buy table where description matches dsp
        $delete_sql = $conn->prepare("DELETE FROM buy WHERE description = ?");
        $delete_sql->bind_param("s", $dsp);
        $delete_sql->execute();
        $deletedRows += $delete_sql->affected_rows;
    }

    if ($deletedRows > 0) {
        echo json_encode(['success' => "Deleted $deletedRows rows successfully"]);
    } else {
        echo json_encode(['error' => 'No matching rows found or already deleted']);
    }

    $sql->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No email provided']);
}
?>