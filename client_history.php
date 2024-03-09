<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user']['id'];

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
            <p><h2>Purchase History</h2></p>
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
                    $purchase_history_sql = "SELECT o.id, s.product, o.quantity, s.price_per_piece, o.total_price 
                                            FROM orders o
                                            JOIN stock s ON o.product_id = s.id
                                            WHERE o.user_id = $user_id";

                    $purchase_history_result = mysqli_query($conn, $purchase_history_sql);

                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($purchase_history_result)) {
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
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
