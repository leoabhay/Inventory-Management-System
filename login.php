<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$username', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Signup Success!");</script>';
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['passwd'];

        $sql = "SELECT id, user_password FROM users WHERE user_email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['user_password'];

            if (password_verify($password, $hashedPassword)) {
                echo '<script>alert("Login Success!");</script>';

                $_SESSION['user'] = $row;

                 header("Location: client.php");
                 
            exit();
            } else {
                echo '<script>alert("Incorrect email or password.")</script>';
            }
        } else {
            echo '<script>alert("User not found.")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Habibi IMS</title>
    <style>
        .admin-login-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .admin-login-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <a href="admin_login.php" class="admin-login-button">Admin Login</a>

    <div class="main">
        <input type="checkbox" id="check" aria-hidden="true">
        <div class="signup">
            <form method="POST" action="login.php">
                <label for="check" aria-hidden="true">Sign Up</label>
                <input type="text" name="username" placeholder="User Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>

        <div class="login">
            <form method="POST" action="login.php">
                <label for="check" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="passwd" placeholder="8-16 characters" required />
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

