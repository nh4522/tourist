<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "tourist";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $message = trim($_POST["message"]);

  if (!empty($name) && !empty($email) && !empty($message)) {
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
      $success = "Message sent successfully!";
    } else {
      $error = "Something went wrong. Please try again.";
    }
  } else {
    $error = "All fields are required.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us | Mr Tourist.Io</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@500;700&display=swap"
      rel="stylesheet"
    />
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
        <?php if (isset($_SESSION['username'])): ?>
          <li class="link"><a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
          <li class="link"><a href="logout.php" class="nav-btn">Logout</a></li>
        <?php else: ?>
          <li class="link"><a href="login_select.php" class="nav-btn">Login</a></li>
          <li class="link"><a href="register.php" class="nav-btn register">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <section class="contact__section">
    <div class="contact__container">
      <div class="contact__info">
        <h1>Get in Touch</h1>
        <p>Have questions? We’re here to help you plan your dream adventure.</p>
        <ul>
          <li><i class="ri-map-pin-line"></i> 123 Travel Lane, Wanderlust City</li>
          <li><i class="ri-phone-line"></i> +123 456 7890</li>
          <li><i class="ri-mail-line"></i> support@mrtourist.io</li>
        </ul>
      </div>

      <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
      <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

      <form class="contact__form" method="POST" action="">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </section>
</body>
</html>
