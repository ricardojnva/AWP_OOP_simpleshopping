<?php //JANEVA
require 'user.php';

$dbConfig = new DBConfig();
$connection = $dbConfig->getConnection();
$product = new Product($connection);
$cart = new Cart($connection);


$user_id = 1; 
$totalQuantity = 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1; 

    
    if ($cart->addItemToCart($user_id, $product_id, $quantity)) {
        echo "Product added to cart successfully.";
        $totalQuantity += $quantity;
    } else {
        echo "Failed to add the product to the cart.";
    }
}

$products = $product->getAllProducts();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>
    <h2>Product List</h2>   
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr>
            <td><?php echo $product['Product_Name']; ?></td>
            <td><?php echo $product['Price']; ?></td>
            <td><?php echo $product['Stock_Quantity']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                    <input type="submit" name="add_to_cart" value="Add to Cart">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="checkout.php">View Shopping Cart</a>
    <style>    
    td{
        padding:10px;
        background-color: green;
        border: none;
        color:white;
    }
    tr{
        display: over;
    }
    </style>
</body>
</html>
