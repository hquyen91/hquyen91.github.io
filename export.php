<?php
  require('includes/config.php');
  if($_POST['id']){
    $filename = $CURUSER.'_'.$_POST['name'];
    $stmt = $db->prepare('SELECT * FROM contacts WHERE user_id = :user_id');
    $stmt->execute(array('user_id' => $CURUSER));      
    while($row = $stmt->fetch()){                             
      $vcard->setName($row['name']);  
      // Every set functions below are optional
      // $vcard->setTitle("Software dev.");
      $vcard->setMobile($row['mobile']);
      $vcard->setHome($row['home']);    
      // $vcard->setURL("http://johndoe.com");
      // $vcard->setTwitter("diplodocus");
      $vcard->setMail($row['email']);
      $vcard->setAddress(array(
        "street_address"   => $row['address']
                                   ));
      $vcard->setNote($row['notes']);
      $vcard->setPhoto("uploads/contacts/".$row['photo']);       
      file_put_contents('export/'.$filename, $vcard, FILE_APPEND);
      
    }
    $core->backup($CURUSER, $filename);
  }
  if($_POST['remove']){
    $core->backup_remove($_POST['remove']);   
  }
?>  