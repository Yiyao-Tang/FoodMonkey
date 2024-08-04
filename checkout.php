<?php   
session_start();
$userId= $_SESSION['sess_user_id'];
include "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Checkout</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <div id="wrapper">
        <header>
                <nav>
                    <!-- <a href="index.php" ><img src="./img/monkey.png" width=30px height=30px></a> -->
                    <a href="index.php" id="header-logo">Food Monkey</a>
                    <a href="restaurant.php?restfilter=All">Restaurant</a>
                    <a href="map.php">CanteenMap</a>
                    <a href="history.php">History</a>
                    <a href="profile.php">Profile</a>
                    
                    <div class="search-container">
                        <form method="post" action="searchresults.php" name="searchForm" onsubmit="return formSearch()">
                          <input type="text" placeholder="Search..." name="SearchBar">
                          <button type="submit"><img src="./img/search_button.png" alt="search button" width="15" height="15"></button>
                        </form>
                    </div>
                    <div class="account-info">
                        <a href="my-cart.php"><img src="img/cart.png" width="30" height="30"></a> 
                        <a href="login-main.php"><img src="img/user-icon.png" width="30" height="30"></a>
                    </div>
                </nav>
            </header>
            <div class="content">
                <p>
                <?php
                $checkoutOK = TRUE;
                $enufmoney = TRUE;
                $userId = $_SESSION['sess_user_id'];
                $totalPrice = 0;
                foreach ($_SESSION["cart_item"] as $item=>$value){
                    $foodId = $item;
                    $quantity = $value["Quantity"];
                    $sql = "SELECT * 
                    FROM food_item
                    WHERE id='$foodId'";
                    $result = $dbcnx->query($sql);

                    
                    if (!$result){
                        echo "query_failed";
                    }
                    else{
                        $row = $result->fetch_assoc();
                        $unitPrice = $row['price'];
                        $totalPrice = $totalPrice + $unitPrice*$quantity;
                        $sqluser="SELECT * FROM user WHERE user_id = '$userId'";
                        $resultuser = $dbcnx->query($sqluser);
                        $rowuser = $resultuser->fetch_assoc();
                        $current = $rowuser['wallet'];
                        

                        if ($quantity<$row['stock']) {
                            $newQtyInStock = $row['stock'] - $quantity;
                            $sql_update = "UPDATE food_item
                            SET stock=$newQtyInStock
                            WHERE id='$foodId'";
                            $result_update = $dbcnx->query($sql_update);
                            if (!$result_update) {
                                echo "An error has occurred. Could not checkout.";
                            }
                            else {
                                
                                $orders_update = "INSERT INTO food_order( food_id, user_id, order_quantity) VALUES ('$foodId', '$userId', '$quantity')";
                                $result_orders_update = $dbcnx->query($orders_update);
                                if (!$result_orders_update) {
                                    echo "Could not update orders table.";
                                }
                            };
                        }
                        else {
                            echo "<br>Only " .$row['stock']. " left in stock for <strong>" .$row['id']. "</strong> but you ordered " .$quantity. ".";
                            echo "<br><br>Please <a href='my-cart.php'>go back to cart</a> and review your items.";
                            $checkoutOK = FALSE;
                        };
                    };;
                }
                ?>
                </p>
                <h2>
                    <?php
                    if($current < $totalPrice){
                        $enufmoney = False;
                    }
                    if ($checkoutOK==TRUE) {
                        if($enufmoney==TRUE){
                            $newWallet = $current - $totalPrice;
                            $sqlwallet="UPDATE user SET wallet='$newWallet' WHERE user_id = '$userId'";
                            $resultwallet = $dbcnx->query($sqlwallet);
                            

                            echo "Checkout Done!";
                            echo "<br><br><a href='restaurant.php'>Continue buying</a><br>";
                        }else{
                            echo "Sorry, not enough balance in your wallet. Please top up using your credit card";
                        }
                       
                        
                           unset($_SESSION["cart_item"]);
                    }
                    ?>
                </h2>
            </div>
            <footer>
                <hr>
                <div class="row">
                    <div class="column-5">
                        <h3>FoodMonkey</h3>
                        <p><b><u>Contact Us</u></b></p>
                        <p>Address Line 1</br>
                           Address Line 2</br>
                           postcode</p>
						<p>+65 8888 8888</p>
                    </div>
                    <div class="column-5">
                        <h3>Menu</h3>
                        
                        <p><a href="restaurant.php?restfilter=All">Choose by cuisines</a></p>
                        <p><a href="map.php">Choose by canteens</a></p>
                    </div>
					<div class="column-5">
                        <h3>Activity</h3>
						
						<p><a href="history.php">Order History</a></p>
                        <p><a href="my-cart.php">Current Order</a></p>
                    </div>
                    <div class="column-5">
                        <h3>Cart</h3>
                        <p><a href="my-cart.php">View my cart</a></p>
                        <p><a href="my-cart.php">Checkout now</a></p>
                    </div>
					<div class="column-5">
                        <h3>Account</h3>
						<p><a href="profile.php">My profile</a></p>
						<p><a href="userwallet.php">My wallet</a></p>
                    </div>
                    <div class="column-5">
                        <h3>Folow Us</h3>
                        <p><a href="index.php">Facebook</a></p>
                        <p><a href="index.php">Instagram</a></p>
                        <p><a href="index.php">Twitter</a></p>
                    </div>
					
                </div>
            </footer>
        </div>
        <script>
            
            function formSearch(){
                var search = document.forms["searchForm"]["SearchBar"].value;
                if (search == "") {
                    alert("Search cannot be empty!"); 
                    return false;
                }
            }
        </script>
    </body>
</html>