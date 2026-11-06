<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Smart Donation</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <section class="register-section">
        <div class="register-container">

            <a href="../index.php" class="logo">
                Smart<span>Donation</span>
            </a>

            <h1>Welcome Back!</h1>

            <p>Login to continue your journey of kindness.</p>

            <form action="login_process.php" method="POST">

                <label>Email Address</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required>

                <button type="submit" class="btn btn-primary">
                    Login
                </button>

            </form>

            <p class="login-text">
                Don't have an account?
                <a href="register.php">Create Account</a>
            </p>

        </div>
    </section>

</body>

</html>