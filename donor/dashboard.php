<?php
session_start();

// Check whether user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

// Only donors can access this page
if ($_SESSION["role"] !== "donor") {
    exit("Access Denied! This page is only for donors.");
}

$full_name = htmlspecialchars($_SESSION["full_name"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard | Smart Donation</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header class="navbar">
        <a href="../index.php" class="logo">
            Smart<span>Donation</span>
        </a>

        <div class="nav-buttons">
            <span>Welcome, <?php echo $full_name; ?></span>
            <a href="../auth/logout.php" class="btn btn-outline">
                Logout
            </a>
        </div>
    </header>

    <main class="dashboard-container">

        <section class="dashboard-heading">
            <p class="section-tag">DONOR PANEL</p>

            <h1>Welcome Back, <?php echo $full_name; ?>!</h1>

            <p>
                Your kindness can make someone's life better.
                Manage your donations from here.
            </p>
        </section>

        <section class="dashboard-grid">

            <div class="dashboard-card">
                <h3>Donate an Item</h3>
                <p>Share clothes, shoes, books and other useful items.</p>
                <a href="#" class="btn btn-primary">Add Donation</a>
            </div>

            <div class="dashboard-card">
                <h3>My Donations</h3>
                <p>View and manage the items you have donated.</p>
                <a href="#" class="btn btn-primary">View Donations</a>
            </div>

            <div class="dashboard-card">
                <h3>Donation Requests</h3>
                <p>Explore needs submitted by verified recipients.</p>
                <a href="#" class="btn btn-primary">View Requests</a>
            </div>

            <div class="dashboard-card">
                <h3>Donate Money</h3>
                <p>Support people in need through financial donations.</p>
                <a href="#" class="btn btn-primary">Donate Money</a>
            </div>

        </section>

    </main>

</body>

</html>