<?php   
session_start();
include "dbconnect.php";
if (isset($_GET['rest_id'])) {
    $_SESSION['rest_id'] = $_GET['rest_id'];
    };
if (!isset($_SESSION['cart_item'])){
    $_SESSION['cart_item'] = array();
    };
if(isset($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["Quantity"])) {
                
                $foodItem = $dbcnx->query("SELECT * FROM food_item WHERE id='" . $_GET["food_id"] . "'");
                $foodItemRow = $foodItem->fetch_assoc();
                
                $itemArray = array($_GET["food_id"]=>array('name'=>$foodItemRow["name"], 'id'=>$foodItemRow["id"], 'Quantity'=>$_POST["Quantity"]));
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($foodItemRow["id"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($foodItemRow["id"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["Quantity"])) {
                                        $_SESSION["cart_item"][$k]["Quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["Quantity"] += $_POST["Quantity"];
                                }
                        }
                    } else {
                        //$_SESSION["cart_item"] = $itemArray;
                        $_SESSION["cart_item"] = $_SESSION["cart_item"]+$itemArray;
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
        break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["food_id"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
        case "empty":
            unset($_SESSION["cart_item"]);
        break;	
    }
    header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Food Items</title>
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
                    <h4>Choose Restaurant by Category</h4>
                    <ul>
                    <li><a href="restaurant.php?restfilter=All">All Restaurant</a></li>
                        <li><a href="restaurant.php?restfilter=Chinese">Chinese</a></li>
                        <li><a href="restaurant.php?restfilter=Western">Western</a></li>
                        <li><a href="restaurant.php?restfilter=Malay">Malay</a></li>
                        <li><a href="restaurant.php?restfilter=Indian">Indian</a></li>
                        <li><a href="restaurant.php?restfilter=JK">Japanese/Korean</a></li>
                    </ul>
                    </div>
                </div>
                <div class="product-rightcol">
                    <div class="content">
                   <?php
                                $rest_id = $_SESSION['rest_id'];
                                //echo "$rest_id";
                                $sql = "SELECT *
                                FROM food_item
                                WHERE rest_id = $rest_id";
                            

                            $result = $dbcnx->query($sql);
                            if (!$result){
                                echo "<h2>Unable to find product(s).</h2>";
                            }
                            else{
                               //$row = $result->fetch_assoc();
                        ?> 
                        <h2>Showing result(s) for
                        <?php
                            $rest_id = $_SESSION['rest_id'];
                            $sql = "SELECT *
                            FROM restaurant
                            WHERE id = $rest_id";
                            $resresult = $dbcnx->query($sql);
                            $resrow = $resresult->fetch_assoc();
                            echo $resrow["rest_name"];
                        ?>
                        </h2>
                            <table class="product-table">
                            <tr>            
                            </tr>
                            <?php 
                            $counter = 0;
                            echo '<tr>';
                            while($row = $result->fetch_assoc()){
                                if($counter==2){
                                    //echo '<tr>';
                                }
                                
                                ?>

                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=add&food_id=<?php echo $row["id"]; ?>">
                                <?php //echo "<tr><td>" . $row['id'] . "</td><td>" . '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" style="width:15vw; height: 200px; object-fit: cover; max-width: 100%;"/>' . "</td><td>" . $row['price'] . "</td><td><input type='number' min='1' name='Quantity' value='1' size='2' /><input type='submit' value='Add to Cart'/></td></tr>";
                                    echo '<td><p>'.'<img src="./img/food/'.($row['image']).'" style="width:15vw; height: 200px; object-fit: cover; max-width: 100%;"/></p><p>' .$row['name']. '</p><p>$' .$row['price']. '</p><p><input type="number" min="1" name="Quantity" value="1" size="2" /><input type="submit" value="Add to Cart"/></p></td>';
                                ?>
                                </form>
                                
                            <?php 
                             if($counter==2){
                                echo '</tr>';
                                echo '<tr>';
                                $counter = 0;
                            }       
                            $counter++;      
                             }?>
                            
                                
                            
                            </table>
                        <?php
                        echo '</tr>';};
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