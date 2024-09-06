<?php
$host = "sql201.infinityfree.com";
$username = "if0_36704551";
$password = "eS5LSCMb7IXSd8v";
$dbname = "if0_36704551_code";

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $lati = $_POST['lati'];
    $longi = $_POST['longi'];
    $rent = $_POST['rent'];
    $dsp = $_POST['dsp'];
    $size = $_POST['size'];
    $tc = $_POST['tc'];
    $sellerwhatsapp = $_POST['sellerwhatsapp'];
    $sellername = $_POST['sellername'];
    $relationship = $_POST['relationship'];
    $owner = $_POST['owner'];
    $maintainance_option = $_POST['maintainance_option'];
    $maintainance_charge = ($maintainance_option === 'specify_charge') ? $_POST['maintainance_charge'] : 0;
    $floor = $_POST['floor'];
    $totalfloor = $_POST['totalfloor'];
    $genderprefered = $_POST['genderprefered'];
    $furnsihed = isset($_POST['furnsihed']) ? $_POST['furnsihed'] : 'no';
    $ac = isset($_POST['ac']) ? 'yes' : 'no';
    $washing = isset($_POST['washing']) ? 'yes' : 'no';
    $bed = isset($_POST['bed']) ? 'yes' : 'no';
    $sofa = isset($_POST['sofa']) ? 'yes' : 'no';
    $toilet = $_POST['toilet'];
    $securitydeposit = $_POST['securitydeposit'];
    $electricitybill = $_POST['electricitybill'];
    $waterbill = $_POST['waterbill'];
    $parking = isset($_POST['parking']) ? $_POST['parking'] : 'no';
    $calll = $_POST['call_number']; // New phone number for calling field
    $maintainance_option2 = $_POST['maintainance_option2'];
    $maintainance_charge2 = ($maintainance_option2 === 'specify_charge2') ? $_POST['maintainance_charge2'] : 0;
 

    // New field: Seller Email ID
    $mail = $_POST['mail']; // Get the email from the form

    // Since the 'brokerage' value isn't directly provided, make sure it is defined
    $brokerage = $maintainance_charge2;
     $location = $_POST['location'];
      $type = $_POST['type'];

    // Handle image uploads
    $imagePaths = [];
    $imageDirectory = 'uploads/'; // Directory where the images will be stored

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $imageName = $_FILES['images']['name'][$key];
        $imagePath = $imageDirectory . basename($imageName);
        move_uploaded_file($tmp_name, $imagePath);
        $imagePaths[] = $imagePath;
    }

    // Store images as a comma-separated string
    $images = implode(',', $imagePaths);

    // Prepare the SQL query to insert the data
    $stmt = $pdo->prepare('INSERT INTO map (lati, longi, rent, dsp, size, tc, sellerwhatsapp, sellername, image, relationship, owner, maintainance, floor, totalfloor, genderprefered, furnsihed, ac, washing, bed, sofa, toilet, securitydeposit, electricitybill, waterbill, parking, calll, brokerage, mail, location, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    // Execute the query with the form data
    $stmt->execute([
        $lati, $longi, $rent, $dsp, $size, $tc, $sellerwhatsapp, $sellername, $images, 
        $relationship, $owner, $maintainance_charge, $floor, $totalfloor, $genderprefered, 
        $furnsihed, $ac, $washing, $bed, $sofa, $toilet, $securitydeposit, $electricitybill, 
        $waterbill, $parking, $calll, $brokerage, $mail, $location, $type
    ]);

    echo "Flat listed successfully!";
} catch (PDOException $e) {
    // Catch any errors and display them
    echo 'Connection failed: ' . $e->getMessage();
}
?>
