<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "tourist";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// Fetch user info
$stmt = $conn->prepare("SELECT id, username, address, contact FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();
$user_id = $user['id'];  // <-- get user id here

// Fetch purchase history for this user
$history_stmt = $conn->prepare("
    SELECT p.package_name, p.price, p.location, p.description, b.booking_date
    FROM booking b
    JOIN packages p ON b.package_id = p.package_id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
");
$history_stmt->bind_param("i", $user_id);  // use integer binding here
$history_stmt->execute();
$history_result = $history_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Your Profile | Mr Tourist</title>
<style>
    /* Profile & Sidebar Layout */
body {
  font-family: 'Open Sans', sans-serif;
  background-color: #f5f9fc;
  color: #333;
  margin: 0;
  display: flex;
  flex-direction: row;
  min-height: 100vh;
}

.sidebar {
  background: linear-gradient(135deg, #006a8e, #004b63);
  color: #fff;
  width: 250px;
  padding: 2rem 1.5rem;
  display: flex;
  flex-direction: column;
}

.sidebar h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.7rem;
  margin-bottom: 2rem;
  color: #fff;
}

.sidebar a {
  color: #d4eaf6;
  text-decoration: none;
  margin: 0.5rem 0;
  padding: 0.6rem 1rem;
  border-radius: 8px;
  transition: background 0.3s, color 0.3s;
  font-weight: 600;
}

.sidebar a:hover {
  background-color: #00425b;
  color: #fff;
}

.content {
  flex: 1;
  padding: 3rem 4rem;
  background-color: #fff;
  box-shadow: -3px 0 10px rgba(0, 0, 0, 0.05);
}
.content h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: #004b63;
  margin-bottom: 2rem;
}

.content h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: #004b63;
  margin-bottom: 2rem;
}

.profile-field {
  margin-bottom: 2rem;
}

.profile-field label {
  display: block;
  font-weight: 600;
  color: #006a8e;
  font-size: 1rem;
  margin-bottom: 0.5rem;
}

.profile-field div,
.username-display {
  background-color: #eef7fb;
  padding: 0.9rem 1.2rem;
  border: 1px solid #c5dfea;
  border-radius: 10px;
  color: #004b63;
  font-size: 1.05rem;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

table thead tr {
    background-color: #006a8e;
    color: white;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

/* Responsive */
@media (max-width: 768px) {
  body {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    flex-direction: row;
    justify-content: space-around;
    padding: 1rem;
  }

  .sidebar h3 {
    display: none;
  }

  .sidebar a {
    margin: 0;
    padding: 0.5rem 1rem;
    font-size: 0.95rem;
  }

  .content {
    padding: 2rem 1.5rem;
  }
}
</style>
</head>
<body>

<div class="sidebar">
    <a id="hom" href="index.php"><h1>Tourist</h1></a>
  <a href="change_password.php">Change Password</a>
  <a href="logout.php">Logout</a>
</div>

<div class="content">
    <h3>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h3>
  <h2>Your Profile</h2>
  <div class="profile-field">
    <label>Name:</label>
    <div class="username-display"><?php echo htmlspecialchars($user['username']); ?></div>
  </div>
  <div class="profile-field">
    <label>Address:</label>
    <div><?php echo htmlspecialchars($user['address']); ?></div>
  </div>
  <div class="profile-field">
    <label>Contact:</label>
    <div><?php echo htmlspecialchars($user['contact']); ?></div>
  </div>

  <h2>Purchase History</h2>

  <?php if ($history_result->num_rows > 0): ?>
  <table>
      <thead>
          <tr>
              <th>Package Name</th>
              <th>Price</th>
              <th>Location</th>
              <th>Description</th>
              <th>Booking Date</th>
          </tr>
      </thead>
      <tbody>
          <?php while ($row = $history_result->fetch_assoc()): ?>
          <tr>
              <td><?php echo htmlspecialchars($row['package_name']); ?></td>
              <td>$<?php echo number_format($row['price'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['location']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td><?php echo htmlspecialchars(date("F j, Y", strtotime($row['booking_date']))); ?></td>
          </tr>
          <?php endwhile; ?>
      </tbody>
  </table>
  <?php else: ?>
  <p>You have not purchased any packages yet.</p>
  <?php endif; ?>

</div>

</body>
</html>
