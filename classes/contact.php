<?php
class Contacts{

  private $_db;
  function __construct($db){
    $this->_db = $db;
  }
  public function activity($name){ 
    try {
      $stmt = $this->_db->prepare('INSERT INTO activity (name,added) VALUES (:name,:added)');
      $stmt->execute(array(':name' => $name,                           
                           ':added' => date('Y-m-d H:i:s')                          
                          ));
      $id = $this->_db->lastInsertId('id');      
      return $id;
      
    } catch(PDOException $e) {
      echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
    
  }
  public function username($id){  
    
    try {
      $stmt = $this->_db->prepare('SELECT username FROM users WHERE id = :id');
      $stmt->execute(array('id' => $id));      
      $row = $stmt->fetch();
      return $row['username'];
      
    } catch(PDOException $e) {
      echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function get_user_contact($userid){ 
    try {
      $stmt = $this->_db->prepare('SELECT * FROM contacts WHERE user_id = :id');
      $stmt->execute(array('id' => $userid));            
      return $stmt;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function contact_info($id){ 
    try {
      $stmt = $this->_db->prepare('SELECT * FROM contacts WHERE id = :id');
      $stmt->execute(array('id' => $id));         
      $row = $stmt->fetch();   
      return $row;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  public function delete($id){ 
    try {
      $stmt = $this->_db->prepare('SELECT * FROM contacts WHERE id = :id');
      $stmt->execute(array('id' => $id));
      $row = $stmt->fetch();
      unlink('./uploads/contacts/'.$row['photo']);      
      unlink('./uploads/contacts/thumb/'.$row['photo']);      
      $stmt = $this->_db->prepare('DELETE FROM contacts WHERE id = :id');
      $stmt->execute(array('id' => $id));
      $this->activity('<strong>'.$this->username($_SESSION['CURUSER']).'</strong> deleted a <strong>contact</strong>');
      return true;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }
  
  public function add_contact($userid,$name,$address,$home,$mobile,$email,$notes,$groups){ 
    try {
      $stmt = $this->_db->prepare('INSERT INTO contacts (user_id,name,address,home,mobile,email,notes,groups,added) VALUES (:user_id,:name,:address,:home,:mobile,:email,:notes,:groups,:added)');
      $stmt->execute(array(':user_id' => $userid,
                           ':name' => $name,
                           ':address' => $address,
                           ':home' => $home,
                           ':mobile' => $mobile,
                           ':email' => $email,
                           ':notes' => $notes,
                           ':groups' => $groups,
                           ':added' => date('Y-m-d H:i:s')                          
                          ));
      $id = $this->_db->lastInsertId('id'); 
      $this->activity('<strong>'.$this->username($_SESSION['CURUSER']).'</strong> added <strong> 1 contact</strong>');     
      return $id;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
     
  }
   public function edit_contact($id,$name,$address,$home,$mobile,$email,$notes,$groups){ 
    try {
      $stmt = $this->_db->prepare('UPDATE contacts SET name =:name, address =:address, home =:home, mobile =:mobile, email =:email, notes =:notes, groups =:groups WHERE id =:id');
      $stmt->execute(array(':name' => $name,
                           ':address' => $address,
                           ':home' => $home,
                           ':mobile' => $mobile,
                           ':email' => $email,
                           ':notes' => $notes,
                           ':groups' => $groups,
                           ':id' => $id                          
                          ));      
      return true;

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }
  }  
}  
?>