<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Select Login Type | Mr Tourist.Io</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url("images/i1.jpg") no-repeat center center/cover;
      height: 100vh;
      display: flex;
      flex-direction: column;
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

    .container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      text-align: center;
    }

    .login-box h1 {
      margin-bottom: 30px;
      color: #333;
    }

    .login-box a {
      display: inline-block;
      width: 200px;
      padding: 12px 20px;
      margin: 10px;
      font-size: 16px;
      background-color: #0077cc;
      color: white;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .login-box a:hover {
      background-color: #005fa3;
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

  <div class="container">
    <div class="login-box">
      <h1>Select Login Type</h1>
      <a href="login.php">User Login</a>
      <a href="admin_login.php">Admin Login</a>
    </div>
  </div>

</body>
</html>
