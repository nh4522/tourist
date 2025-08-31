<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Features | Mr Tourist.Io</title>
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
  <div class="nav__container">
    
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


    <section class="features__section">
      <div class="features__container">
        <div class="features__text">
          <h1>Our Standout Features</h1>
          <p>Everything you need for a smooth travel experience:</p>
          <div class="feature__item">
            <i class="ri-flight-takeoff-line"></i>
            <div>
              <h3>Instant Booking</h3>
              <p>Seamlessly book flights and hotels in just a few clicks.</p>
            </div>
          </div>

          <div class="feature__item">
            <i class="ri-map-pin-line"></i>
            <div>
              <h3>Smart Destination Suggestions</h3>
              <p>Personalized recommendations based on your interests.</p>
            </div>
          </div>

          <div class="feature__item">
            <i class="ri-customer-service-2-line"></i>
            <div>
              <h3>24/7 Live Chat</h3>
              <p>Our support team is available anytime, anywhere.</p>
            </div>
          </div>

          <div class="feature__item">
            <i class="ri-wallet-3-line"></i>
            <div>
              <h3>Budget Filters</h3>
              <p>Choose packages that fit your budget and travel goals.</p>
            </div>
          </div>

          <div class="feature__item">
            <i class="ri-image-line"></i>
            <div>
              <h3>Destination Gallery</h3>
              <p>Browse beautiful images before you plan your trip.</p>
            </div>
          </div>
        </div>

        <div class="features__image">
          <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="Travel Image" />
        </div>
      </div>
    </section>
  </body>
</html>
