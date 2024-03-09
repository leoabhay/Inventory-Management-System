<?php
session_start();

$allowed_users = array(
    "darshanshahthakuri@gmail.com" => "password123",
    "chetshrestha9876@gmail.com" => "password123",
    "abhaydcry10@gmail.com" => "password123"
);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $user_email = $_POST["user_email"];
    $user_password = $_POST["user_password"];

    if (array_key_exists($user_email, $allowed_users) && $user_password === $allowed_users[$user_email]) {
        $_SESSION["user_admin"] = array(
            "user_email" => $user_email
        );

        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Invalid email address or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="post">
            <input type="email" name="user_email" placeholder="Enter email" required>
            <input type="password" name="user_password" placeholder="Enter password" required>
            <button type="submit" name="login">Login</button>
            <?php if (isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
