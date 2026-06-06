<?php
session_start();
include 'db.php'; // Database connection file

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch latest booking details for the logged-in user
$sql = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Database error: " . $conn->error);
}

$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: book-slot.php"); // Redirect if no booking found
    exit();
}

// Generate JSON for QR Code
$qrData = json_encode([
    "booking_id" => $booking['booking_id'],
    "vehicle_number" => $booking['vehicle_number'],
    "slot" => $booking['selected_slot'],
    "entry_time" => $booking['entry_time']
]);

$qrEncoded = urlencode($qrData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - VPark</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>VPark</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="history.php">My Bookings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="booking-section">
        <div class="container">
            <h2>Booking Confirmation</h2>
            <p>Your parking slot has been successfully booked.</p>
            
            <div class="booking-details">
                <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['booking_id']); ?></p>
                <p><strong>Vehicle Type:</strong> <?php echo ucfirst(htmlspecialchars($booking['vehicle_type'])); ?></p>
                <p><strong>Vehicle Number:</strong> <?php echo htmlspecialchars($booking['vehicle_number']); ?></p>
                <p><strong>Parking Slot:</strong> <?php echo htmlspecialchars($booking['selected_slot']); ?></p>
                <p><strong>Entry Time:</strong> <?php echo htmlspecialchars($booking['entry_time']); ?></p>
                <p><strong>Exit Time:</strong> <?php echo htmlspecialchars($booking['exit_time']); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($booking['duration']); ?> hours</p>
                <p><strong>Amount Paid:</strong> $<?php echo htmlspecialchars($booking['cost']); ?></p>
                <p><strong>Payment Method:</strong> <?php echo ucfirst(htmlspecialchars($booking['payment_method'])); ?></p>
                <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($booking['transaction_id']); ?></p>
                
                <div class="qr-code">
                    <h4>Scan QR Code at Entry</h4>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $qrEncoded; ?>" alt="Booking QR Code">
                </div>
            </div>
            
            <a href="index.php" class="btn">Back to Home</a>
        </div>
    </section>
</body>
</html>
