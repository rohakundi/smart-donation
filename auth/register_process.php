
<?php

// Database connection
require_once "../config/database.php";

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Receive form data
$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";

// Check required fields
if ($full_name === "" || $email === "" || $password === "" || $role === "") {
    exit("Please fill in all required fields.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
}

// Password must contain at least 8 characters
if (strlen($password) < 8) {
    exit("Password must be at least 8 characters long.");
}

// Only allow donor or recipient
if (!in_array($role, ["donor", "recipient"], true)) {
    exit("Invalid account role.");
}

// Check whether email already exists
$check = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    exit("This email is already registered.");
}

$check->close();

// Securely hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Set verification status
$verification_status = ($role === "recipient")
    ? "pending"
    : "not_required";

// Insert user into database
$stmt = $conn->prepare(
    "INSERT INTO users
    (full_name, email, phone, password, role, verification_status)
    VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssssss",
    $full_name,
    $email,
    $phone,
    $hashed_password,
    $role,
    $verification_status
);

if ($stmt->execute()) {
    echo "Registration Successful! Your account has been created.";
    echo '<br><a href="login.php">Go to Login</a>';
} else {
    echo "Registration failed. Please try again.";
}

$stmt->close();
$conn->close();

?>
