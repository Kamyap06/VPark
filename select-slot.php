<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vpark_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch slots from database
$sql = "SELECT * FROM slots";
$result = $conn->query($sql);
$slots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Slot - VPark</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .parking-grid { display: grid; grid-template-columns: repeat(4, 80px); gap: 10px; justify-content: center; margin-top: 20px; }
        .parking-slot { width: 80px; height: 80px; text-align: center; line-height: 80px; font-weight: bold; cursor: pointer; border-radius: 5px; }
        .available { background: green; color: white; }
        .occupied { background: red; color: white; pointer-events: none; }
        .selected { background: blue; color: white; }
        .btn { margin-top: 20px; padding: 10px 20px; font-size: 16px; cursor: pointer; border: none; background: #333; color: white; border-radius: 5px; }
        .btn:disabled { background: gray; cursor: not-allowed; }
    </style>
</head>
<body>
    <h2>Select a Parking Slot</h2>
    <p>Choose an available parking slot for your vehicle</p>
    <div class="parking-grid">
        <?php foreach ($slots as $slot): ?>
            <div class="parking-slot <?= $slot['status']; ?>" data-slot="<?= $slot['slot_name']; ?>">
                <?= $slot['slot_name']; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <form id="slotSelectionForm" action="book-slot.php" method="post">
        <input type="hidden" id="selected_slot" name="selected_slot">
        <button type="submit" class="btn" id="continueToPaymentBtn" disabled>Continue to Payment</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const parkingSlots = document.querySelectorAll('.parking-slot');
            const selectedSlotInput = document.getElementById('selected_slot');
            const continueBtn = document.getElementById('continueToPaymentBtn');

            parkingSlots.forEach(slot => {
                if (!slot.classList.contains('occupied')) {
                    slot.addEventListener('click', function () {
                        parkingSlots.forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedSlotInput.value = this.getAttribute('data-slot');
                        continueBtn.disabled = false;
                    });
                }
            });
        });
    </script>
</body>
</html>