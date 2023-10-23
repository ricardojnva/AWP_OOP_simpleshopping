<?php //JANEVA 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_simpleshoppings";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
require 'User.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

   
    $user = new User($connection); 
    $registrationResult = $user->registerUser($username, $password, $email);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
        <div class="form-container">
        <h2> User  Registration Form</h2>
        <form method="post">
                    <label>USERNAME</label>
					<input type="text" name="username" required>

                    <label>PASSWORD</label>
					<input type="password" name="password" required>

                    <label>EMAIL</label>
					<input type="text"  name="email">

                    <div class="form-btn">    
                    <button type="submit" value="Register">SUBMIT</button>
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
    </style>
</body>
</html>
