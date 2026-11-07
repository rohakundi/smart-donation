
<?php
session_start();

require_once "../config/database.php";

// Check donor login
if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "donor"
) {
    header("Location: ../auth/login.php");
    exit;
}

// Accept POST requests only
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Receive form data
$donor_id = (int) $_SESSION["user_id"];
$item_name = trim($_POST["item_name"] ?? "");
$category = trim($_POST["category"] ?? "");
$description = trim($_POST["description"] ?? "");
$item_condition = trim($_POST["item_condition"] ?? "");
$city = trim($_POST["city"] ?? "");
$address = trim($_POST["address"] ?? "");

// Allowed categories
$allowed_categories = [
    "Clothes",
    "Shoes",
    "Books",
    "Bags",
    "Electronics",
    "Household Items"
];

// Allowed conditions
$allowed_conditions = [
    "new",
    "good",
    "fair"
];

// Validate required fields
if (
    $item_name === "" ||
    $description === "" ||
    $city === "" ||
    !in_array($category, $allowed_categories, true) ||
    !in_array($item_condition, $allowed_conditions, true)
) {
    exit("Please enter valid donation information.");
}

// Validate text lengths
if (
    strlen($item_name) > 150 ||
    strlen($city) > 100
) {
    exit("Item name or city is too long.");
}

// Optional image upload
$image_path = null;

if (
    isset($_FILES["item_image"]) &&
    $_FILES["item_image"]["error"] !== UPLOAD_ERR_NO_FILE
) {

    // Check upload errors
    if ($_FILES["item_image"]["error"] !== UPLOAD_ERR_OK) {
        exit("Image upload failed. Check your PHP upload limits.");
    }

    // Maximum image size: 100 MB
    if ($_FILES["item_image"]["size"] > 100 * 1024 * 1024) {
        exit("Image must be smaller than 100 MB.");
    }

    // Allowed image formats
    $allowed_types = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    // Detect actual image type
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $file_info->file(
        $_FILES["item_image"]["tmp_name"]
    );

    if (!isset($allowed_types[$mime_type])) {
        exit("Only JPG, PNG and WEBP images are allowed.");
    }

    // Upload folder
    $upload_dir = "../uploads/";

    if (!is_dir($upload_dir)) {
        exit("Upload folder not found.");
    }

    // Generate unique filename
    $file_name = bin2hex(random_bytes(16))
        . "." . $allowed_types[$mime_type];

    $destination = $upload_dir . $file_name;

    // Save image
    if (
        !move_uploaded_file(
            $_FILES["item_image"]["tmp_name"],
            $destination
        )
    ) {
        exit("Could not save the uploaded image.");
    }

    $image_path = "uploads/" . $file_name;
}

// Save donation in database
$stmt = $conn->prepare(
    "INSERT INTO donations
    (
        donor_id,
        item_name,
        category,
        description,
        item_condition,
        city,
        address,
        image_path
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    exit("Database query preparation failed.");
}

$stmt->bind_param(
    "isssssss",
    $donor_id,
    $item_name,
    $category,
    $description,
    $item_condition,
    $city,
    $address,
    $image_path
);

// Execute query
if ($stmt->execute()) {

    echo "Donation submitted successfully!";
    echo '<br><a href="dashboard.php">Back to Dashboard</a>';
} else {

    // Remove uploaded image if database insert fails
    if (
        $image_path !== null &&
        file_exists("../" . $image_path)
    ) {
        unlink("../" . $image_path);
    }

    echo "Error saving donation. Please try again.";
}

// Close connections
$stmt->close();
$conn->close();

?>
