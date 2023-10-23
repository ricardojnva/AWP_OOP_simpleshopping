<?php //MARK VINCE
require 'user.php'; 

session_start();

$user_id = 1; 

$dbConfig = new DBConfig();
$connection = $dbConfig->getConnection();
$cart = new Cart($connection); 

$checkout_message = '';
$totalCost = 0; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clear_cart'])) {
        
        if ($cart->clearCart($user_id)) {
            echo "Your cart has been cleared.";
        } else {
            echo "Failed to clear the cart.";
        }
    } elseif (isset($_POST['checkout'])) {
      
        $connection->begin_transaction();

        try {
             $cartItems = $cart->viewCart($user_id);

            foreach ($cartItems as $item) {
                $totalCost += $item['Total_Price'];
            }

            
            $deliveryFee = 50;
            $totalCost += $deliveryFee;

            $insertOrderQuery = "INSERT INTO Orders (User_ID, Total_Fee, Order_Date) VALUES (?, ?, NOW())";

            $stmt = $connection->prepare($insertOrderQuery);
            $stmt->bind_param("id", $user_id, $totalCost);
            $stmt->execute();

           
            $connection->commit();

            $checkout_message = "Order has been successfully placed.";
        } catch (Exception $e) {
            $connection->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
    }
}

$cartItems = $cart->viewCart($user_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h2>Checkout</h2>
    <?php
    if (count($cartItems) > 0) {
        $totalCost = 0; 
        $orderDate = date('Y-m-d H:i:s'); 

        echo "<form method='post' action='checkout.php'>";
        echo "<input type='hidden' name='user_id' value='" . $user_id . "'>";
        foreach ($cartItems as $item) {
            echo "<input type='hidden' name='cart_items[]' value='" . json_encode($item) . "'>";
        }
        echo "<table border='1'>";
        echo "<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Price</th></tr>";
        foreach ($cartItems as $item) {
            echo "<tr>";
            echo "<td>" . $item['Product_Name'] . "</td>";
            echo "<td>" . $item['Price'] . "</td>";
            echo "<td>" . $item['Quantity'] . "</td>";
            echo "<td>" . $item['Total_Price'] . "</td>";
            $totalCost += $item['Total_Price'];
            echo "</tr>";
        }

        $deliveryFee = 50;
        $totalCost += $deliveryFee; 

        echo "<tr>";
        echo "<td colspan='3'>Delivery Fee:</td>";
        echo "<td>50</td>"; 
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='3'>Total Cost (Including delivery fee):</td>";
        echo "<td>" . $totalCost . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='3'>Order Date:</td>";
        echo "<td>" . $orderDate . "</td>";
        echo "</tr>";
        echo "</table>";

        if (empty($checkout_message)) {
            echo "<input type='submit' name='clear_cart' value='Clear Cart'>";
            echo "<input type='submit' name='checkout' value='Checkout'>";
        } else {
            echo "<p>$checkout_message</p>";
        }
    } else {
        echo "Your cart is empty.";
        echo "<a href='add_cart.php'>Add items to the cart</a>";
    }
  
    ?>
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
