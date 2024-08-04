<?php   
session_start();  
if(!isset($_SESSION["sess_user"])){  
    header("location:login-main.php");  
} else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>History Orders</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles.css">
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
            <div>
                
            </div>
            <div>
                <div class="content">
                    <h2>History Orders for <?=$_SESSION['sess_user'];?><br><small><a href="logout.php">Logout</a></small></h2>
                    <div class="my-account">
                        <div class="my-account-details">
                            <?php
                            include "dbconnect.php";
                            $userId = $_SESSION["sess_user_id"];
                            $query = "SELECT first_name, last_name, email FROM user WHERE user_id = '$userId'";
                            $result = $dbcnx->query($query);
                            if (!$result){
                                //echo "query_failed";
                            }
                            else{
                                $row = $result->fetch_assoc();
                                // if ($row['isAdmin']==TRUE) {
                                //     echo "<h2>You are admin. View <a href='admin-page.php'>Admin Page.</a></h2>";
                                // };
                                // echo "<p><strong>First Name: </strong>" .$row["first_name"]. "</p>";
                                // echo "<p><strong>Last Name: </strong>" .$row["last_name"]. "</p>";
                                // echo "<p><strong>Email: </strong>" .$row["email"]. "</p>";
                                // echo "<p><strong>Purchase history: </strong></p>";
                            }
                            $history_sql = "SELECT food_order.id,food_item.name, image, order_time, price, order_quantity, (price * order_quantity) AS subtotal FROM food_order LEFT JOIN food_item ON food_order.food_id = food_item.id WHERE food_order.user_id = '$userId'";
                            $result_history = $dbcnx->query($history_sql);
                            if (!$result_history){
                                //echo "query_failed";
                            }
                            else{
                                $row_history = $result_history->fetch_assoc();
                                if (count($row_history)==0) {
                                    echo "<p>No transaction history.</p>";
                                }
                                else {
                            ?>
                            <table class="product-table">
                            <tr>
                                <th>OrderID</th>    
                                <th>Date</th>
                                <th>Name</th>
                                <th>Image</th>
                                
                                <th>Item Price (SGD)</th>
                                <th>Quantity</th>
                                <th>Subtotal (SGD)</th>
                            </tr>
                            <?php
                                    echo "<tr><td>" .$row_history['id']. "</td>";
                                    echo "<td>" .$row_history['order_time']. "</td>";
                                    echo "<td>" .$row_history['name']. "</td>";
                                    echo "<td>" . '<img src="img/food/'.($row_history['image']).'" style="width:10vw; height: 200px; object-fit: cover; max-width: 100%;"/>' . "</td>";
                                   
                                    echo "<td>$" .number_format($row_history['price'], 2). "</td>";
                                    echo "<td>" .$row_history['order_quantity']. "</td>";
                                    echo "<td>$" .number_format($row_history['subtotal'], 2). "</td></tr>";
                                    while($row_history = $result_history->fetch_assoc()) {
                                        echo "<tr><td>" .$row_history['id']. "</td>";
                                        echo "<td>" .$row_history['order_time']. "</td>";
                                        echo "<td>" .$row_history['name']. "</td>";
                                        echo "<td>" . '<img src="img/food/'.($row_history['image']).'" style="width:10vw; height: 200px; object-fit: cover; max-width: 100%;"/>' . "</td>";
                                    
                                        echo "<td>$" .number_format($row_history['price'], 2). "</td>";
                                        echo "<td>" .$row_history['order_quantity']. "</td>";
                                        echo "<td>$" .number_format($row_history['subtotal'], 2). "</td></tr>";
                                        };
                                };
                            };
                            ?>
                            </table>
                        </div>
                    </div>
                </div>
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
<?php
}
?>