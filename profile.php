<?php
  include 'header.php';    
  if($_POST['email'] || $_POST['name']){
    $user->updateUser($CURUSER,$_POST["email"],$_POST["name"]);
  }
  if($_POST['oldPass'] && $_POST['oldPass'] && $_POST['oldPass']){
    if($user->password_verify($_POST["oldPass"],$userInfo['password']) != 1){
      $ret = "Old Password is wrong!";
    }
    else {
      if ($_POST["newPass"]!=$_POST["rePass"]) {
        $ret = "New pass is  not same as Re-new";
      } else {
        $hashedpassword = $user->password_hash($_POST["newPass"], PASSWORD_BCRYPT);
        $user->updatePass($_SESSION['CURUSER'],$hashedpassword);
        $ret ="Update Password successfully!";
      }
    }
  }
  $cur_user = $user->get_user_info($CURUSER);  
?> 
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box">
                                <div class="box-title">
                                    User Profile
                                </div>
                                <div class="box-content nopadding">
                                    <form name="exampleform" action="#" method="POST" class="form-horizontal" />
                                        <div class="control-group">
                                            <label class="control-label">Username</label>
                                            <div class="controls">
                                                <input type="text" disabled value="<?php echo $cur_user['username'] ?> ">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Email</label>
                                            <div class="controls">
                                                <input type="email" required name ="email" value="<?php echo $cur_user['email'] ?> ">
                                                <span class="help-inline">Your Email</span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Display Name</label>
                                            <div class="controls">
                                                <input type="text" required name="name" value="<?php echo $cur_user['name'] ?> ">
                                                <span class="help-inline">Enter your display name here</span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Old Password</label>
                                            <div class="controls">
                                                <input type="password" name="oldPass">
                                                <span class="help-inline">Enter your old password if you want change it</span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">New Password</label>
                                            <div class="controls">
                                                <input type="password" name="newPass">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Retype New Password</label>
                                            <div class="controls">
                                                <input type="password" name="rePass">
                                            </div>
                                        </div>
                                        <?php echo $ret; ?>
                                        <div class="form-actions">
                                            <input type="submit" class="btn btn-primary" value="Save" />
                                        </div>                                     
                                    </form>  
                                </div>
                            </div>                        
                        </div>
                    </div>
                  </div>
 <?php
    include 'footer.php';
 ?> 