<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tourist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_panel.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No admin found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Mr Tourist.Io</title>
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

    nav {
      background-color: #333;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav__logo a {
      color: #fff;
      font-size: 24px;
      text-decoration: none;
      font-weight: bold;
    }

    .nav__links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .nav__links .link a {
      color: #fff;
      text-decoration: none;
      font-size: 16px;
      transition: color 0.3s;
    }

    .nav__links .link a:hover {
      color: #f0c040;
    }

    .form__container {
      max-width: 400px;
      margin: 60px auto;
      background-color: #fff;
      height: 325px;
      margin-top: 135px;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .form__container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form__group {
      margin-bottom: 15px;
    }

    .form__group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }

    .form__group input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background-color: #0077cc;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #005fa3;
    }

    p {
      text-align: center;
      margin-top: 15px;
    }

    p a {
      color: #0077cc;
      text-decoration: none;
    }

    p a:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <nav>
    <div class="nav__logo"><a href="index.php">Mr. Tourist</a></div>
    <ul class="nav__links">
      <li class="link"><a href="index.php">Home</a></li>
      <li class="link"><a href="features.php">Features</a></li>
      <li class="link"><a href="about.php">About Us</a></li>
      <li class="link"><a href="contact.php">Contact Us</a></li>
    </ul>
  </nav>

  <div class="form__container">
    <h2>Admin Login Here</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
      <div class="form__group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form__group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
