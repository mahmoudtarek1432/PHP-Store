<?php
  include "start_session.php";
  include "classes.php";
  include "header.php";
 ?>

 <?php
  $requestedProduct = "";
  $ProductDetails = array();
  $ProductKeyFeatures = array();
  $ProductSpecifications = array();
  if(isset($_GET['productid'])){
   $hostname = "localhost";
   $dbname = "hardwarestore";
   $user= "hardwareuser";
   $pass = "1234";
   try{
     //$query = "SELECT `productID`, `ProductName`, `ImgPath`, `Rating`, `Category`, `Price`, `Specification`, `KeyFeatures`, `Details` FROM `products` WHERE productID =".$_GET['productid'];
     $query = "SELECT `productID`, `ProductName`, `ImgPath`, `Rating`, `Category`, `Price` FROM `products` WHERE productID =".$_GET['productid'];
     $db = new mysqli($hostname,$user,$pass,$dbname);
     $request = $db->query($query);
     while($product = $request->fetch_assoc()){
       /*$requestedProduct = new product($product['ProductName'],$product['ImgPath'],$product['Rating'],
                                        $product['Category'],$product['Price'],$product['productID'],$product['Specification'],$product['KeyFeatures'],$product['Details']);*/
         $requestedProduct = new product($product['ProductName'],$product['ImgPath'],$product['Rating'],
                                        $product['Category'],$product['Price'],$product['productID']);

     }

   }catch(Exception $ex){

   }

   try{
     $query = "SELECT `Detail` FROM `details` WHERE `ProductId` = ".$_GET['productid'];
     $db = new mysqli($hostname,$user,$pass,$dbname);
     $request = $db->query($query);
     while($details = $request->fetch_assoc()){
       array_push($requestedProduct->details,$details['Detail']);
     }
   }catch(Exception $ex){

   }

   try{
     $query = "SELECT `feature` FROM `keyfeatures` WHERE `ProductId` = ".$_GET['productid'];
     $db = new mysqli($hostname,$user,$pass,$dbname);
     $request = $db->query($query);
     while($feat = $request->fetch_assoc()){
       array_push($requestedProduct->keyfeatures,$feat['feature']);
     }
   }catch(Exception $ex){

   }

   try{
     $query = "SELECT `spec` FROM `specifications` WHERE `ProductId` = ".$_GET['productid'];
     $db = new mysqli($hostname,$user,$pass,$dbname);
     $request = $db->query($query);
     while($qu = $request->fetch_assoc()){
       array_push($requestedProduct->specifications,$qu['spec']);
     }
   }catch(Exception $ex){

   }
 }
 ?>

<?php
  if(isset($_GET["productid"])){?>
 <!--product body start-->
 <div class="product-body">
     <div class="container">
         <div class="product-upper">
             <div class="product-main">
                 <div class="prod-images">
                    <img src='<?php echo $requestedProduct->getimagepath();?>' alt=''>
                 </div>
                 <div class="prod-card">
                     <h3><?php echo $requestedProduct->getname();?></h3>
                     <div class="cat">
                         <p>Catagorie:</p>
                         <a href="products.php/category=<?php echo $requestedProduct->getcategory();?>&page=0"><?php echo $requestedProduct->getcategory();?></a>
                     </div>
                     <li>
                       <a href="#">
                         <?php
                           for($k = 0; $k < 5;$k++){
                             if($k < $requestedProduct->getrating()){
                               echo '<i class="fa fa-star yellow"></i>';
                             }else{
                               echo '<i class="fa fa-star"></i>';
                             }
                           }
                          ?>
                       </a>
                     </li>

                     <div class="partition"></div>
                     <div class="price">
                         <h3<?php echo $requestedProduct->getprice();?></h3>
                     </div>

                     <?php if(isset($_SESSION["userid"])){ ?>
                       <form action="" method="post">
                           <button type="submit" name="droptocartID" value="<?php echo $requestedProduct->getid();?>">add to cart</button>
                       </form>
                     <?php  }else{ ?>
                       <button id="notsigned">add to cart</button>
                     <?php }?>
                 </div>
             </div>
             <div class="product-details">
                 <p>product details</p>
                 <div class="partition"></div>
                 <ol>
                   <?php
                    $detaillist = $requestedProduct->getdetails();
                      for ($i=0; $i < count($detaillist); $i++) {
                        echo "<li>". $detaillist[$i] ."</li>";
                      }
                    ?>

                 </ol>
             </div>
         </div>

         <div class="specifications">
             <h3>specifications</h3>
             <div class="partition"></div>
             <div class="content">
                 <div class="keyfeatures">
                     <p>Key Features</p>
                     <div class="partition"></div>
                     <ul>
                       <?php
                        $featurelist = $requestedProduct->getkeyfeatures();
                          for ($i=0; $i < count($featurelist); $i++) {
                            echo "<li>". $featurelist[$i] ."</li>";
                          }
                        ?>
                     </ul>
                 </div>
                 <div class="speci-sub">
                     <p>specifications</p>
                     <div class="partition"></div>
                     <ul>
                       <?php
                        $specifications = $requestedProduct->getspecifications();
                          for ($i=0; $i < count($specifications); $i++) {
                            echo "<li>". $specifications[$i] ."</li>";
                          }
                        ?>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>
<?php }?>
 <!--product body end-->

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
