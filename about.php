<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us | Mr Tourist.Io</title>
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
  <div class="nav__logo"><a href="#">Mr. Tourist</a></div>
  
    <ul class="nav__links">
      <li class="link"><a href="index.php">Home</a></li>
      <li class="link"><a href="features.php">Features</a></li>
      <li class="link"><a href="about.php">About Us</a></li>
      <li class="link"><a href="contact.php">Contact Us</a></li>

      <?php if (isset($_SESSION['username'])): ?>
        <li class="link">
          <a href="profile.php" class="username-link">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
          </a>
        </li>
        <li class="link"><a href="logout.php" class="nav-btn">Logout</a></li>
      <?php else: ?>
        <li class="link"><a href="login_select.php" class="nav-btn">Login</a></li>
        <li class="link"><a href="register.php" class="nav-btn register">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>


    <section class="about__section">
      <div class="about__container">
        <h1>Who We Are</h1>
        <p>
          Mr Tourist.Io is a team of travel enthusiasts dedicated to helping people
          explore the world easily and affordably.
        </p>
        <p>
          We believe that traveling is not just about places; it's about experiences,
          cultures, and memories.
        </p>

        <h2>Our Mission</h2>
        <p>
          To make travel planning simple, transparent, and exciting through the best
          packages, local insights, and expert guidance.
        </p>

        <h2>Why Choose Us?</h2>
        <ul class="features-list">
          <li>🌍 Global Destinations</li>
          <li>💸 Affordable Packages</li>
          <li>📞 24/7 Support</li>
          <li>✅ Trusted by Thousands of Travelers</li>
        </ul>
      </div>
    </section>
  </body>
</html>
