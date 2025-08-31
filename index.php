<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />

    <style>
      <style>
  /* Center the entire container (the div with class "container") vertically and horizontally */
  .container {
    display: flex;
    justify-content: center;  /* center horizontally */
    align-items: center;      /* center vertically */
    min-height: 100vh;        /* full viewport height */
    flex-direction: column;   /* stack children vertically */
    text-align: center;       /* center text inside */
    padding: 20px;
    box-sizing: border-box;
    
  }

  /* Optional: limit max-width of the content */
  .content {
    max-width: 600px;
   
  }
  .content p {
    text-align: left;
    margin: 0 auto;
    max-width: 500px;
  }

  /* Center the button inside btns horizontally */
  .btns {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
<style>
  /* Ensure full height for vertical centering */
  html, body {
    height: 100%;
    margin: 0;
  }

  /* Center the entire container vertically and horizontally */
  .container {
    display: flex;
    justify-content: center;  /* horizontal center */
    align-items: center;      /* vertical center */
    min-height: 100vh;        /* full viewport height */
    flex-direction: column;   /* stack children vertically */
    text-align: center;       /* center text inside */
    padding: 20px;
    box-sizing: border-box;
  }

  /* Limit the max width of the content */
  .content {
    max-width: 600px;
  }

  /* Paragraph styling: left-align text but keep centered block */
  .content p {
    text-align: left;
    margin: 0 auto;
    max-width: 500px;
  }

  /* Center the button inside btns horizontally */
  .btns {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  /* Username link styles */
  .username-link {
    padding: 6px 12px;
    border-radius: 8px;
    background-color: rgb(50, 51, 53);
    color: #0077cc;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }

  .username-link:hover {
    background-color: #e0efff;
    color: #005fa3;
  }

  #usern {
    font-weight: 400;
  }
</style>


    <title>Web Design | Mr Tourist.Io</title>
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
          <a id="usern" href="profile.php" class="username-link">
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


    <div class="container">
      
        <div class="content">
          <h1>DISCOVER<br />YOUR WORLD</h1>
          <p>
            Embark on unforgettable journeys and create lasting memories. Experience diverse cultures,
            savor exotic cuisines, and witness breathtaking landscapes across the globe.
          </p>
          <div class="btns">
           
          <a href="view_package.php" style="text-decoration: none;">
  <button class="our__blogs" style="
      padding: 10px 20px;
       background-color: var(--primary-color);
      color: var(--text-dark) !important;
      border: none;
      border-radius: 35px;
      
      cursor: pointer;
      ">
    View Packages
  </button>
</a>

          </div>
          <div class="chevrons">
            <span class="chev__left">
              <i class="ri-arrow-left-s-line"></i>
            </span>
            <span class="chev__right">
              <i class="ri-arrow-right-s-line"></i>
            </span>
          </div>
        </div>
      
     
   
    </div>
  </body>
</html>
