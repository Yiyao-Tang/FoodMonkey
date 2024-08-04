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
        <title>Profile</title>
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

            <div class="product-leftcol">
		
				<h4>My Account</h4>
					<ul>
						<li><a href="profile.php">Profile</a></li>
						<li><a href="userwallet.php">E-Wallet</a></li>
						
					</ul>
			</div>
            <?php
                                    $userId = $_SESSION['sess_user_id'];
                                    $sql = "SELECT *
                                    FROM user
                                    WHERE user_id='$userId'";
                                    $result = $dbcnx->query($sql);
                                    if (!$result){
                                        echo "query_failed";
                                    }
                                    else{
                                        $row = $result->fetch_assoc();
                                        
                                    };
                                
                                ?>
			
            <div>
                
            </div>
            <div>
                <div class="content">
                    <div class="login-form">
                        <form action="update.php" method="POST" name="registerForm" onsubmit="return formCheck()">
                            <div class="login-form-box">
                                <div class="login-form-input">
                                    <label for="firstName">Username:</label>
                                    <?php echo '<input type="text" id="userName" name="username" value='.$row['user_name'].'>'; ?>
                                </div>
                                <div class="login-form-input">
                                    <label for="firstName">First Name:</label>
                                    <?php echo '<input type="text" id="firstName" name="firstName" value='.$row['first_name'].'>'; ?>
                                </div>
                                <div class="login-form-input">
                                    <label for="firstName">Last Name:</label>
                                    <?php echo '<input type="text" id="lastName" name="lastName" value='.$row['last_name'].'>'; ?>
                                </div>
								<div class="login-form-input">
                                    <label for="Email">Email:</label>
                                    <?php echo '<input type="text" id="userName" name="email" value='.$row['email'].'>'; ?>
                                </div>
                                
								
                                <div class="login-form-input">
                                    <label for="Password">Password:</label>
                                    <?php echo '<input type="text" id="userName" name="password" value='.$row['password'].'>'; ?>
                                </div>
                                <div class="login-form-submit">
                                    <input type="submit" name="submit" id="submit" value="update">
                                    <h2><small><a href="logout.php">Logout</a><small></h2>
                                </div>  
                            </div>
                        </form>
                       
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