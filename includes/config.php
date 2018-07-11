<?php
ob_start();
session_start();
error_reporting (E_ALL ^ E_NOTICE);


//set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

//database credentials
define('DBHOST','85.10.205.173:3306');
define('DBUSER','hquyen91');
define('DBPASS','nonamevodanh');
define('DBNAME','contact');

//application address
define('DIR',''); // http://abc.com/
define('SITEEMAIL','');

try {

  //create PDO connection 
  $db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME.";charset=utf8", DBUSER, DBPASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  //show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
require_once('classes/user.php');
require_once('classes/core.php');  
require_once('classes/contact.php');
require_once('classes/vCard.php');

$user = new User($db);   
$core = new Core($db);
$contact = new Contacts($db);
$vcard = new vCard; 
  
  
if( !$user->is_logged_in()){ 
    //  header('Location: login.php'); 
}else{
    $CURUSER = $_SESSION['CURUSER'];
    $userInfo = $user->get_user_info($CURUSER);
}  
?>
