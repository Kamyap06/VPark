<?php
// Start session (if login system exists)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History - VPark</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <i class="fas fa-parking"></i>
                <h1>VPark</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#services">Services</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                <li><a href="history.php" class="history-btn active">My Bookings</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="history-section">
        <div class="container">
            <div class="history-header">
                <h2>My Booking History</h2>
                <p>View and manage your parking bookings</p>
            </div>

            <div class="bookings-container">
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "vpark_db");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch bookings from database
                $sql = "SELECT * FROM bookings ORDER BY entry_time DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="booking-card ' . strtolower($row["status"]) . '">
                            <div class="booking-status">
                                <span class="status-badge">' . ucfirst($row["status"]) . '</span>
                            </div>
                            <div class="booking-info">
                                <h3>Booking #' . $row["booking_id"] . '</h3>
                                <div class="vehicle-info">
                                    <i class="fas ' . ($row["vehicle_type"] == "Car" ? "fa-car" : "fa-motorcycle") . '"></i>
                                    <span>' . $row["vehicle_type"] . ' - ' . $row["vehicle_number"] . '</span>
                                </div>
                                <div class="booking-details">
                                    <div class="detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Slot ' . $row["selected_slot"] . '</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>' . date("F j, Y", strtotime($row["entry_time"])) . '</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-clock"></i>
                                        <span>' . date("h:i A", strtotime($row["entry_time"])) . ' - ' . date("h:i A", strtotime($row["exit_time"])) . '</span>
                                    </div>
                                    <div class="detail">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>$' . $row["cost"] . '</span>
                                    </div>
                                </div>
                            </div>
                            <div class="booking-actions">
                                <a href="booking-details.php?id=' . $row["booking_id"] . '" class="btn secondary-btn sm">View Details</a>';
                        if ($row["status"] == "Upcoming") {
                            echo '<button class="btn danger-btn sm">Cancel Booking</button>';
                        } elseif ($row["status"] == "Active") {
                            echo '<button class="btn primary-btn sm">Extend Time</button>';
                        } else {
                            echo '<button class="btn primary-btn sm">Book Again</button>';
                        }
                        echo '</div></div>';
                    }
                } else {
                    echo "<p>No bookings found.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 VPark. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
