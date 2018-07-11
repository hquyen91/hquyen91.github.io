<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
      parent::__construct();
    
      $this->_db = $db;
    }

  private function get_user_hash($username){  

    try {
      $stmt = $this->_db->prepare('SELECT password FROM users WHERE username = :username AND active="Yes" ');
      $stmt->execute(array('username' => $username));
      
      $row = $stmt->fetch();
      return $row['password'];

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function remove($id){ 
    try {
      $stmt = $this->_db->prepare('DELETE FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));      
      $row = $stmt->fetch();

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }

  public function updateUser($id,$email,$name){  
    try {
      $stmt_string = "update users set email=?,name=? where id=?;";
      $stmt = $this->_db->prepare($stmt_string);
      $stmt->execute(array($email,$name,$id));      

    } catch(PDOException $e) {
      echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }

  public function updatePass($id,$password){  
    try {
      
      $stmt_string = "update users set password=? where id=?;";
      $stmt = $this->_db->prepare($stmt_string);
      $stmt->execute(array($password,$id));      

    } catch(PDOException $e) {
      echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  
  
  public function get_user_id($username){  

    try {
      $stmt = $this->_db->prepare('SELECT id FROM users WHERE username = :username');
      $stmt->execute(array('username' => $username));      
      $row = $stmt->fetch();
      return $row['id'];

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function get_user_name($id){  

    try {
      $stmt = $this->_db->prepare('SELECT username FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));      
      $row = $stmt->fetch();
      return $row['username'];

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function get_user_info($id){  

    try {
      $stmt = $this->_db->prepare('SELECT * FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));      
      $row = $stmt->fetch();
      return $row;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function get_user_backup($id){  

    try {
      $stmt = $this->_db->prepare('SELECT * FROM backup WHERE user_id = :user_id');
      $stmt->execute(array('user_id' => $id));      
      return $stmt;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }

  public function login($username,$password){

    $hashed = $this->get_user_hash($username);
    
    if($this->password_verify($password,$hashed) == 1){        
        $_SESSION['loggedin'] = true;
      $_SESSION['CURUSER'] = $this->get_user_id($username);
        return true;
    }   
  }
    
  public function logout(){
    session_destroy();
  }

  public function is_logged_in(){
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      return true;
    }    
  }
  
}
?>