<?php
include "start_session.php";
include "header.php";
include 'classes.php'
?>

<?php
  $productlist = array();
  $hostname = "localhost";
  $dbname = "hardwarestore";
  $user= "hardwareuser";
  $pass = "1234";
  if(isset($_GET["category"])){
    try{
      $query = "SELECT `productID`,`ProductName`, `ImgPath`, `Rating`, `Category`, `Price` FROM `products` WHERE Category = '" . $_GET['category'] ."'";
      $db = new mysqli($hostname,$user,$pass,$dbname);
      $request = $db->query($query);
      while($product = $request->fetch_assoc()){
        array_push($productlist,new product($product['ProductName'],$product['ImgPath'],$product['Rating'],$product['Category'],$product['Price'],$product['productID']));
      }
    }catch(Exception $ex){

    }
  }

  if(isset($_GET["search"])){
    try{
      $query = "SELECT `ProductName`, `Category` FROM `products` WHERE WHERE ProductName LIKE '%".$_GET["search"]."%' OR Category LIKE '%".$_GET["search"]."%'";
      $db = new mysqli($hostname,$user,$pass,$dbname);
      $request = $db->query($query);
      while($product = $request->fetch_assoc()){
        array_push($productlist,new product($product['ProductName'],$product['ImgPath'],$product['Rating'],$product['Category'],$product['Price'],$product['productID']));
      }
    }catch(Exception $ex){

    }
  }
?>
    <!--Product body start-->
    <div class="product-list-body">
        <div class="container">
            <div class="flex">
                <div class="side-menu">
                    <h3>catagories</h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-chevron-right"></i><p>Laptops</p></a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i><p>smartphones</p></a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i><p>cameras</p></a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i><p>accessories</p></a></li>
                    </ul>
                    <h3>shipped from</h3>
                    <ul>
                        <li><a href="#"><p>Global</p></a></li>
                        <li><a href="#"><p>Egypt</p></a></li>
                    </ul>
                    <div class="partition"></div>
                    <h3>Rating</h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star"></i><p>&#38 Up</p></a></li>
                        <li><a href="#"><i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i><p>&#38 Up</p></a></li>
                        <li><a href="#"><i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"> </i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i><p>&#38 Up</p></a></li>
                        <li><a href="#"><i class="fa fa-star yellow"></i> <i class="fa fa-star yellow"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i><p>&#38 Up</p></a></li>
                        <li><a href="#"><i class="fa fa-star yellow"> </i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i><p>&#38 Up</p></a></li>

                    </ul>
                </div>
                <div class="body">
                    <div class="topbar">
                        <div class="title">
                          <?php
                            if(isset($_GET["category"])){
                              echo "<h3>".$_GET['category']."</h3>";
                            }?>
                        </div>
                        <div class="item-count">
                          <?php
                            if(isset($_GET["category"])&& isset($_GET["page"])){
                              echo "<p>". ((($_GET["page"]*12) >= count($productlist))? 12 :  count($productlist) % 12) . " out of ". count($productlist) ."</p>";
                            }else{
                              echo "<p> 0 out of 0</p>";
                            }
                          ?>

                        </div>

                    </div>

                    <div class="item-list">
                      <?php
                        if(isset($_GET["category"]) && isset($_GET["page"]) && count($productlist) != 0){

                          $itemscount = (($_GET["page"]*12) >= count($productlist))? 12 :  count($productlist) % 12;
                          for($i = 0;$i < $itemscount;$i++){
                            if($i % 3 == 0){ // every forth item makes a new row
                            if($i != 0){echo "</div>";}
                            echo "<div class='items-grid'>";

                          }?>
                          <div class="item">

                              <img src="<?php echo $productlist[$i]->getimagepath(); ?>" alt="">
                              <h4 class="item-cat"><?php echo $productlist[$i]->getcategory(); ?></h4>
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
                          } else{
                            echo "<h3 class='no-products'>no items were found</h3>";
                          }
                          ?>
                        </div>
                    <div class="paggination">
                        <ul>
                          <?php
                          if(count($productlist) !=0){
                            for($i = 0;$i < ceil(count($productlist)/12);$i++){
                              $pageno = $i + 1;
                              if($i == $_GET["page"]){
                                echo "<li><a class='active' href='". $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"],'?') ."'>". $pageno ."</a></li>";
                              }else{
                                  echo "<li><a href='". $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"],'?') ."'> ". $i+1 ."</a></li>";
                              }
                            }
                          }
                           ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--Product body end-->

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
    <script src="script/main.js"></script>
</body>
</html>
