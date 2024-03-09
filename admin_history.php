<?php
session_start();
if (!isset($_SESSION['user_admin'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db.php';

$stock_history_sql = "SELECT * FROM stock";
$stock_history_result = mysqli_query($conn, $stock_history_sql);

$sales_history_sql = "SELECT o.id, s.product, o.quantity, s.price_per_piece, o.total_price, o.order_date, o.status 
                      FROM orders o
                      JOIN stock s ON o.product_id = s.id";
$sales_history_result = mysqli_query($conn, $sales_history_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="tabledesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="table">
        <div class="table_header">
            <p><h2>Stock History</h2></p>
        </div>
        <div class="table_section">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price per piece</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($stock_history_result)) {
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

    <br>

        <div class="table_header">
            <p><h2>Sales History</h2></p>
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
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($sales_history_result)) {
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
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
