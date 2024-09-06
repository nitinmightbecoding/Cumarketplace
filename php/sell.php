<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <link rel="icon" href="cu.png" type="image/png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            background: #000;
            text-align: center;
            position: relative;
        }

        h1 {
            margin-top: 50px;
            font-size: 2.5rem;
            color: #fff;
        }

        .search-container {
            margin: 20px;
        }

        .search-container input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            background: linear-gradient(135deg, rgba(255, 0, 150, 0.1), rgba(0, 123, 255, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .product-card img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .product-card img:hover {
            transform: scale(1.1);
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-card .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .product-card .description {
            font-size: 1rem;
            color: #ddd;
            margin: 10px 0;
            height: 100px;
            overflow: hidden;
        }

        .product-card .contact-details {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8));
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transform: rotateY(180deg);
            backface-visibility: hidden;
            transition: transform 0.6s, opacity 0.6s;
            opacity: 0;
            pointer-events: none;
        }

        .product-card .contact-details.active {
            transform: rotateY(0deg);
            opacity: 1;
            pointer-events: auto;
        }

        .product-card .contact-details p {
            margin: 10px;
            color: #fff;
        }

        .product-card .contact-details p strong {
            color: #ff007a;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }

        .product-card .button-container {
            display: flex;
            justify-content: space-between;
            width: calc(100% - 40px);
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .product-card .details-button,
        .product-card .chat-button {
            background: #ff007a;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            color: #fff;
            cursor: pointer;
            flex: 1;
            margin: 0 5px;
        }

        .product-card .details-button:hover,
        .product-card .chat-button:hover {
            background: #ff4d94;
        }

        .close-details {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }

        .close-details:hover {
            color: #ddd;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
            cursor: zoom-out;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
        }

        .wave-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            overflow: hidden;
            z-index: -1;
        }

        .wave {
            position: absolute;
            width: 200%;
            height: 100%;
            background: rgba(255, 215, 0, 0.3);
            border-radius: 50%;
            opacity: 0.4;
            animation: wave 10s infinite linear;
        }

        .wave:nth-child(2) {
            background: rgba(255, 223, 0, 0.3);
            animation: wave 15s infinite linear;
            animation-delay: -5s;
        }

        @keyframes wave {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.5) rotate(45deg);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .message-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .message-button img {
            width: 50px;
            height: 50px;
            opacity: 0.6;
            transition: opacity 0.3s;
        }


       .share-image {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 38px; /* Adjust size as needed */
            height: auto;
            cursor: pointer;
            z-index: 1000; /* Ensure it's on top */
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .share-image:hover {
            opacity: 1;
        }

        .notification-dot {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 12px;
            height: 12px;
            background-color: red;
            border-radius: 50%;
            display: none; /* Hide the dot by default */
        }

        .rent-label {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.8), rgba(255, 215, 0, 0.4));
    color: #fff;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
    text-transform: uppercase;
    animation: shine 1.5s infinite;
    z-index: 10;
}

@keyframes shine {
    0% {
        background-position: -200%;
    }
    100% {
        background-position: 200%;
    }
}


    </style>
</head>

<body>
    <h1>Listed Products</h1>
    <div class="search-container">
        <input type="text" id="search-bar" onkeyup="searchProducts()" placeholder="Search for products...">
    </div>
    <div class="products-container">
        <?php
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

        // Query to select description, image, sp, wano, uid, email, address from 'buy' table
      // Query to select description, image, sp, wano, uid, email, address, rent from 'buy' table
$query = "SELECT description, image, sp, wano, uid, email, address, rent FROM buy";
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all rows from the result set
    while ($row = $result->fetch_assoc()) {
        $description = $row['description'];
        $image = $row['image'];
        $selling_price = $row['sp'];
        $wano = $row['wano'];
        $uid = $row['uid'];
        $email = $row['email'];
        $address = $row['address'];
        $rent = $row['rent']; // Add this line

        $rentClass = ($rent === 'yes') ? 'rent-label' : ''; // Determine if label should be shown

        echo '<div class="product-card animate_animated animate_fadeInUp">';
        if (!empty($image)) {
            echo '<img src="' . $image . '" alt="Product Image" onclick="openModal(this.src)">'; // Added onclick for modal
        } else {
            echo '<p>No image available</p>';
        }
        echo '<input type="hidden" class="product-description" value="' . htmlspecialchars($description) . '">';
        echo '<p class="price">₹ ' . number_format($selling_price) . '</p>';
        echo '<p class="description">' . $description . '</p>';
        echo '<div class="contact-details">';
        echo '<p><strong>WhatsApp No:</strong> ' . $wano . '</p>';
        echo '<p><strong>UID:</strong> ' . $uid . '</p>';
        echo '<p><strong>Email:</strong> ' . $email . '</p>';
        echo '<p><strong>Address:</strong> ' . $address . '</p>';
        echo '<span class="close-details" onclick="hideDetails(this)">×</span>';
        echo '</div>';
        echo '<div class="button-container">';
        echo '<button class="details-button" onclick="showDetails(this)">View Details</button>';
        echo '<button class="chat-button" onclick="openChat(\'' . htmlspecialchars($description) . '\')">Chat</button>';
        echo '</div>';
        if ($rentClass) {
            echo '<div class="' . $rentClass . '">For Rent</div>'; // Add the rent label
        }
        echo '</div>';
    }
} else {
    echo "No products found.";
}

        // Close the connection
        $conn->close();
        ?>
    </div>
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Modal for image display -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
      <div class="share-container" onclick="shareWithFriends()">
   <img src="share.png" alt="Share" class="share-image" onclick="shareWithFriends()">

    <button class="message-button" onclick="window.location.href='chaat2.html'">
        <img src="message.svg" alt="Message Icon">
        <span class="notification-dot" id="notification-dot"></span>
    </button>
 
    <script>
        function searchProducts() {
            var input, filter, cards, cardContainer, title, i;
            input = document.getElementById("search-bar");
            filter = input.value.toUpperCase();
            cardContainer = document.getElementsByClassName("products-container")[0];
            cards = cardContainer.getElementsByClassName("product-card");
            for (i = 0; i < cards.length; i++) {
                title = cards[i].getElementsByClassName("description")[0];
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

        function showDetails(button) {
            var card = button.parentElement.parentElement;
            var contactDetails = card.getElementsByClassName("contact-details")[0];
            contactDetails.classList.add("active");
        }

        function hideDetails(span) {
            var contactDetails = span.parentElement;
            contactDetails.classList.remove("active");
        }

        function openChat(description) {
            // Pass the description to the next page via URL without displaying any alert
            window.location.href = "chaat.html?description=" + encodeURIComponent(description);
        }

        function openModal(src) {
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("modalImage");
            modal.style.display = "block";
            modalImg.src = src;
        }

        function closeModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }


         function shareWithFriends() {
            var textToShare = "Hey i found a cool website where we can buy sell used products within hostel. See the list of products by clicking on link...   ";
            // Use the Web Share API to share content
            if (navigator.share) {
                navigator.share({
                    title: 'Bitching Club',
                    text: textToShare,
                    url: 'https://cumarketplace.in/sell2.php'
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch((error) => {
                    console.error('Error sharing:', error);
                });
            } else {
                // Fallback to WhatsApp if Web Share API is not supported
                window.open("https://api.whatsapp.com/send?text=" + encodeURIComponent(textToShare));
            }
        }



        function showNotificationDot(show) {
            var dot = document.getElementById("notification-dot");
            if (show) {
                dot.style.display = "block";
            } else {
                dot.style.display = "none";
            }
        }

        // Example usage
        document.addEventListener("DOMContentLoaded", function() {
            // Simulate new messages after 5 seconds
            setTimeout(function() {
                showNotificationDot(true);
            }, 5000);
        });
    </script>
</body>

</html>
