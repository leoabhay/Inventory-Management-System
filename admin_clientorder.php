<?php
session_start();
if (!isset($_SESSION['user_admin'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_clientorder.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Orders</title>
    <link rel="stylesheet" href="tabledesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="table">
        <div class="table_header">
            <p><h2>Orders</h2></p>
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
                        <th>Stock status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.id, s.product, o.quantity, s.price_per_piece, o.total_price, o.status 
                            FROM orders o
                            JOIN stock s ON o.product_id = s.id";
                    $result = mysqli_query($conn, $sql);
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td class="status-cell">
                                <?php
                                if ($row['status'] == 'completed') {
                                    echo '<button style="background-color: green; color: white;"><i class="fa-solid fa-check"></i></button>';
                                } else if ($row['status'] == 'pending') {
                                    echo '<button style="background-color: orange; color: white;"><i class="fa-solid fa-exclamation"></i></button>';
                                } else if ($row['status'] == 'cancelled') {
                                    echo '<button style="background-color: red; color: white;"><i class="fa-solid fa-times"></i></button>';
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td>
                                <form method="POST" action="admin_clientorder.php">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="status" onchange="updateStatus(this)">
                                        <option value="completed" <?php echo ($row['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="cancelled" <?php echo ($row['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status" >Update Status</button>
                                </form>
                            </td>
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
