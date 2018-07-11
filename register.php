<?php 
  require_once('includes/config.php'); 
  require_once('includes/PhpImagizer.php'); 
  //if logged in redirect to Main page
  if( $user->is_logged_in() ){ header('Location: index.php'); } 
  //if form has been submitted process it
  if(isset($_POST['submit'])){
    //very basic validation
    if(strlen($_POST['username']) < 3){
      $error[] = 'Username is too short.';
    } else {
      $stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
      $stmt->execute(array(':username' => $_POST['username']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row['username'])){
        $error[] = 'Username provided is already in use.';
      }
      
    }
    if(strlen($_POST['password']) < 3){
      $error[] = 'Password is too short.';
    }
    if(strlen($_POST['passwordConfirm']) < 3){
      $error[] = 'Confirm password is too short.';
    }
    if($_POST['password'] != $_POST['passwordConfirm']){
      $error[] = 'Passwords do not match.';
    }
    //email validation
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $error[] = 'Please enter a valid email address';
    } else {
      $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
      $stmt->execute(array(':email' => $_POST['email']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row['email'])){
        $error[] = 'Email provided is already in use.';
      }
      
    }
    //if no errors have been created carry on
    if(!isset($error)){
      //hash the password
      $hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
      //create the activasion code
      $activasion = "Yes"; //md5(uniqid(rand(),true));
      try {
        //insert into database with a prepared statement
        $stmt = $db->prepare('INSERT INTO users (username,password,email,active,name) VALUES (:username, :password, :email, :active, :name)');
        $stmt->execute(array(
          ':username' => $_POST['username'],
          ':password' => $hashedpassword,
          ':email' => $_POST['email'],
          ':active' => $activasion,
          ':name' => $_POST['dname']
        ));
        $id = $db->lastInsertId('id');
        $contact->add_contact($id, 'ABCD', 'Ho Chi Minh', '0123456789', '0123456789', 'abcd@gmail.com', 'abcd', 'friend'); // default contact
        $core->activity('<strong>'.$_POST['username'].'</strong> has <strong>registered</strong>');
        
        // avatar
        if ($_FILES['avatar']['error'] > 0) {
          $error[] = "Error: " . $_FILES['avatar']['error'] . "<br />";
        } else {
          // array of valid extensions
          $validExtensions = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG', '.GIF', '.PNG');
          // get extension of the uploaded file
          $fileExtension = strrchr($_FILES['avatar']['name'], ".");
          // check if file Extension is on the list of allowed ones
          if (in_array($fileExtension, $validExtensions)) {
            $newName = $id.$fileExtension;
            $destination = 'uploads/users/' . $newName;
            $imagizer = new PhpImagizer($_FILES['avatar']['tmp_name']);
            $imagizer->fitSize(30);
            $imagizer->saveImg('./uploads/users/thumb/'.$id.$fileExtension);
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) { // current file size
              $error[] = 'File ' .$newName. ' Cant Upload';
            }else{
              $stmt = $db->prepare("UPDATE users SET avatar = '".$id.$fileExtension."' WHERE id = ".$id);
              $stmt->execute();
            }
          } else {
            $error[] = 'You must upload an image...';
          }
        }
        //send email
        /*
        $to = $_POST['email'];
        $subject = "Registration Confirmation";
        $body = "Thank you for registering at demo site.\n\n To activate your account, please click on this link:\n\n ".DIR."activate.php?x=$id&y=$activasion\n\n Regards Site Admin \n\n";
        $additionalheaders = "From: <".SITEEMAIL.">\r\n";
        $additionalheaders .= "Reply-To: ".SITEEMAIL."";
        mail($to, $subject, $body, $additionalheaders);
        //redirect to index page
        header('Location: index.php?action=joined');
        exit;
        //else catch the exception and show the error.
        */
      } catch(PDOException $e) {
        $error[] = $e->getMessage();
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Thalexim Contacts</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body>
    <body class="login2background2">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="box login">
                  <?php
                    //check for any errors
                    if(isset($error)){
                       foreach($error as $error){
                            echo '<p class="bg-danger">'.$error.'</p>';
                       }
                    }
                    //if action is joined show sucess
                    if(isset($_GET['action']) && $_GET['action'] == 'joined'){
                      echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
                    }
                   ?>
                    <div class="box-title">
                        <span class="ico"><i class="icon-lock"></i></span> ĐĂNG KÝ
                    </div>
                    <div class="box-content">
                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="" />
                            <div class="control-group">
                                <label for="username" class="control-label">Username</label>
                                <div class="controls">
                                    <input type="text" name="username" id="username" value="" required />
                                </div>
                            </div>
                            <div class="control-group">
                              <label for="Display Name" class="col-sm-2 control-label">Display Name</label>
                              <div class="controls">
                                <input type="text" class="form-control" id="dname"  name="dname" title="Must be 2-30 characters in length" pattern=".{2,30}" required />
                                <div style="color: red;" id="alert_dname"></div>
                              </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Password</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" title="Must be 4-20 characters in length" pattern=".{4,20}" value="" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" name="passwordConfirm" id="passwordConfirm" title="Must be 4-20 characters in length" pattern=".{4,20}" value="" required />
                                </div>
                            </div>
                            <div class="control-group">
                               <label for="Email" class="col-sm-2 control-label">Email</label>
                               <div class="controls">
                                 <input type="email" class="form-control" id="email"  name="email" title="Must be an email" required />
                                 <div style="color: red;" id="alert_email"></div>
                                 </div>
                            </div>  
                            <div class="control-group">
                               <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                               <div class="controls">
                                 <input id="avatar" name="avatar" type="file" class="file" accept="image/*">
                               </div>
                            </div> 
                      
                            <div class="form-actions">
                              <input type="submit"  name="submit" value="Register" class="btn-reg" /> or <a class="cancel" href="/thaleximcontact/login.php"> Back to site</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>   
    </body>
</html>