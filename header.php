<?php
  require('includes/config.php'); 
  
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
    <link href="css/bootstrap-modal-bs3patch.css" rel="stylesheet" />
    <script type="text/javascript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src='js/contacts.js'></script>
  </head>
    <body>
        <div class="container-fluid nopadding">
            <div class="row-fluid">
                <div class="span12">
                    <div id="header">
                        <a href="index.php">
                          <img src="img/thalexim.png" class="rounded" alt="" />
                       </a>
            <div class="hright">
              <?php if($user->is_logged_in()) { ?>
              <div id="userinfo" class="column">
                <a class="userinfo dropown-toggle" data-toggle="dropdown" href="#userinfo">
                  <span><strong><?php echo $userInfo['name']; ?></strong></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="profile.php">Edit Profile</a></li>
                  <li class="divider"></li>
                  <li><a href="logout.php">Logout</a></li>
                  </ul>
              </div>
              <?php } ?>
            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="container">
            <div class="row-fluid">
                <div class="span3 leftmenu">
                    <ul class="nav">
                      <li class="active"><a href="/"><span class="ico"><i class="icon-home"></i></span><span class="text">DASHBOARD</span></a></li>
                      <?php if( $user->is_logged_in()){ ?> <li><a href="backup.php"><span class="ico"><i class="icon-inbox"></i></span><span class="text">Backup</span></a></li><?php } ?>
                      <?php if( $CURUSER == 1){ ?>
                      <li><a href="admin.php"><span class="ico"><i class="icon-cogwheel"></i></span><span class="text">Admin</span></a></li>
                      <?php } ?>
                      <?php if( !$user->is_logged_in()){ ?>
                         <li><a href="login.php"><span class="ico"><i class="icon-login"></i></span><span class="text">ĐĂNG NHẬP</span></a></li>
                         <li><a href="register.php"><span class="ico"><i class="icon-cogwheel"></i></span><span class="text">ĐĂNG KÝ</span></a></li>
                      <?php } ?>                      
                    </ul>
                </div>