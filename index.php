<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPark - Smart Parking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #007bff;
            padding: 15px;
        }
        .nav-links {
            list-style: none;
            display: flex;
        }
        .nav-links li {
            margin: 0 15px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .hero {
            text-align: center;
            padding: 50px;
            background: #007bff;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background: #333;
            border-radius: 5px;
        }
        .primary-btn { background: #28a745; }
        .secondary-btn { background: #6c757d; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <i class="fas fa-parking"></i>
                <h1>VPark</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="history.php" class="history-btn">My Bookings</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="login-btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Smart Parking Solution</h1>
            <p>Find and reserve parking spaces in real-time with VPark</p>
            <div class="hero-buttons">
                <a href="book-slot.php" class="btn primary-btn">Book Now</a>
                <a href="#about" class="btn secondary-btn">Learn More</a>
            </div>
        </div>
    </section>
</body>
</html>
