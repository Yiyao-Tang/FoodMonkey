<?php   
session_start();
include "dbconnect.php";
if (isset($_GET['restfilter'])) {
    $_SESSION['restfilter'] = $_GET['restfilter'];
    };
if (isset($_POST['SearchBar'])) {
    $_SESSION['currentsearch'] = $_POST['SearchBar'];
    };
if ((isset($_POST['SearchBar'])==FALSE and (isset($_SESSION['currentsearch'])==TRUE))) {
    $_POST['SearchBar'] = $_SESSION['currentsearch'];
    };
if (!isset($_SESSION['cart_item'])){
    $_SESSION['cart_item'] = array();
    };
if(isset($_GET["action"])) {
    switch($_GET["action"]) {
        
    }
    header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search</title>
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
                        <a href="my-cart.php"><img src="img/cart-icon-28356.png" width="30" height="30"></a> 
                        <a href="login-main.php"><img src="img/user-icon.png" width="30" height="30"></a>
                    </div>
                </nav>
            </header>

            <div>
                <div class="product-leftcol">
                    <div class="product-filternav">
                    <h4>Filter Product By</h4>
                    <ul>
                    <li><a href="restaurant.php?restfilter=All">All Restaurant</a></li>
                        <li><a href="restaurant.php?restfilter=Chinese">Chinese</a></li>
                        <li><a href="restaurant.php?restfilter=Western">Western</a></li>
                        <li><a href="restaurant.php?restfilter=Indian">Indian</a></li>
                        <li><a href="restaurant.php?restfilter=JK">Japanese/Korean</a></li>
                     
                    </ul>
                    </div>
                </div>
                <div class="product-rightcol">
                    <div class="content">
                    <?php
                        $searchtext = $_POST['SearchBar'];
                        $sql = "SELECT *
                        FROM restaurant
                        WHERE rest_name LIKE '%$searchtext%'";
                        $result = $dbcnx->query($sql);
                        if (!$result){
                            echo "<h2>Database error.</h2>";
                        }
                        else {
                          
                           
                    ?>
                    <h2>Showing result(s) for '
                    <?php
                     
                    ?>
                        </h2>
                        <p>Your shopping cart contains 
                            <?php echo count($_SESSION['cart_item']); ?> 
                            item(s).</p>
                        <p><a href="my-cart.php">View My Cart</a></p>
                        <table class="product-table">
                            <tr>

                                <th colspan="2">Restaurant</th>
                                <th>Canteen</th>
                                
                                <th>Rating</th>    
                            </tr>
                                <?php while($row = $result->fetch_assoc()){?>
                                <form>
                                <?php echo '<tr><td><a href="foodItem.php?rest_id='.$row['id'].'">' . $row['rest_name'] . "</a></td><td>" . '<img src="./img/restaurant/'.($row['rest_image']).'" style="width:15vw; height: 200px; object-fit: cover; max-width: 100%;"/>' . "</td><td>" . $row['canteen'] . "</td><td>" . $row['rating'] . "</td></tr>";?>
                                </form>
                            <?php }?>
                            </table>
                        <?php 
                            };
                      //  }; ?>
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