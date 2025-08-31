<?php
include('db.php'); // Include database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $conn->real_escape_string($_POST['address']);
    $contact = $conn->real_escape_string($_POST['contact']);

    // Check if email already exists
    $check = "SELECT * FROM users WHERE email = '$email'";
    $check_result = $conn->query($check);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='register.php';</script>";
    } else {
        $sql = "INSERT INTO users (username, email, password, address, contact) 
                VALUES ('$username', '$email', '$password', '$address', '$contact')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Mr Tourist.Io</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <style>
   body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)),
                      url("images/i1.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    font-family: Arial, sans-serif;
}


    .form__container {
      background: #ffffff;
      max-width: 400px;
      margin: 80px auto;
      margin-top: 165px;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .form__container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form__container form div {
      margin-bottom: 20px;
    }

    .form__container label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #555;
    }

    .form__container input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      background-color: #fdfdfd;
      color: #333;
    }

    .form__container input:focus {
      border-color: #1e90ff;
      outline: none;
      background-color: #fff;
    }

    .form__container button {
      width: 100%;
      padding: 12px;
      background: #1e90ff;
      border: none;
      color: white;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .form__container button:hover {
      background: #0d75d8;
    }

    .form__container p {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
      color: #555;
    }

    .form__container a {
      color: #1e90ff;
      text-decoration: none;
    }

    .form__container a:hover {
      text-decoration: underline;
    }

    
  </style>
</head>
<body>

<!-- Shared Navbar (copied from features page) -->
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

<div class="form__container">
  <h2>Create a New Account</h2>
  <form method="POST" action="register.php">
    <div>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter your name" required>
    </div>
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create a password" required>
    </div>
    <div>
      <label for="address">Address</label>
      <input type="text" id="address" name="address" placeholder="Enter your address" required>
    </div>
    <div>
      <label for="contact">Contact</label>
      <input type="text" id="contact" name="contact" placeholder="Enter your contact number" required>
    </div>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="login_select.php">Login here</a></p>
  </form>
</div>

</body>
</html>
