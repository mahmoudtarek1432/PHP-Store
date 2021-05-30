<?php
  include "start_session.php";
  include "header.php";
  include "classes.php";
 ?>

<!--get front page items-->
 <?php
   $productlist = array();
   $hostname = "localhost";
   $dbname = "hardwarestore";
   $user= "hardwareuser";
   $pass = "1234";
   try{
     $query = "SELECT `productID`, `ProductName`, `ImgPath`, `Rating`, `Category`, `Price` FROM `products` order by `productID` DESC limit 8" ;
     $db = new mysqli($hostname,$user,$pass,$dbname);
     $request = $db->query($query);
     while($product = $request->fetch_assoc()){
       array_push($productlist,new product($product['ProductName'],$product['ImgPath'],$product['Rating'],$product['Category'],$product['Price'],$product['productID']));
     }
   }catch(Exception $ex){

   }
 ?>

 <!--main page items-->
<div class="mainpage">
    <div class="promotional">
        <div class="container">
            <div class="flex-container">
                <a href="Products.php?category=laptop&page=0">
                    <div class="image-block" style="background-image: url(Images/images.jpg);">
                        <div class="color-mask">

                        </div>
                        <div class="promo-text">
                            <h3>laptop</h3>
                            <h3>collection</h3>
                            <p>shop now <i class="fa fa-arrow-circle-right"></i></p>
                        </div>
                    </div>
                </a>
                <a href="Products.php?category=accessory&page=0" style="    margin: 0 2% 0 2%;">
                    <div class="image-block" style="background-image: url(Images/imagesXPY3DZR6.jpg);">
                        <div class="color-mask">

                        </div>
                        <div class="promo-text">
                            <h3>accessories</h3>
                            <h3>collection</h3>
                            <p>shop now <i class="fa fa-arrow-circle-right"></i></p>
                        </div>
                    </div>
                </a>
                <a href="Products.php?category=camera&page=0">
                    <div class="image-block" style="background-image: url(Images/images62BGSDB0.jpg);">
                        <div class="color-mask">

                        </div>
                        <div class="promo-text">
                            <h3>cameras</h3>
                            <h3>collection</h3>
                            <p>shop now <i class="fa fa-arrow-circle-right"></i></p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!--new items start-->
    <div class="new-products">
        <div class="container">
            <div class="new-products-header">
                <h3>New Products</h3>
                <ul class="categories">
                    <li><a class="active" href="#">laptops</a></li>
                    <li><a href="#">smartphones</a></li>
                    <li><a href="#">cameras</a></li>
                    <li><a href="#">accessories</a></li>
                </ul>
            </div>
            <?php
            if(count($productlist) != 0){
              for($i = 0;$i < count($productlist) ;$i++){
                if($i % 4 == 0){ // every forth item makes a new row
                if($i != 0){echo "</div>";}
                echo "<div class='items-grid'>";

              }?>
              <div class="item">

                  <img src="<?php echo $productlist[$i]->getimagepath(); ?>" alt="">
                  <a class="item-cat" href="products.php?category=<?php echo $productlist[$i]->getcategory()?>&page=0"><?php echo $productlist[$i]->getcategory(); ?></h4>
                  <a class="item-name" href="product.php?productid=<?php echo $productlist[$i]->getid()?>"><?php echo $productlist[$i]->getname(); ?></a>
                  <p class="item-price-after">EGP <?php echo $productlist[$i]->getprice(); ?><span class="item-price-before">1200</span></p>
                  <ul class="stars">
                    <?php
                      for($k = 0; $k < 5;$k++){
                        if($k < $productlist[$i]->getrating()){
                          echo '<i class="fa fa-star active"></i>';
                        }else{
                          echo '<i class="fa fa-star"></i>';
                        }
                      }
                     ?>
                  </ul>
                  <ul class="listings">
                      <i class="fa fa-heart"></i>
                      <i class="fa fa-connectdevelop"></i>
                      <i class="fa fa-comments"></i>
                  </ul>
              </div>
            <?php
                }
                echo "</div>";
              }
             ?>
        </div>
    </div>

    <!--new items end-->
</div>


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
