<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "donor") {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donation | Smart Donation</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <section class="register-section">
        <div class="register-container">
            <h1>Add a Donation</h1>
            <p>Share an item with someone who needs it.</p>

            <form action="donation_process.php" method="POST"
                enctype="multipart/form-data">

                <label>Item Name</label>
                <input type="text" name="item_name"
                    placeholder="e.g. Winter Jacket" required>

                <label>Category</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="Clothes">Clothes</option>
                    <option value="Shoes">Shoes</option>
                    <option value="Books">Books</option>
                    <option value="Bags">Bags</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Household Items">Household Items</option>
                </select>

                <label>Description</label>
                <textarea name="description"
                    placeholder="Describe your donated item..."
                    required></textarea>

                <label>Item Condition</label>
                <select name="item_condition" required>
                    <option value="">Select Condition</option>
                    <option value="new">New</option>
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                </select>

                <label>City</label>
                <input type="text" name="city"
                    placeholder="Enter your city" required>

                <label>Address</label>
                <textarea name="address"
                    placeholder="Enter pickup address"></textarea>

                <label>Upload Item Image</label>
                <input type="file" name="item_image"
                    accept="image/jpeg,image/png,image/webp">

                <button type="submit" class="btn btn-primary">
                    Submit Donation
                </button>

            </form>
        </div>
    </section>

</body>

</html>