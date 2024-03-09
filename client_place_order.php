<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price_per_piece = $_POST['price_per_piece'];

    $total_price = $quantity*$price_per_piece;

    $user_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES ('$user_id', '$product_id', '$quantity', '$total_price')";
    mysqli_query($conn, $sql);

    $sql = "UPDATE stock SET quantity = quantity - $quantity WHERE id = '$product_id'";
    mysqli_query($conn, $sql);

    echo '<script>alert("Order placed successfully!");</script>';
    header("Location: client_place_order.php");
    exit();
}

$searchKeyword = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchKeyword = $_POST['searchKeyword'];
    $sql = "SELECT * FROM stock WHERE product LIKE '%$searchKeyword%'";
} else {
    $sql = "SELECT * FROM stock";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="tabledesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="table">
        <div class="table_header">
            <p><h2>Order placement</h2></p>
            <form class="search-form" method="POST" action="">
                <input type="text" name="searchKeyword" placeholder="Search by product name" value="<?php echo $searchKeyword; ?>"/>
                <button type="submit" name="search">Search</button>
            </form>
        </div>
        <div class="table_section">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price per piece</th>
                        <th>Action</th>
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
                            <td>
                                <form method="POST" action="client_place_order.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="price_per_piece" value="<?php echo $row['price_per_piece']; ?>">
                                </td>
                                <td><?php echo $row['price_per_piece']; ?></td>
                                <td>
                                    <button type="submit" name="place_order">Place Order</button>
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
