<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize the form data
$email = trim($_POST['email']); 
$password = trim($_POST['password']); 

// Debugging: Check if email and password are correctly received
if (empty($email) || empty($password)) {
    die("Email or password is empty.");
}

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM boy WHERE email = ? AND password = ?"); 
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check if the query ran successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Check if the user exists
if ($result->num_rows > 0) {
    // User exists, redirect to main.html
    header("Location: main.html");
    exit();
} else {
    // User doesn't exist, show a popup and redirect back to login
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Code Challenge</title>
        <style>
            body {
                background: linear-gradient(45deg, #1a1a1a, #333);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: #fff;
                position: relative;
                overflow: hidden;
            }
            .modal {
                display: flex; 
                position: fixed; 
                z-index: 1000; 
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto; 
                background-color: rgba(0, 0, 0, 0.7); 
                justify-content: center;
                align-items: center;
            }
            .modal-content {
                background-color: #222;
                margin: auto;
                padding: 20px;
                border: 1px solid #444;
                width: 80%;
                max-width: 500px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 255, 0, 0.7);
                color: #00FF00;
                text-align: center;
                animation: modalopen 0.4s;
            }
            @keyframes modalopen {
                from { opacity: 0; transform: translateY(-50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .modal-button {
                background: #444;
                color: #00FF00;
                border: 2px solid #00FF00;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s ease, color 0.3s ease;
                margin-top: 20px;
            }
            .modal-button:hover {
                background: #00FF00;
                color: #444;
            }
        </style>
    </head>
    <body>
        <div id='customModal' class='modal'>
            <div class='modal-content'>
                <p id='modalMessage'>Wrong credentials, please signup first if you are a new user.</p>
                <button class='modal-button' onclick='closeModal()'>OK</button>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById('customModal').style.display = 'none';
                window.location.href = 'index.html';
            }
        </script>
    </body>
    </html>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
