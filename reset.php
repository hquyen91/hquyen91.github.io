<?php require('includes/config.php'); 

//if logged in redirect to users page
if( $user->is_logged_in() ){ header('Location: index.php'); } 

//if form has been submitted process it
if(isset($_POST['submit'])){

  //email validation
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $error[] = 'Please enter a valid email address';
  } else {
    $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
    $stmt->execute(array(':email' => $_POST['email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($row['email'])){
      $error[] = 'Email provided is not on recognised.';
    }
      
  }

  //if no errors have been created carry on
  if(!isset($error)){

    //create the activasion code
    $token = md5(uniqid(rand(),true));

    try {

      $stmt = $db->prepare("UPDATE users SET resetToken = :token, resetComplete='No' WHERE email = :email");
      $stmt->execute(array(
        ':email' => $row['email'],
        ':token' => $token
      ));

      //send email
      $to = $row['email'];
      $subject = "Password Reset";
      $body = "Someone requested that the password be reset. \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address: ".DIR."resetPassword.php?key=$token";
      $additionalheaders = "From: <".SITEEMAIL.">\r\n";
      $additionalheaders .= "Reply-To: $".SITEEMAIL."";
      mail($to, $subject, $body, $additionalheaders);

      //redirect to index page
      header('Location: reset.php?action=reset');
      exit;

    //else catch the exception and show the error.
    } catch(PDOException $e) {
        $error[] = $e->getMessage();
    }

  }

}

//define page title
$title = 'Reset Account';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Reset Password</title>
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
    <body class="login2background3">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="box login">
                    <div class="box-title">
                        <span class="ico"><i class="icon-lock"></i></span> RESET PASSWORD
                    </div>
 <?php
  //check for any errors
  if(isset($error)){
    foreach($error as $error){
      echo '<p class="bg-danger">'.$error.'</p>';
    }
  }
  
  if(isset($_GET['action'])){
    
    //check the action
    switch ($_GET['action']) {
      case 'active':
        echo "<h5 class='bg-success'>Your account is now active you may now log in.</h5>";
        break;
      case 'reset':
        echo "<h5 class='bg-success'>Please check your inbox for a reset link.</h5>";
        break;
                            }
  }
  ?>
                    <div class="box-content">
                        <form class="form-horizontal" method="post" action="#" />
                            <div class="control-group">
                                <label for="username" class="control-label">Username</label>
                                <div class="controls">
                                    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="" tabindex="1">
                                </div>
                            </div>                              
                            <b> Vui Lòng Kiểm Tra Thư Mục Spam Sau Ít Phút</b>        
                            <hr>
                             <div class="form-actions">
                                <input type="submit" name="submit" value="Sent Reset Link" class="btn-reset" /> or <a class="cancel" href='login.php'>Back </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>