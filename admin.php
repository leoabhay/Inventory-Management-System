<?php
session_start();
if (!isset($_SESSION['user_admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habibi IMS</title>
    <link rel="stylesheet" href="admin.css">
    
</head>
<body>
    <div class="sidebar">
        <header><h1>Menu Bar</h1></header>
        <ul>
            <li><a href="admin_clientorder.php"> Orders</a></li>
            <li><a href="admin_addstock.php"> Add/Update stock</a></li>
            <li><a href="admin_history.php">History</a></li>
            <li><a href="logout.php"> Logout</a></li>
        </ul>
    </div>
    <section></section>
</body>
</html>
