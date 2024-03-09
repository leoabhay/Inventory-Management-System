<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user']['id'];
$sql = "SELECT orders.id AS order_id, stock.product, orders.quantity, stock.price_per_piece, orders.total_price
        FROM orders
        INNER JOIN stock ON orders.product_id = stock.id
        WHERE orders.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My orders</title>
    <link rel="stylesheet" href="tabledesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="table">
        <div class="table_header">
            <p><h2>My Orders</h2></p>
        </div>
        <div class="table_section">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price per piece</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total = $row['quantity'] * $row['price_per_piece'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                            <td><?php echo $total; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
