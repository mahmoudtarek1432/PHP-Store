<?php
  include "start_session.php";
  include "header.php";
  include "classes.php";
 ?>

    <!--profile page php-->
    <?php
    $username = "";
    $password = "";
    $email = "";
    $name = "";
    $address = "";
    $cart = "";
    $cartarr = "";
    $itemdetails = array(); //array

        if(isset($_POST["checkout"]) && isset($_SESSION["userid"])){
          if($_POST["checkout"]!=""){
            $userid = $_SESSION["userid"];
            $items = $_POST["checkout"];
            $date = date("l")." ".date("d/m/y")." ".date("h:i:sa");

            $query = "INSERT INTO `orders` (`UserId`,`Date`,`OrderItems`) VALUES ($userid,'$date','$items')";
            $hostname = "localhost";
            $dbname = "hardwarestore";
            $user = "hardwareuser";
            $pass = "1234";

            try{
              $db = new mysqli($hostname,$user,$pass,$dbname);
              if($db->query($query)){
                $query = "UPDATE `users` SET `cart`='' WHERE id = ".$_SESSION["userid"];
                $db->query($query);
              }
            }catch(Exception $ex){

            }
          }
        }

        if(isset($_SESSION["userid"])){

          //validate that the username is not taken
          $query = "SELECT * FROM users";
          $hostname = "localhost";
          $dbname = "hardwarestore";
          $user = "hardwareuser";
          $pass = "1234";

          try{
            $db = new mysqli($hostname,$user,$pass,$dbname);
            $statment = $db->query($query);

            while($userrow = $statment->fetch_assoc()){
              if($_SESSION["userid"] == $userrow['id']){
                $username = $userrow['username'];
                $password = $userrow['password'];
                $email = $userrow['email'];
                $name = $userrow['name'];
                $address = $userrow['shippingaddress'];
                $phonenum = $userrow['phonenumber'];
                $cart = $userrow['cart'];
              }
            }
            if($cart != ""){
              $cartarr = array();
              $cartarr = product::propertyToArray($cart);
              for ($i=0; $i < count($cartarr); $i++) { //cartarr is array of strings
                $cartarr[$i] = CartItem::processItemString($cartarr[$i]);
              }

            // now cart array is an associative array of itemid and quantity
            for ($i=0; $i < count($cartarr); $i++) {
              $query = "SELECT `ProductName`, `ImgPath`, `Price` FROM `products` WHERE ProductID =". $cartarr[$i]["productid"];
              $statment = $db->query($query);
              array_push($itemdetails,$statment->fetch_assoc());
            }
          }
            //print_r($itemdetails);
        }catch(Exception $e){

        }
      }
    ?>

         <!--profile start-->
         <div class="profile">
             <div class="container">
                 <div class="account-controller">
                     <div class="account-panel">
                         <ul>
                             <li class="active"><a href="#"><i class="fa fa-user"></i><p>My Account</p></a></li>
                             <li><a href="#"><i class="fa fa-archive"></i><p>Orders</p></a></li>
                             <li><a href="#"><i class="fa fa-comment"></i><p>Reviews</p></a></li>
                             <li><a href="#"><i class="fa fa-heart"></i><p>Saved Items</p></a></li>
                             <li><a href="#"><i class="fa fa-info"></i><p>Details</p></a></li>
                         </ul>
                         <form class="" action="home.php" method="post">
                           <button class="logout" type="submit" name="logout">
                               <p>logout</p>
                           </button>
                         </form>
                     </div>
                     <div class="account-overview">
                         <h3>account overview</h3>
                         <div class="blocks">
                             <div class="account-details">
                                 <div class="head">
                                     <p>Account details</p>
                                     <i class="fa fa-pencil"></i>
                                 </div>
                                 <h4><?php echo $name; ?></h4>
                                 <p><?php echo $email ?></p>
                                 <p class="Cpassword"><a href="#">change password</a></p>
                             </div>
                             <div class="account-details">
                                 <div class="head">
                                         <p>address book</p>
                                         <i class="fa fa-pencil"></i>
                                     </div>
                                     <h4>Your default shipping address:</h4>
                                     <p><?php echo $name ?></p>
                                     <p><?php echo $address ?></p>
                                     <p>+20 <?php echo $phonenum ?></p>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <!--l-->
                     <div class="cart-checkout">
                         <h2>checkout</h2>
                         <div class="cart-container">
                           <?php  if($cart != ""){ ?>
                             <div class="cart-header">
                                 <ul>
                                     <li class="product">product</li>
                                     <li class="product-id">product id</li>
                                     <li class="price">price</li>
                                     <li class="quantity">quantity</li>
                                     <li class="total">total</li>
                                 </ul>
                             </div>
                             <?php
                           
                                for ($i=0; $i < count($cartarr); $i++) { ?>
                                  <div class="cart-item">
                                      <div class="product product-item">
                                          <img src="<?php  echo $itemdetails[$i]["ImgPath"]?>" alt="">
                                          <div class="text">
                                              <h5><?php  echo $itemdetails[$i]["ProductName"]?></h5>

                                          </div>
                                      </div><div class="product-id product-id-item">
                                          <p><?php  echo $cartarr[$i]["productid"] ?></p>
                                      </div>
                                      <div class="price price-item">
                                          <h3><?php  echo $itemdetails[$i]["Price"]?> EGP</h3>
                                      </div>
                                      <div class="quantity quantity-item">
                                          <input type="text" value="<?php  echo $cartarr[$i]["quantity"];?>">
                                      </div>
                                      <div class="total total-item">
                                          <h3><?php  echo (float)$itemdetails[$i]["Price"] * (int)$cartarr[$i]["quantity"] ?> EGP</h3>
                                      </div>
                                  </div>
                                <?php }?>
                                 <div class="cart-bottom">
                                     <p>total cost:<span>
                                       <?php
                                       $total = 0;
                                       for ($i=0; $i < count($itemdetails); $i++) {
                                         $total = $total + ((float)$itemdetails[$i]["Price"] * (int)$cartarr[$i]["quantity"]) ;
                                         }
                                         echo $total;
                                         ?> EGP</span></p>
                                     <form class="" action="profile.php" method="post">
                                       <button type="submit" name="checkout" value="<?php echo $cart;?> ">check out</button>
                                     </form>
                                 </div>
                               <?php } ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!--profile end-->

          <!--cover image start-->
          <div class="coverphoto">
                 <img src="Images/slider.jpg" alt="">
         </div>
         <!--cover image start-->

         <!--footer area-->
         <div class="footer">
             <div class="footer-main">
                 <div class="container">
                     <div class="flex-container">
                         <div class="follow">
                             <div class="title">
                                 <h3>follow</h3>
                             </div>
                             <div class="links">
                                 <div class="circle">
                                     <a href="#"><i class="fa fa-facebook"></i></a>
                                 </div>
                                 <div class="circle">
                                     <a href="#"><i class="fa fa-instagram"></i></a>
                                 </div>
                                 <div class="circle">
                                     <a href="#"><i class="fa fa-twitter"></i></a>
                                 </div>
                                 <div class="circle">
                                     <a href="#"><i class="fa fa-linkedin"></i></a>
                                 </div>
                                 <div class="circle">
                                     <a href="#"><i class="fa fa-youtube-play"></i></a>
                                 </div>
                             </div>
                             <div class="pages">
                                 <ul>
                                     <li><a href="#">home</a></li>
                                     <li><a href="#">hot deals</a></li>
                                     <li><a href="#">categories</a></li>
                                     <li><a href="#">laptops</a></li>
                                     <li><a href="#">smartphones</a></li>
                                     <li><a href="#">cameras</a></li>
                                     <li><a href="#">accessories</a></li>
                                 </ul>
                             </div>
                         </div>
                         <div class="subscribe">
                             <ul>
                                 <li><a href="#">new arivals</a></li>
                                 <li><a href="#">discount</a></li>
                                 <li><a href="#">contact us</a></li>
                             </ul>
                             <h3>Subscribe to get the latest on sales,new releases and more...</h3>
                             <div class="input-box">
                                 <input type="text" placeholder="Enter Email Address">
                                 <button>search</button>
                             </div>
                             <div class="payments">
                                 <h3>Supported payment systems</h3>
                                 <div class="payments-systems">
                                     <img src="Images/visa.png" alt="">
                                     <img src="Images/master.png" alt="">
                                     <img src="Images/amex.png" alt="">
                                     <img src="Images/visa.png" alt="">
                                     <img src="Images/master.png" alt="">
                                     <img src="Images/amex.png" alt="">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="copyrights">
                 <p>Copyright 2019 All rights reserved. Designed by <span>XYZ</span></p>
             </div>
         </div>
         <script src="script/main.js"></script>
     </body>
     </html>
