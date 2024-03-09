<?php
session_start();
if (!isset($_SESSION['user_admin'])) {
    header("Location: admin_login.php");
    exit;
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_stock'])) {
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price_per_piece = $_POST['price_per_piece'];

    $sql = "INSERT INTO stock (product, quantity, price_per_piece) VALUES ('$product', $quantity, $price_per_piece)";
    mysqli_query($conn, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchKeyword = $_POST['searchKeyword'];
    $sql = "SELECT * FROM stock WHERE product LIKE '%$searchKeyword%'";
} else {
    $sql = "SELECT * FROM stock";
}
$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_stock'])) {
    $id = $_POST['id'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price_per_piece = $_POST['price_per_piece'];


    $sql = "UPDATE stock SET product='$product', quantity=$quantity, price_per_piece=$price_per_piece WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: admin_addstock.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_stock'])) {
    $id = $_POST['id'];


    $sql = "DELETE FROM stock WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: admin_addstock.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <link rel="stylesheet" href="tabledesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px #ccc;
        }
        .search-form {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="table">
        <div class="table_header">
            <h2>Order placement</h2>
            <form class="search-form" method="POST" action="">
                <input type="text" name="searchKeyword" placeholder="Search by product name"/>
                <button type="submit" name="search">Search</button>
            </form>
            <button class="add_new" onclick="showPopupForm('addStockForm')">+ Add New </button>
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
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price_per_piece']; ?></td>
                            <td><?php echo $total; ?></td>
                            <td>
                                <button onclick="showPopupForm('editStockForm<?php echo $row['id']; ?>')">Edit</button>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_stock">Delete</button>
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

    <div class="popup-form" id="addStockForm">
        <h2>Add New Stock</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="product" placeholder="Product" required/>
            <input type="number" name="quantity" placeholder="Quantity" required/>
            <input type="number" name="price_per_piece" placeholder="Price per piece" required/>
            <button type="submit" name="add_stock">Add Stock</button>
            <button type="button" onclick="hidePopupForm('addStockForm')">Cancel</button>
        </form>
    </div>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM stock");
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="popup-form" id="editStockForm<?php echo $row['id']; ?>">
            <h2>Edit Stock</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="product" value="<?php echo $row['product']; ?>" required/>
                <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" required/>
                <input type="number" name="price_per_piece" value="<?php echo $row['price_per_piece']; ?>" required/>
                <button type="submit" name="edit_stock">Save</button>
                <button type="button" onclick="hidePopupForm('editStockForm<?php echo $row['id']; ?>')">Cancel</button>
            </form>
        </div>
        <?php
    }
    ?>
    
    <script>
        function showPopupForm(formId) {
            document.getElementById(formId).style.display = "block";
        }

        function hidePopupForm(formId) {
            document.getElementById(formId).style.display = "none";
        }
    </script>
</body>
</html>
