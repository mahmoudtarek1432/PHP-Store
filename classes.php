<?php
  class product{
    public $productName;
    public $productID;
    public $imgpath;
    public $rating;
    public $category;
    public $price;
    public $specifications;
    public $keyfeatures;
    public $details;

    function __construct($pn,$path,$rate,$car,$price,$pid=0,$spec=0,$key=0,$details=0){
      $this->productName = $pn;
      $this->productID = $pid;
      $this->imgpath = $path;
      $this->rating = $rate;
      $this->category = $car;
      $this->price = $price;
      $this->specifications = array();
      $this->keyfeatures = array();
      $this->details = array();
    }

    function getname(){
      return $this->productName;
    }

    function getid(){
      return $this->productID;
    }

    function getrating(){
      return $this->rating;
    }

    function getimagepath(){
      return $this->imgpath;
    }

    function getcategory(){
      return $this->category;
    }

    function getprice(){
      return $this->price;
    }

    function getspecifications(){
      return $this->specifications;
    }

    function getkeyfeatures(){
      return $this->keyfeatures;
    }

    function getdetails(){
      return $this->details;
    }

    //removes regex from string
    static function propertyToArray($unprocessedString){ //takes a string from database as an input and returns an array with string conent without regex
      $arrayofstrings = array();
      $tempStr = "";
      for($i = 0;$i< strlen($unprocessedString);$i++){
        if($unprocessedString[$i] == "+"){
          array_push($arrayofstrings, $tempStr);
          $tempStr = "";
        }else{
          $tempStr = $tempStr . $unprocessedString[$i];
        }
      }
      array_push($arrayofstrings, $tempStr);
      return $arrayofstrings;
    }

    static function arraytoProperty($arr){
      $str = "";
      for($i = 0;$i < count($arr);$i++) {
        if($i == (count($arr)-1)){
          $str = $str . $arr[$i];
        }else{
          $str = $str . $arr[$i] ."+";
        }
      }
      return $str;
    }
}
/*
$pro = new product("name",1999,3,"hardware",33,"asdnhqwq+sadaddsf+asdas","asd+weqe+fsdf","jakskdn+qweqwe+w+errwerwer");
$arr = product::propertyToArray($pro->getspecifications());
$str = product::arraytoProperty($arr);
echo $str;*/
?>

<?php
  class CartItem{
    public $itemID;
    public $quantity;
    function __construct($itemID,$quantity){
      $this->itemID = $itemID;
      $this->quantity = $quantity;
    }
    function getitemid(){
      return $this->itemid;
    }
    function getquantity(){
      return $this->quantity;
    }

    static function processItemString($itemstr){ //takes the string from the database and return an accoiative array with the id and quantity
      $id=0;
      $quantity=0;
      $tempstr = "";
      for ($i=0; $i < strlen($itemstr); $i++) {
        if($itemstr[$i] == ":"){ // : is a regex that seprate itemid and quantity
          $id = $tempstr;
          $tempstr = "";
        }else{
          $tempstr = $itemstr[$i];

        }
      }
      $quantity = $tempstr;
      return array("productid"=>$id , "quantity" => $quantity);
    }

    function parseDBstring(){ // returns cartitem obj in DB format
      return $this->itemID . "" . $this->quantity;
    }

    function setquantity($quan){
      $this->quantity = $quan;
    }
  }
?>
