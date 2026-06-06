<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vpark";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_type = $_POST["vehicle_type"];
    $vehicle_number = $_POST["vehicle_number"];
    $entry_date = $_POST["entry_date"];
    $entry_time = $_POST["entry_time"];
    $exit_date = $_POST["exit_date"];
    $exit_time = $_POST["exit_time"];
    $user_id = $_SESSION["user_id"] ?? null;

    if (!$user_id) {
        echo "<script>alert('Please log in to book a slot.'); window.location.href='index.php';</script>";
        exit;
    }

    // Calculate duration and cost
    $entry_datetime = strtotime("$entry_date $entry_time");
    $exit_datetime = strtotime("$exit_date $exit_time");
    $duration_hours = round(($exit_datetime - $entry_datetime) / 3600, 2);
    $cost_per_hour = ($vehicle_type === "car") ? 160 : 60;
    $total_cost = $duration_hours * $cost_per_hour;

    // Insert booking data
    $sql = "INSERT INTO bookings (user_id, vehicle_type, vehicle_number, entry_time, exit_time, duration, cost) 
            VALUES ('$user_id', '$vehicle_type', '$vehicle_number', '$entry_datetime', '$exit_datetime', '$duration_hours', '$total_cost')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking Successful! Cost: $$total_cost'); window.location.href='history.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Slot - VPark</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f8f9fa; }
        .container { width: 50%; margin: auto; padding: 20px; background: white; box-shadow: 0px 0px 10px gray; border-radius: 10px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        label { font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Book a Parking Slot</h2>
    <form id="bookingForm" method="POST">
        <div class="form-group">
            <label for="vehicle_type">Vehicle Type</label>
            <select id="vehicle_type" name="vehicle_type" required>
                <option value="car">Car</option>
                <option value="bike">Bike</option>
            </select>
        </div>

        <div class="form-group">
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" id="vehicle_number" name="vehicle_number" placeholder="e.g., ABC123" required>
        </div>

        <div class="form-group">
            <label for="entry_date">Entry Date</label>
            <input type="date" id="entry_date" name="entry_date" required>
        </div>

        <div class="form-group">
            <label for="entry_time">Entry Time</label>
            <input type="time" id="entry_time" name="entry_time" required>
        </div>

        <div class="form-group">
            <label for="exit_date">Exit Date</label>
            <input type="date" id="exit_date" name="exit_date" required>
        </div>

        <div class="form-group">
            <label for="exit_time">Exit Time</label>
            <input type="time" id="exit_time" name="exit_time" required>
        </div>

        <div class="form-group">
            <label>Estimated Duration</label>
            <p id="durationDisplay">0 hours</p>
        </div>

        <div class="form-group">
            <label>Estimated Cost</label>
            <p id="costDisplay"></p>
        </div>

        <button type="submit" class="btn">Book Slot</button>
    </form>
</div>

<script>
document.getElementById("bookingForm").addEventListener("input", function() {
    let entryDate = document.getElementById("entry_date").value;
    let entryTime = document.getElementById("entry_time").value;
    let exitDate = document.getElementById("exit_date").value;
    let exitTime = document.getElementById("exit_time").value;
    let vehicleType = document.getElementById("vehicle_type").value;

    if (entryDate && entryTime && exitDate && exitTime) {
        let entry = new Date(entryDate + " " + entryTime);
        let exit = new Date(exitDate + " " + exitTime);
        let durationHours = Math.max(0, (exit - entry) / (1000 * 60 * 60));
        let costPerHour = (vehicleType === "car") ? 160 : 60;
        let totalCost = durationHours * costPerHour;

        document.getElementById("durationDisplay").innerText = durationHours.toFixed(2) + " hours";
        document.getElementById("costDisplay").innerText = "₹" + totalCost.toFixed(2);
    }
});
</script>

</body>
</html>
