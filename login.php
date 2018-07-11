<?php
  require_once('includes/config.php');
  
  if(isset($_POST['submit'])){
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($user->login($username,$password)){       
      header('Location: index.php');
      exit;
      
    } else {
      $error = 'Wrong username or password or your account has not been activated.';
    }
    
  }//end if submit
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard - Admin</title>
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
    <body class="login2background">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="box login">
                    <div class="box-title">
                        <span class="ico"><i class="icon-lock"></i></span> ĐĂNG NHẬP
                    </div>
                    <div class="box-content">
                        <form class="form-horizontal" method="post" action="login.php" />
                            <p><?php if($_GET['action'] == "resetAccount") echo "Password Has Changed!"; else echo "Hãy đăng nhập để sử dụng"; ?></p>
                            <div class="control-group">
                                <label for="username" class="control-label">Username</label>
                                <div class="controls">
                                    <input type="text" name="username" id="username" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Password</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" value="" />
                                </div>
                            </div>
                            <?php echo $error; ?>
                            <div class="form-actions">
                                <input type="submit" name="submit" value="Login" class="btn-reset" /> or <a class="reg" href="register.php">Register</a>
                                 <br>
                                 <br>
                                <a class="cancel" href="reset.php">Forgot Password</a>
                                <p></p>
                                <p><a href="http://thalexim.vn/">About®</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
</html>