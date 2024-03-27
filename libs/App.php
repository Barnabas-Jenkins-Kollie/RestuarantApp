<?php require "../config/db_config.php"?>

<?php


class App{
  public $hostname = DB_HOST;
  public $dbname = DBNAME;
  public $dbuser = DBUSER;
  public $dbpassword = PASSWORD;
  public $link; 

// calling the db connection function
 public function __construct(){
    $this->dbconnection();
  }

  //db connection function
  public function dbconnection(){
    $this->link = new PDO("mysql:host="
    .$this->hostname.";dbname=".$this->dbname.
    "",$this->dbuser,$this->dbpassword);
  
    if ($this->link) {
    }
  }
//selection function from db
  public function selectAll($query){
    $rows = $this->link->query($query);
    $rows->execute();
    $allrows = $rows->etchAll(PDO::FETCH_OBJ);

    if ($allrows) {
        return $allrows;
    }

    else{
        return false;
    }
  }


  //select one function from db
  public function selectOne($query){
    $row = $this->link->query($query);
    $row->execute();
    $singlerow = $row->fetch(PDO::FETCH_OBJ);

    if ($singlerow) {
        return $singlerow;
    }

    else{
        return false;
    }
  }


  //insert method
  public function insert($query, $arr, $path){
    if ($this->validate($arr)== "empty") {
        echo "<script>alert('one or more form are empty')</script>"; 
    } else {
        $insert_record = $this->link->prepare($query);
        $insert_record->execute($arr);
        header("Location:".$path."");
    }

  }


  //update method
  public function update($query, $arr, $path){
    if ($this->validate($arr)== "empty") {
        echo "<script>alert('one or more form are empty')</script>"; 
    } else {
        $update_record = $this->link->prepare($query);
        $update_record->execute($arr);
        header("Location:".$path."");
    }

  }

  //delete method
    public function delete($query, $path){
        $delete_record = $this->link->query($query);
        $delete_record->execute();
        header("Location:".$path."");
    }

 public function register($query, $arr, $path){
    if ($this->validate($arr)=="empty") {
        echo "<script>alert('one or more form are empty')</script>"; 
    } else {
        $register_user = $this->link->prepare($query);
        $register_user->execute($arr);
        header("Location:".$path."");
    }
  }

  //login method

public function Login($data, $query,$path){
  $login_user = $this->link->query($query);
  $login_user->execute();
  $fetch = $login_user->fetch(PDO::FETCH_OBJ);


}

    //starting session
  public function starting_session(){
    session_start();
  }

  public function validate_session($path){
    if (isset($_SESSION['id'])) {
        header("Location: ".$path."");
    }

  }

  public function validate($arr){
    if (in_array("", $arr)) {
        echo "empty"; 

    }
  }
  
  
}

$app = new App;

