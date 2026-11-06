<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Smart Donation</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <section class="register-section">
        <div class="register-container">

            <a href="../index.php" class="logo">
                Smart<span>Donation</span>
            </a>

            <h1>Create Your Account</h1>

            <p>Join us and become a part of positive change.</p>

            <form action="register_process.php" method="POST">

                <label>Full Name</label>
                <input
                    type="text"
                    name="full_name"
                    placeholder="Enter your full name"
                    required>

                <label>Email Address</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

                <label>Phone Number</label>
                <input
                    type="tel"
                    name="phone"
                    placeholder="Enter your phone number">

                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    required>

                <label>Register As</label>
                <select name="role" required>
                    <option value="">Select your role</option>
                    <option value="donor">Donor</option>
                    <option value="recipient">Recipient</option>
                </select>

                <button type="submit" class="btn btn-primary">
                    Create Account
                </button>

            </form>

            <p class="login-text">
                Already have an account?
                <a href="login.php">Login</a>
            </p>

        </div>
    </section>

</body>

</html>