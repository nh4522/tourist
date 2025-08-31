<?php
session_start(); // Make sure session is started to access login info

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "tourist";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all packages from the database
$packages_result = $conn->query("SELECT * FROM packages ORDER BY package_id ASC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>View Tourism Packages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f6f8;
            color: #333;
        }

        h1 {
            color: #005f73;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: #fff;
            box-shadow: 0 0 5px #ccc;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #0a9396;
            color: #fff;
        }

        tr:hover {
            background: #e0f2f1;
        }

        a.book-btn {
            color: white;
            background-color: #005f73;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a.book-btn:hover {
            background-color: #0a9396;
        }

        .nav__container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .nav__logo a {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-color);
            font-family: "Playfair Display", serif;
        }

        .nav__links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav__container .nav__links .link a {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-light);
            transition: var(--transition);
        }

        .nav__links .link a:hover {
            color: var(--primary-color);
        }
    </style>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- Navigation bar -->
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
                    <li class="link"><a href="login.php" class="nav-btn">Login</a></li>
                    <li class="link"><a href="register.php" class="nav-btn register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Heading -->
    <h1>View Tourism Packages</h1>

    <!-- Packages Table -->
    <div class="section">
        <h2>Available Packages</h2>
        <table>
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Price ($)</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($package = $packages_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($package['package_name']) ?></td>
                        <td><?= number_format($package['price'], 2) ?></td>
                        <td><?= htmlspecialchars($package['location']) ?></td>
                        <td><?= htmlspecialchars($package['description']) ?></td>
                        <td>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="booking_form.php?package_id=<?= $package['package_id'] ?>" class="book-btn">Book</a>
                            <?php else: ?>
                                <a href="login.php" class="book-btn">Book</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($packages_result->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No packages available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>