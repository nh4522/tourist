<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "tourist";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create / Update / Delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_name = $_POST['package_name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';
    $id = $_POST['id'] ?? '';

    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO packages (package_name, price, location, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $package_name, $price, $location, $description);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE packages SET package_name=?, price=?, location=?, description=? WHERE package_id=?");
        $stmt->bind_param("sdssi", $package_name, $price, $location, $description, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM packages WHERE package_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all packages
$packages_result = $conn->query("SELECT * FROM packages ORDER BY package_id ASC");

// Fetch purchase history from booking table with package names and durations
$purchase_history = [];
$sql = "SELECT b.booking_id, b.full_name, b.address, b.contact, b.no_of_people, b.amount, 
        b.payment_method, b.booking_date, b.start_date, b.end_date, b.duration, p.package_name 
        FROM booking b 
        LEFT JOIN packages p ON b.package_id = p.package_id 
        ORDER BY b.booking_date DESC";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $purchase_history[] = $row;
    }
}

// Edit package if ID is provided
$edit_package = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM packages WHERE package_id=$edit_id");
    if ($res->num_rows > 0) {
        $edit_package = $res->fetch_assoc();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Panel - Tourism Packages</title>
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
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
        vertical-align: top;
    }
    th {
        background: #0a9396;
        color: #fff;
    }
    tr:hover {
        background: #e0f2f1;
    }
    form {
        background: #fff;
        padding: 15px;
        border: 1px solid #ccc;
        max-width: 600px;
        box-shadow: 0 0 5px #ccc;
    }
    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #bbb;
        border-radius: 4px;
        box-sizing: border-box;
    }
    textarea {
        resize: vertical;
        min-height: 60px;
    }
    button {
        margin-top: 15px;
        padding: 10px 20px;
        background: #005f73;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button.delete {
        background: #ae2012;
        margin-left: 10px;
    }
    button:hover {
        opacity: 0.9;
    }
    .section {
        margin-bottom: 40px;
    }
    .flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .flex h2 {
        margin: 0;
    }
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        padding: 10px 20px;
        border-bottom: 1px solid #ccc;
        margin-bottom: 30px;
    }
    .nav__logo a {
        font-size: 1.8rem;
        font-weight: 600;
        color: #005f73;
        font-family: "Playfair Display", serif;
        text-decoration: none;
    }
    .nav__links {
        list-style: none;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .nav__links .link a {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        text-decoration: none;
    }
    .nav__links .link a:hover {
        color: #005f73;
    }
    .logout-btn {
        background: #ae2012;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
    }
    .logout-btn:hover {
        opacity: 0.9;
    }
</style>
</head>
<body>

<nav>
    <div class="nav__logo"><a href="index.php">Mr. Tourist</a></div>
    <div class="nav__links">
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<h1>Admin Panel - Tourism Packages</h1>

<div class="section">
    <h2>Tourism Package Purchase History</h2>
    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Package Name</th>
                <th>Duration (days)</th>
                <th>No. of People</th>
                <th>Amount ($)</th>
                <th>Payment Method</th>
                <th>Booking Date</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($purchase_history) === 0): ?>
                <tr><td colspan="11" style="text-align:center;">No purchases found.</td></tr>
            <?php else: ?>
                <?php foreach ($purchase_history as $purchase): ?>
                <tr>
                    <td><?= htmlspecialchars($purchase['full_name']) ?></td>
                    <td><?= htmlspecialchars($purchase['address']) ?></td>
                    <td><?= htmlspecialchars($purchase['contact']) ?></td>
                    <td><?= htmlspecialchars($purchase['package_name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($purchase['duration'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($purchase['no_of_people']) ?></td>
                    <td><?= number_format($purchase['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($purchase['payment_method']) ?></td>
                    <td><?= htmlspecialchars($purchase['booking_date']) ?></td>
                    <td><?= htmlspecialchars($purchase['start_date']) ?></td>
                    <td><?= htmlspecialchars($purchase['end_date']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="section">
    <div class="flex">
        <h2><?= $edit_package ? "Edit Package" : "Add New Package" ?></h2>
        <?php if($edit_package): ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" style="text-decoration:none; color:#005f73; font-weight:bold;">Cancel Edit</a>
        <?php endif; ?>
    </div>
    
    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="hidden" name="id" value="<?= $edit_package ? $edit_package['package_id'] : '' ?>" />
        
        <label for="package_name">Package Name</label>
        <input type="text" id="package_name" name="package_name" required value="<?= $edit_package ? htmlspecialchars($edit_package['package_name']) : '' ?>" />
        
        <label for="price">Price ($)</label>
        <input type="number" step="0.01" min="0" id="price" name="price" required value="<?= $edit_package ? $edit_package['price'] : '' ?>" />
        
        <label for="location">Location</label>
        <input type="text" id="location" name="location" required value="<?= $edit_package ? htmlspecialchars($edit_package['location']) : '' ?>" />
        
        <label for="description">Description</label>
        <textarea id="description" name="description" required><?= $edit_package ? htmlspecialchars($edit_package['description']) : '' ?></textarea>
        
        <?php if ($edit_package): ?>
            <button type="submit" name="update">Update Package</button>
            <button type="submit" name="delete" class="delete" onclick="return confirm('Are you sure you want to delete this package?')">Delete Package</button>
        <?php else: ?>
            <button type="submit" name="create">Add Package</button>
        <?php endif; ?>
    </form>
</div>

<div class="section">
    <h2>All Tourism Packages</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
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
                <td><?= $package['package_id'] ?></td>
                <td><?= htmlspecialchars($package['package_name']) ?></td>
                <td><?= number_format($package['price'], 2) ?></td>
                <td><?= htmlspecialchars($package['location']) ?></td>
                <td><?= htmlspecialchars($package['description']) ?></td>
                <td><a href="?edit=<?= $package['package_id'] ?>">Edit</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
