<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "tourist");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$package_id = $_GET['package_id'] ?? 0;

// Fetch user info (adjust if your users table has address and contact)
$user_stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();

// Fetch package info
$package_stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ?");
$package_stmt->bind_param("i", $package_id);
$package_stmt->execute();
$package = $package_stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $no_of_people = (int)$_POST['people'];
    $payment_method = $_POST['payment_method'];

    // Calculate duration in days between start and end date
    $duration_days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);

    if ($duration_days < 1) {
        echo "<script>alert('End date must be after start date.');</script>";
    } else {
        $duration = $duration_days . " days";  // store as string per your table
        $amount = $no_of_people * $package['price'] * $duration_days;

        $insert = $conn->prepare("INSERT INTO booking (user_id, package_id, full_name, address, contact, duration, no_of_people, amount, payment_method, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("iisssiidsss", $user_id, $package_id, $fullname, $address, $contact, $duration, $no_of_people, $amount, $payment_method, $start_date, $end_date);
        if ($insert->execute()) {
            echo "<script>alert('Booking successful!'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking Form | Mr. Tourist.Io</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .booking-container {
            background: #fff;
            border-radius: 12px;
            padding: 30px 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
            box-sizing: border-box;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 28px;
            color: #4b2a99;
            text-align: center;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            padding: 10px 15px;
            font-size: 15px;
            border-radius: 8px;
            border: 1.8px solid #ddd;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.4);
        }

        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        button[type="submit"] {
            background: #764ba2;
            color: #fff;
            font-weight: 700;
            font-size: 17px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 6px 18px rgba(118, 75, 162, 0.4);
        }

        button[type="submit"]:hover {
            background-color: #5a357e;
        }

        @media (max-width: 520px) {
            .booking-container {
                padding: 25px 20px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <h2>Booking Form</h2>
        <form method="POST" action="">
            <input type="hidden" name="package_id" value="<?= htmlspecialchars($package['package_id']) ?>">

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($user['username']) ?>" readonly>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>

            <label for="contact">Contact Number</label>
            <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($user['contact'] ?? '') ?>" required>

            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" required min="<?= date('Y-m-d') ?>">

            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required min="<?= date('Y-m-d') ?>">

            <label for="people">Number of People</label>
            <input type="number" id="people" name="people" min="1" value="1" required>

            <label for="amount">Amount (BDT)</label>
            <input type="text" id="amount" name="amount" readonly>

            <label for="payment_method">Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="" disabled selected>Select payment method</option>
                <option value="Bkash">Bkash</option>
                <option value="Nagad">Nagad</option>
                <option value="Rocket">Rocket</option>
                <option value="Card">Card</option>
                <option value="Cash">Cash</option>
            </select>

            <button type="submit">Confirm Booking</button>
        </form>
    </div>

    <script>
        const price = <?= json_encode($package['price']) ?>;
        const peopleInput = document.getElementById("people");
        const amountInput = document.getElementById("amount");
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");

        function calculateDays(start, end) {
            const diffTime = new Date(end) - new Date(start);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        function updateAmount() {
            const people = parseInt(peopleInput.value) || 1;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (startDate && endDate) {
                const days = calculateDays(startDate, endDate);
                if (days > 0) {
                    amountInput.value = (people * price * days).toFixed(2);
                } else {
                    amountInput.value = "Invalid date range";
                }
            } else {
                amountInput.value = "";
            }
        }

        peopleInput.addEventListener("input", updateAmount);
        startDateInput.addEventListener("change", updateAmount);
        endDateInput.addEventListener("change", updateAmount);
    </script>
</body>
</html>
