<?php
require 'user.php'; // MARK VINCE


$dbConfig = new DBConfig();
$connection = $dbConfig->getConnection();


$product = new Product($connection);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $productInserted = $product->insertProduct($product_name, $price, $stock_quantity);

    if ($productInserted) {
        echo "";
    } else {
        echo "Product insertion failed.";
    }
}

$products = $product->getAllProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    <?php
    if (count($products) > 0) {
        echo "<table border=1>";
        echo "<tr><th>Product Name</th><th>Price</th><th>Stock Quantity</th></tr>";

        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['Product_Name'] . "</td>";
            echo "<td>" . $product['Price'] . "</td>";
            echo "<td>" . $product['Stock_Quantity'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No products available.";
    }
    ?>
    <body>
    <div class="form-container">
    <h2>Insert New Product</h2>
    <form method="post">
                    <label>PRODUCT NAME</label>
					<input type="text" name="product_name" required>

                    <label>PRICE</label>
					<input type="number" name="price" required>

                    <label>STOCK QUANTITY</label>
					<input type="number"  name="stock_quantity">

                    <div class="form-btn">    
                    <button type="submit" value="Insert Product">SUBMIT</button>
    </form>
    <style>
    <style>
    body {
    font-family: Verdana, sans-serif;
    min-height: 200vh;
    background: #eee;
    display: flex;
    justify-content: center;
    align-items: center;
}
    .form-container form {
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 300px;
    background: white;
    padding: 4rem;
    border-radius: 10px;
    position: relative;
    margin-left: 16%; 
}
h2{
    color: darkgreen;
        text-align: center;
        font-family: Verdana, sans-serif;
        padding-left: 100px;
}
    .form-container h2{
        color: darkgreen;
        text-align: center;
        font-family: Verdana, sans-serif;
        padding-left: 100px;
}
    .form-container label{
        font-family: Verdana, sans-serif;
        font-size: 12px;
        margin: 10px;
        letter-spacing: 1px;
        margin-left: 2px;
    }
    .form-container input, select{
        border: none;
        background: #eee;
        height: 30px;
        font-family: Verdana, sans-serif;
    }
    .form-container input:hover,  select:hover{
        background-color:forestgreen;
        cursor: pointer;
        color: white;
    }
    
    .form-btn button{
        width: 100%;
        height: 30px;
        background: darkgreen;
        color: white;
        border: none;
        border-radius: 10px;
        font-family: Verdana, sans-serif;
        margin-top: 10px;
    }
    .form-btn button:hover{
        background-color: white;
        color:black;
        cursor: pointer;
        border: 1px solid darkgreen;
    }
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
