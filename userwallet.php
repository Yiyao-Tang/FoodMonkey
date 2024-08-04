<?php
session_start();
include "dbconnect.php";
$userId = $_SESSION['sess_user_id'];
if (isset($_POST['submit'])) {
	if (empty($_POST['cardNumber']) || empty($_POST['cvv']) || empty($_POST['expiryDate']) || empty($_POST['quantity'])) {
	echo "All records to be filled in";
	exit;}
    

$cardNumber = $_POST['cardNumber'];
$cvv = $_POST['cvv'];
$expiryDate = $_POST['expiryDate'];    
$quantity = $_POST['quantity'];
$sql = "SELECT * FROM card WHERE card_number ='$cardNumber' AND CVV = '$cvv' AND expiry_date= '$expiryDate'";
$result = $dbcnx->query($sql);
if (!($row = $result->fetch_assoc())) {
    //echo "Sorry, the card failed validation";
    header('location: cardfail.html');
}
	
else if($quantity>$row['quantity']){
    //echo "Not enough balance on your card";
    header('location: nobalance.html');
}
else{
    $newBalance = $quantity;
    $sqlupdate = "UPDATE user SET wallet='$newBalance' WHERE user_id='$userId'";
    $resultu = $dbcnx->query($sqlupdate);
    header('location: topupsuccess.html');
}
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Wallet</title>
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
			<div class="product-leftcol">
		
				<h4>My Account</h4>
					<ul>
                        <li><a href="profile.php">Profile</a></li>
						<li><a href="userwallet.php">E-Wallet</a></li>
					</ul>
			</div>
			
            <div>
				
            </div>
            <div>
                <div class="content">
                    <div class="login-form">
						<div>
							<h3> My Wallet </h3>
							<p>Manage and protect your wallet</p>
							<p></p>
							<h3>E-Wallet balance:</h3>
							<p>
								<?php
                                
								$sql = "SELECT *
								FROM user WHERE user_id='$userId'";
								$result = $dbcnx->query($sql);
								if (!$result){
									
								}
								else{
									$row1 = $result->fetch_assoc();
									echo '$'.$row1['wallet'];
								};
								?>
                            </p>
						</div>
                        <form action="userwallet.php" method="POST" name="registerForm" onsubmit="return formCheck()">
                            <div class="login-form-box">
								<h3 align="center">Top up your E-Wallet</h3>
                                <div class="login-form-input">
                                    <label for="cardNumber">Card Number: </label>
                                    <input type="text" id="cardNumber" name="cardNumber">
                                </div>
								<div class="login-form-input">
                                    <label for="cvv">CVV:</label>
                                    <input type="number" id="cvv" name="cvv">
                                </div>
								<div class="login-form-input">
                                    <label for="expiryDate">Expiry Date (mm/yy):</label>
                                    <input type="date" id="expiryDate" name="expiryDate">
                                </div>
                                <div class="login-form-input">
                                    <label for="quantity">Top up amount ($):</label>
                                    <input type="number" id="quantity" name="quantity">
                                </div>
                                <div class="login-form-submit">
                                    <input type="submit" name="submit" id="submit" value="Submit" >
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
                <script type="text/javascript" src="validator-main.js"></script>
            </footer>
        </div>
        <script>
            function formCheck(){
                var firstname = document.forms["registerForm"]["cardNumber"].value;
                var lastname = document.forms["registerForm"]["cvv"].value;
                var expiryDate = document.forms["registerForm"]["expiryDate"].value;
                var password = document.forms["registerForm"]["quantity"].value;
                var email = document.forms["registerForm"]["email"].value;
				var expiryDate = document.forms["registerForm"]["expiryDate"].value;
                
                if(!chkDate(expiryDate)){
                    return false; 
                }
                if (firstname == "") {
                    alert("First Name cannot be empty!"); 
                    return false;
                }
                else if (lastname == ""){
                    alert("Last Name cannot be empty!");
                    return false;
                }
                else if (username == ""){
                    alert("Username cannot be empty!");
                    return false;
                }
                else if (email == ""){
                    alert("Email cannot be empty!");
                    return false;
                }
                // else if (password == ""){
                //     alert("Password cannot be empty!");
                //     return false;
                // }
				// else if (expiryDate == ""){
                //     alert("Expiry date cannot be empty!");
                //     return false;
                // }
            }
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
                    alert("Please input a search value!"); 
                    return false;
                }
            }
            function chkDate(val) {

                //var myExpiryDate = new Date(event.currentTarget.value);

                var today = new Date();

                var pos = (myExpiryDate.getTime() > today.getTime());

                if (!pos) {
                alert("The date choosen ("+ event.currentTarget.value+")is not in the right form. \n"+
                    "You must choose a date after the current date.\n");
                myExpiryDate.focus();
                myExpiryDate.select();
                return false;
                } 
            }

        </script>
        <script type="text/javascript" src="validator-main.js"></script>
    </body>
</html>