

<?php
    if(isset($_POST["droptocartID"])){
      if(isset($_SESSION["userid"])){
        $hostname = "localhost";
        $dbname = "hardwarestore";
        $user = "hardwareuser";
        $pass = "1234";

        $query = "SELECT  `cart` FROM `users` WHERE `id` = ". $_SESSION["userid"];
        try{
          $db = new mysqli($hostname,$user,$pass,$dbname);
          $statment = $db->query($query);
          $result = $statment->fetch_assoc();
          $cartstring = $result['cart'];
          $incartflag = False;//check if the item is in the cart? increase item number of items : add the item to the cart
            $cartarr = product::propertyToArray($cartstring);
            $itemdetails = ""; //assoc array of itemid and quantity
            $tempreplace = "";
            for ($i=0; $i < count($cartarr); $i++) {
              $itemdetails = CartItem::processItemString($cartarr[$i]);
              if($itemdetails["productid"] == $_POST["droptocartID"]) {
                $tempreplace = $cartarr[$i];
                $incartflag = True;
                break;
              }
            }


            if($incartflag == True){
              $itemdetails["quantity"] = (int)$itemdetails["quantity"] + 1;
              $cartstring = str_replace($tempreplace,$itemdetails["productid"] . ":" . $itemdetails["quantity"],$cartstring);
            }else{
              $cartstring = ($cartstring != "")? $cartstring . "+" . $_POST["droptocartID"] . ":1" : $cartstring  . $_POST["droptocartID"] . ":1" ;
            }
            //update $query
            $query = "UPDATE `users` SET `cart`= '$cartstring' WHERE `id` = ".$_SESSION["userid"];
            $db->query($query);
          }catch(Exception $ex){
            echo $ex;
        }
      }
    }

    $username = "";
    $password = "";
    $email = "";
    $name = "";
    $address = "";
    $phonenum = 0;
    $nametaken = False; //initial flag
    $emailalreadysigned = False;
    //signin auth
    $wronguser = True;
    $wrongpass = True;

    if(isset($_POST["signupusername"])){
      $username = $_POST["signupusername"];
      $password = $_POST["signuppassword"];
      $email = $_POST["email"];
      $name = $_POST["name"];
      $address = $_POST["shippingaddress"];
      $phonenum = $_POST["phonenumber"];


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
          if($username == $userrow['username']){
            $nametaken = true;

          }
          if($email == $userrow['email']){
            $emailalreadysigned = true;
          }
        }
        //if the name was not taken or email not signed
        if($nametaken == False && $emailalreadysigned == False){
        $query = "INSERT INTO `users`(`username`, `password`, `email`, `name`, `shippingaddress`, `phonenumber`)  VALUES ('$username','$password','$email','$name','$address',
          $phonenum)";

          /*$statment = $db->prepare($query);
          $statment->bindValue(':username',$username,PDO::PARAM_STR);
          $statment->bindValue(':password',$password,PDO::PARAM_STR);
          $statment->bindValue(':email',$email,PDO::PARAM_STR);
          $statment->bindValue(':name',$name,PDO::PARAM_STR);
          $statment->bindValue(':shippingaddress',$address,PDO::PARAM_STR);
          $statment->bindValue(':phonenumber',$phonenum,PDO::PARAM_STR);*/
          if($db->query($query) === TRUE){

          }
          else{

          }
        }
      }catch(Exception $e){
     /*   $error_message = $e->getMessage();
        echo $error_message;*/
      }

    }

    elseif (isset($_POST["signinusername"])) {
      $username = $_POST["signinusername"];
      $password = $_POST["signinpassword"];

      $hostname = "localhost";
      $dbname = "hardwarestore";
      $user= "hardwareuser";
      $pass = "1234";
      $id = 0;
      try{
      $db = new mysqli($hostname,$user,$pass,$dbname);

      $query = "SELECT  `id`,`username`, `password` FROM `users`";
      $result = $db->query($query);
      while($auth = $result->fetch_assoc()){
        if($username == $auth["username"]){
          $wronguser = false;
          if($password == $auth["password"]){
            $wrongpass = false;
            $id = $auth["id"];

            break;
          }
          break;
        }
      }
    }catch(Exception $e){
      $error_message = $e->getMessage();
      echo $error_message;
      }
      if($wronguser == false && $wrongpass == false){
        $_SESSION["userid"] = $id;
     }

   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practical in SE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>
    <!--top header start-->
    <!--<div class="top-header">
        <div class="container">
            <div class="flex-container">
                <ul>
                    <li class="icon-text-block">
                        <div class="icon"><i class="fa fa-phone"></i></div>
                        <div class="text">+20 01118172829</div>
                    </li>
                    <li class="icon-text-block">
                        <div class="icon"><i class="fa fa-envelope"></i></div>
                        <div class="text">dummydu@gmail.com</div>
                    </li>
                    <li class="icon-text-block">
                        <div class="icon"><i class="fa fa-map-marker"></i></div>
                        <div class="text">acu</div>
                    </li>
                </ul>
                <div class="account">
                    <a href="Practical Project/Sign in.HTML">
                        <div class="text">signin</div>
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="Practical Project/Sign Up.html">
                        <div class="text">signout</div>
                        <i class="fa fa-user"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>-->
     <!--top header end-->


      <!--main header start-->
    <div class="main-header">
        <div class="container">
            <div class="flex-box">
                <div class="brand-name">
                    <h2>softwa<span>re</span></h2>
                </div>
                <div class="search">
                    <div class="bar">
                      <form action="products.html" method="get">
                        <input class="input-bar" type="text" name="searchkeyword" placeholder="Search here">
                        <button type="submit" name="search">Search</button>
                      </form>
                    </div>
                </div>
                <?php echo isset($_SESSION["userid"]);
                if(isset($_SESSION["userid"])){ ?>
                  <a href="profile.php" class="cart" id="" data-toggle="false">
                      <div class="block">
                          <i class="fa fa-user"></i>
                          <p>account</p>
                      </div>
                  </a>
                <?php }else{ ?>
                <a href="#" class="cart" id="modal-trigger" data-toggle="false">
                    <div class="block">
                        <i class="fa fa-user"></i>
                        <p>signin/up</p>
                    </div>
                </a>
              <?php } ?>
            </div>
        </div>
    </div>
    <div class="spliter"></div>
     <!--top header start-->

    <!--signin modal start-->
    <?php
     if($nametaken || $emailalreadysigned){
            echo "<div class='modal' style='display:block'>";
        }
        else{
          echo"<div class='modal' style='display:none'>";
        }
    ?>
        <div class="modal-body">
            <div class="close">x</div>
            <div class="signup-partition">
                <h3>Sign up</h3>
                <form action="" method="post" name="signup">
                    <table>
                        <tr>
                            <td><label for="signupusername">Username</label></td>
                            <td><input type="text" name="signupusername"
                              <?php
                                if(isset($_POST["signupusername"])){
                                  if($nametaken){
                                  echo "style='border-color:red;'";
                                  }
                                }
                                ?>>
                              </td>
                        </tr>
                        <tr>
                            <td><label for="signuppassword">Password</label></td>
                            <td><input type="text" name="signuppassword"></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email</label></td>
                            <td><input type="text" name="email"
                              <?php
                                if(isset($_POST["signupusername"])){
                                  if($emailalreadysigned){
                                  echo "style='border-color:red;'";
                                  }
                                }
                                ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="name">name</label></td>
                            <td><input type="text" name="name"></td>
                        </tr>
                        <tr>
                            <td><label for="shippingaddress">shipping address</label></td>
                            <td><input type="text" name="shippingaddress"></td>
                        </tr>
                        <tr>
                            <td><label for="phonenumber">phone number</label></td>
                            <td><input type="text" name="phonenumber"></td>
                        </tr>


                    </table>
                    <input class="btnsubmit" id="signupbtn" type="button" value="Signup">
                </form>
            </div>
            <div class="signin-partition">
                <h3>sign in</h3>
                <form action="" method="post" name="signin">
                    <table>
                        <tr>
                            <td><label for="signinusername">Username</label></td>
                            <td><input type="text" name="signinusername"
                              <?php
                                if(isset($_POST["signinusername"])){
                                  if($wronguser){
                                  echo "style='border-color:red;'";
                                  }
                                }
                                ?>>
                              </td>
                        </tr>
                        <tr>
                            <td><label for="signinpassword">Password</label></td>
                            <td><input type="text" name="signinpassword"
                              <?php
                                if(isset($_POST["signinusername"])){
                                  if($wrongpass){
                                  echo "style='border-color:red;'";
                                  }
                                }
                                ?>>
                              </td>
                        </tr>
                    </table>
                    <input class="btnsubmit" id="signinbtn" type="button" value="Signin">
                </form>
            </div>
        </div>
    </div>
    <!--signin modal end-->

     <!--navbar start-->
    <div class="navbar">
        <div class="container">
            <ul>
              <?php
                if(isset($_GET['category'])){
                  echo '<li ><a href="home.php">home</a></li>';
                  if($_GET['category'] == "laptop"){
                    echo '<li><a href="Products.php?category=laptop&page=0" class="active">laptops</a></li>';
                  }
                  else{
                    echo '<li><a href="Products.php?category=laptop&page=0">laptops</a></li>';
                  }
                  if($_GET['category'] == "smartphone"){
                    echo '<li><a href="Products.php?category=smartphone&page=0"  class="active">smartphones</a></li>';
                  }
                  else{
                    echo '<li><a href="Products.php?category=smartphone&page=0">smartphones</a></li>';
                  }
                  if($_GET['category'] == "camera"){
                    echo '<li><a href="Products.php?category=camera&page=0"  class="active">cameras</a></li>';
                  }
                  else{
                    echo '<li><a href="Products.php?category=camera&page=0">cameras</a></li>';
                  }
                  if($_GET['category'] == "accessory"){
                    echo '<li><a href="Products.php?category=accessory&page=0"  class="active">accessories</a></li>';
                  }
                  else{
                    echo '<li><a href="Products.php?category=accessory&page=0">accessories</a></li>';
                  }
                }
                else{?>
                  <li ><a class="active" href="home.php">home</a></li>
                  <li><a href="Products.php?category=laptop&page=0">laptops</a></li>
                  <li><a href="Products.php?category=smartphone&page=0">smartphones</a></li>
                  <li><a href="Products.php?category=camera&page=0">cameras</a></li>
                  <li><a href="Products.php?category=accessory&page=0">accessories</a></li>
              <?php  }?>
            </ul>
        </div>
    </div>
     <!--navbar end-->
  <script src="script/main.js"></script>
