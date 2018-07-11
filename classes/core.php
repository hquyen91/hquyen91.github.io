<?php
  class Core{
    
    private $_db;
    function __construct($db){
      $this->_db = $db;
    }
    
    public function backup($userid, $filename){
      try {
        $stmt = $this->_db->prepare('INSERT INTO backup (user_id, name, added) VALUES (:user_id, :name, :added)');
        $stmt->execute(array(':user_id' => $userid,
                             ':name' => $filename,
                             ':added' => date('Y-m-d H:i:s')                          
                            ));
        $id = $this->_db->lastInsertId('id'); 
        $this->activity('<strong>'.$this->username($userid).'</strong> created a <strong>backup file</strong>');
        $result = array( 'id' => $id,
                         'filename' => $filename
                        );
        echo json_encode($result);     
      } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
      }
    }
    
    public function backup_remove($id){
      try {
        $stmt = $this->_db->prepare('SELECT * FROM backup WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $row = $stmt->fetch();
        unlink('./export/'.$row['name']);          
        $stmt = $this->_db->prepare('DELETE FROM backup WHERE id = :id');
        $stmt->execute(array('id' => $id));
        return true;
    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
      }
    }
      
    
    public function activity_info($id){ 
      try {
        $stmt = $this->_db->prepare('SELECT * FROM activity WHERE id = :id');
        $stmt->execute(array('id' => $id));         
        $row = $stmt->fetch();   
        return $row;
        
    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
      }
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
    
  }  
    ?>