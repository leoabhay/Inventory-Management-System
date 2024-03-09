<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habibi Inventory</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <header><h1>Menu Bar</h1></header>
        <ul>
            <li><a href="client_place_order.php"> Place Order</a></li>
            <li><a href="client_myorder.php"> My orders</a></li>
            <li><a href="contacts.php"> Contacts</a></li>
            <li><a href="client_history.php"> Purchase History</a></li>
            <li><a href="logout.php"> Logout</a></li>
        </ul>
    </div>
    <section></section>
</body>
</html>