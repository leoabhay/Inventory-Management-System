<?php
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "ims_db";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating database: " . mysqli_error($conn);
}

$conn = mysqli_connect($servername, $username, $password, $databaseName);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_password VARCHAR(255) NOT NULL
)";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS stock (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    product VARCHAR(255) NOT NULL,
    quantity int(6) NOT NULL,
    price_per_piece DECIMAL(10, 2) NOT NULL
)";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) NOT NULL,
    product_id INT(6) NOT NULL,
    quantity INT(6) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES stock(id)
)";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating table: " . mysqli_error($conn);
}
?>