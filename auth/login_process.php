
<?php

session_start();

require_once "../config/database.php";

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Get login information
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Check empty fields
if ($email === "" || $password === "") {
    exit("Please enter email and password.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid email address.");
}

// Find user in database
$stmt = $conn->prepare(
    "SELECT id, full_name, email, password, role, verification_status
     FROM users
     WHERE email = ?"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user["password"])) {

        // Regenerate session ID after login
        session_regenerate_id(true);

        // Save user information in session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["verification_status"] = $user["verification_status"];

        // Redirect according to user role
        if ($user["role"] === "donor") {
            header("Location: ../donor/dashboard.php");
            exit;
        }

        if ($user["role"] === "recipient") {

            if ($user["verification_status"] !== "verified") {
                header("Location: ../recipient/verification_status.php");
                exit;
            }

            header("Location: ../recipient/dashboard.php");
            exit;
        }

        if ($user["role"] === "admin") {
            header("Location: ../admin/dashboard.php");
            exit;
        }
    } else {
        exit("Incorrect email or password.");
    }
} else {
    exit("Incorrect email or password.");
}

$stmt->close();
$conn->close();

?>
