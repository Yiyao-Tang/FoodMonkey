<?php   
session_start();
 if(!isset($_SESSION["sess_user"])){  
     header("location:login-main.php");  
 } else{
    include "dbconnect.php";
    if (isset($_GET['productfilter'])) {
        $_SESSION['productfilter'] = $_GET['productfilter'];
        };
    if (!isset($_SESSION['cart_item'])){
        $_SESSION['cart_item'] = array();
        }; 
    if (count($_POST)!=0) {
        foreach($_POST as $k => $v) {
            $_SESSION["cart_item"][$k]["Quantity"] = $v;
        };
        };
    if(isset($_GET["action"])) {
        switch($_GET["action"]) {
            case "add":
                if(!empty($_POST["Quantity"])) {
                    $productBySKU = $dbcnx->query("SELECT * FROM products WHERE ProductSKU='" . $_GET["ProductSKU"] . "'");
                    $productBySKU_row = $productBySKU->fetch_assoc();
                    $itemArray = array($productBySKU_row["ProductSKU"]=>array('ProductName'=>$productBySKU_row["ProductName"], 'ProductSKU'=>$productBySKU_row["ProductSKU"], 'Quantity'=>$_POST["Quantity"]));
                    if(!empty($_SESSION["cart_item"])) {
                        if(in_array($productBySKU_row["ProductSKU"],array_keys($_SESSION["cart_item"]))) {
                            foreach($_SESSION["cart_item"] as $k => $v) {
                                    if($productBySKU_row["ProductSKU"] == $k) {
                                        if(empty($_SESSION["cart_item"][$k]["Quantity"])) {
                                            $_SESSION["cart_item"][$k]["Quantity"] = 0;
                                        }
                                        $_SESSION["cart_item"][$k]["Quantity"] += $_POST["Quantity"];
                                    }
                            }
                        } else {
                           $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
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
        <title>Cart</title>
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
                <div class="content">
                    <h2>Viewing
                    <?=$_SESSION['sess_user'];?>'s Cart</h2>
                    <h2><small><a href="logout.php">Logout</a><small></h2>
                    <div class="my-cart">
                        <?php
                        if (count($_SESSION["cart_item"])==0) {
                            echo "<h2> Your cart is empty. <a href='restaurant.php'>Shop something!</a></h2>";
                        }
                        else {
                        ?>
                        <form action="" method="post">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Item Price</th>
                                    
                                    <th>Purchase Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($_SESSION["cart_item"] as $item=>$value){
                                    $food_id = $item;
                                    $quantity = $value["Quantity"];
                                    $sql = "SELECT *
                                    FROM food_item
                                    WHERE id='$food_id'";
                                    $result = $dbcnx->query($sql);
                                    if (!$result){
                                        echo "query_failed";
                                    }
                                    else{
                                        $row = $result->fetch_assoc();
                                        $subtotal = $quantity*$row['price'];
                                        echo "<tr>";
                                        echo "<td>" . '<img src="./img/food/'.($row['image']).'" style="width:10vw; height: 200px; object-fit: cover; max-width: 100%;"/>' . "</td>";
                                        echo "<td><a href='foodItem.php?food_id=" .$row['id']. "'>" .$row['name']. "</a></td>";
                                        echo "<td>$";
                                        echo $row['price']. "</td>";
                                        echo "<td><input type='number' min='1' step='1' value=".$quantity." name=" .$row['id']. "></td>";
                                        echo "<td>$";
                                        echo $subtotal. "</td>";
                                        echo "<td><a href='" .$_SERVER['PHP_SELF']. '?action=remove&food_id=' .$row['id']. "'>Remove</a></td>";
                                        echo "</tr>";
                                        $total = $total + $subtotal;
                                    };
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th align='right'></th><br>
                                    <th align='right'></th><br>
                                    <th align='right'></th><br>
                                    <th align='right'></th><br>
                                    <th align='right'>Total:</th><br>
                                    <th align='right'>$<?php $total ?></th><br>
                                    
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mycart-right">
                            <br>
                            <input type='submit' value='Update'>
                            
                        </div>
                        </form>
                        
        
                        <div class="mycart-right">
                        <form action="checkout.php" method="post">
                                <input type="submit" name="checkout" id="checkout" value="Checkout">
                            </form>
                            
                            <p><a href="restaurant.php">Continue Shopping</a> or
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=empty">Empty your cart</a></p>
                        </div>
                        <?php };?>
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