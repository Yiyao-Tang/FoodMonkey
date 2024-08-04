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
        <title>Restaurant</title>
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

            <div>
                <div class="product-leftcol">
                    <div class="product-filternav">
                    <h4>Filter Product By</h4>
                    <ul>
                        <li><a href="restaurant.php?restfilter=All">All Restaurant</a></li>
                        <li><a href="restaurant.php?restfilter=Chinese">Chinese</a></li>
                        <li><a href="restaurant.php?restfilter=Western">Western</a></li>
                        <!-- <li><a href="restaurant.php?restfilter=Malay">Malay</a></li> -->
                        <li><a href="restaurant.php?restfilter=Indian">Indian</a></li>
                        <li><a href="restaurant.php?restfilter=JK">Japanese/Korean</a></li>
                        <!-- <li><a href="products.php?productfilter=T-Shirt">T-Shirt</a></li>
                        <li><a href="products.php?productfilter=Other">Other</a></li> -->
                    </ul>
                    </div>
                </div>
                <div class="product-rightcol">
                    <div class="content">
                    <?php
                            if ($_SESSION['restfilter']=="All") {
                                $sql = "SELECT *
                                FROM restaurant";
                            }
                            elseif ($_SESSION['restfilter']=="Chinese") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE category= 'Chinese' ";
                            }
                            elseif ($_SESSION['restfilter']=="Western") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE category= 'Western' ";
                            }
                            elseif ($_SESSION['restfilter']=="Indian") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE category= 'Indian' ";
                            }
                            elseif ($_SESSION['restfilter']=="Malay") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE category= 'Malay' ";
                            }
                            elseif ($_SESSION['restfilter']=="JK") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE category= 'JK' ";
                            }
                            elseif ($_SESSION['restfilter']=="NS") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE canteen= 'North Spine' ";
                            }
                            elseif ($_SESSION['restfilter']=="SS") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE canteen= 'South Spine' ";
                            }
                            elseif ($_SESSION['restfilter']=="C2") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE canteen= 'Canteen 2' ";
                            }
                            elseif ($_SESSION['restfilter']=="NH") {
                                $sql = "SELECT *
                                FROM restaurant
                                WHERE canteen= 'North Hill' ";
                            }
                            else {
                                $rest_name = $_SESSION['restfilter'];
                                $sql = "SELECT *
                                FROM restuarant
                                WHERE rest_name LIKE '%$rest_name%'";
                            };

                            $result = $dbcnx->query($sql);
                            if (!$result){
                                echo "<h2>Unable to find product(s).</h2>";
                            }
                            else{
                              
                        ?>
                        <h2>Showing result(s) for
                        <?php
                            if ($_SESSION['restfilter']=="All") {
                                
                                echo 'All restaurants';
                            }
                            elseif ($_SESSION['restfilter']=="Chinese") {
                               
                                echo 'Chinese restaurants';
                            }
                            elseif ($_SESSION['restfilter']=="Western") {
                                
                                echo 'Western restaurants';
                            }
                            elseif ($_SESSION['restfilter']=="Indian") {
                               
                                echo 'Indian Restaurants';
                            }
                            
                            elseif ($_SESSION['restfilter']=="JK") {
                              
                                echo 'Japan Korea Restaurant';
                            }
                            else {
                               
                               
                                
                            };
                        ?>
                        </h2>
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
                        ?>
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
            function formSubmit(){
                var subEmail = document.forms["subForm"]["subEmail"].value;
                if (subEmail == "") {
                    alert("Email cannot be empty!"); 
                    return false;
                }
            }
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