<?php   
session_start();
include "dbconnect.php";
if (isset($_GET['restfilter'])) {
    $_SESSION['restfilter'] = $_GET['restfilter'];
    };
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Canteen Map</title>
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
                <div class="product-leftcol">
                    <div class="product-filternav">
                    <h4>Filter restaurant By Canteens</h4>
                    <ul>
                        <li><a href="restaurant.php?restfilter=All">All Restaurant</a></li>
                        <li><a href="restaurant.php?restfilter=NS">NorthSpine</a></li>
                        <li><a href="restaurant.php?restfilter=SS">SouthSpine</a></li>
                        <li><a href="restaurant.php?restfilter=NH">NorthHill</a></li>
                        <li><a href="restaurant.php?restfilter=C2">Canteen2</a></li>
                        
                    </ul>
                    </div>
                </div>
                <div style="text-align: center;">
                <!--<<<<<<<<<<<"75,125,141,147"<<<<<<<<<<<<-->
				<p>Click on the canteen on the map to view the restaurant there</p>
				<img src="img/food/map.JPG" style="float:center" width="50%" height="50%" usemap="#ntumap">
				<map name="ntumap">
					<area shape="rect" coords="100,165,180,189" alt="North Spine" href="restaurant.php?restfilter=NS">
					<area shape="rect" coords="158,297,238,321" alt="South spine" href="restaurant.php?restfilter=SS">
					<area shape="rect" coords="326,233,398,258" alt="Canteen 2" href="restaurant.php?restfilter=C2">
					<area shape="rect" coords="469,180,580,204" alt="North Hill Canteen" href="restaurant.php?restfilter=NH">
				</map>
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