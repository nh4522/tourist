<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "tourist";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (!password_verify($current, $hashed_password)) {
            $error = "Current password is incorrect.";
        } elseif ($new !== $confirm) {
            $error = "New passwords do not match.";
        } elseif (strlen($new) < 6) {
            $error = "New password must be at least 6 characters long.";
        } else {
            $new_hashed = password_hash($new, PASSWORD_BCRYPT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $new_hashed, $email);

            if ($update->execute()) {
                $success = "Password changed successfully.";
            } else {
                $error = "Something went wrong. Try again later.";
            }
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password | Mr Tourist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        /* Header Logo */
        .header {
            width: 100%;
            background-color: #004b63;
            padding: 15px 30px;
            text-align: left;
        }

        .header a {
            text-decoration: none;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            font-family: 'Playfair Display', serif;
        }

        .password-box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 250px;
        }

        .password-box h2 {
            margin-bottom: 20px;
            color: #004b63;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        button {
            background-color: #004b63;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #006a8e;
        }

        .message {
            margin-bottom: 15px;
            color: red;
            font-weight: bold;
        }

        .message.success {
            color: green;
        }
    </style>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav>
  <div class="nav__logo"><a href="index.php">Mr. Tourist</a></div>
  <div class="nav__container">
    
    <ul class="nav__links">
      <li class="link"><a href="index.php">Home</a></li>
      <li class="link"><a href="features.php">Features</a></li>
      <li class="link"><a href="about.php">About Us</a></li>
      <li class="link"><a href="contact.php">Contact Us</a></li>

     
    </ul>
  </div>
</nav>

  

    <div class="password-box">
        <h2>Change Password</h2>
        <?php if ($error): ?>
            <div class="message"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>
</html>

