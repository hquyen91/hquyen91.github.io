<?php
  require('includes/config.php'); 
  require_once('includes/PhpImagizer.php');
  $CURUSER = $_SESSION['CURUSER'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_POST['del']){
      if($contact->delete($_POST['del'])){
        echo "done";
      }else echo "error";
    }
    if($_POST['uremove']){
      $user->remove($_POST['uremove']);   
    }
    if($_POST['Contact']){
      if($row = $contact->contact_info($_POST['Contact']))
        $result = array( 'name' => $row ['name'], 
                         'address' => $row ['address'],
                         'home' => $row ['home'], 
                         'mobile' => $row ['mobile'], 
                         'email' => $row ['email'], 
                         'notes' => $row ['notes'], 
                         'group' => $row ['groups'],
                         'id' => $row['id'],
                         'photo' => $row['photo'],
                         'added' => $row['added']);
        echo json_encode($result);
    }
    if($_POST['name']){      
      $id = $contact->add_contact($CURUSER, $_POST['name'], $_POST['address'], $_POST['home'], $_POST['mobile'], $_POST['email'], $_POST['note'], $_POST['groups']);
      if($id){       
        if ( 0 < $_FILES['photo']['error'] ) {
          echo 'Error: ' . $_FILES['photo']['error'] . '<br>';
        }
        else {
          $fileExtension = strtolower(strrchr($_FILES['photo']['name'], "."));
          $imagizer = new PhpImagizer($_FILES['photo']['tmp_name']);
          $imagizer->fitSize(300);
          $imagizer->saveImg('./uploads/contacts/'.$id.$fileExtension);
          $imagizer->fitSize(70);
          $imagizer->saveImg('./uploads/contacts/thumb/'.$id.$fileExtension);
          $stmt = $db->prepare("UPDATE contacts SET photo = '".$id.$fileExtension."' WHERE id = ".$id);
          $stmt->execute();
          $result = array( 'name' => $_POST['name'], 
                           'address' => $_POST['address'],
                           'home' => $_POST['home'], 
                           'mobile' => $_POST['mobile'], 
                           'email' => $_POST['email'], 
                           'note' => $_POST['note'], 
                           'group' => $_POST['groups'],
                           'id' => $id,
                           'photo' => $id.$fileExtension);
          echo json_encode($result);
        }
      }else {
        echo "error";
      }
  }
  if($_POST['e_name']){      
        $result = $contact->edit_contact($_POST['id'], $_POST['e_name'], $_POST['e_address'], $_POST['e_home'], $_POST['e_mobile'], $_POST['e_email'], $_POST['e_note'], $_POST['e_groups']);
        if($result ){       
          if (!$_FILES['e_photo']['name']) {
            
          }
          else {
            //  unlink('./uploads/contacts/'.$id);
            $fileExtension = strtolower(strrchr($_FILES['e_photo']['name'], "."));
            $imagizer = new PhpImagizer($_FILES['e_photo']['tmp_name']);
            $imagizer->fitSize(300);
            $imagizer->saveImg('./uploads/contacts/'.$_POST['id'].$fileExtension);
            $imagizer->fitSize(70);
            $imagizer->saveImg('./uploads/contacts/thumb/'.$_POST['id'].$fileExtension);
          }
          $result = array( 'name' => $_POST['e_name'], 
                           'address' => $_POST['e_address'],
                           'home' => $_POST['e_home'], 
                           'mobile' => $_POST['e_mobile'], 
                           'email' => $_POST['e_email'], 
                           'note' => $_POST['e_note'], 
                           'group' => $_POST['e_groups'],
                           'id' => $_POST['id']
                          );
          echo json_encode($result);
       }else {
          echo "error";
       }      
    }    
  } 
?>