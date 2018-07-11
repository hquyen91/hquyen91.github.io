<?php
  include 'header.php';
  if(!$user->is_logged_in() || $userInfo['id'] != 1)
    header('Location: index.php');    
?>
                        <div class="span6">
                            <div class="box">
                                <div class="box-title">
                                    <span class="ico"><i class="icon-time"></i></span>Users
                                </div>
                                <div class="box-content nopadding">
                                    <table id="userTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                              <th>Avatar</th>
                                              <th>Username</th>
                                              <th>Email</th>
                                              <th>Opts</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                                                  
                                          <?php
                                             try {
                                               $stmt = $db->prepare('SELECT * FROM users ORDER BY id > 1');
                                               $stmt->execute();         
                                               while($row = $stmt->fetch()){
                                                 $avatar = $row['avatar'];
                                                 if(!$avatar ) 
                                                   $avatar = "0.jpg";                                                 
                                                  echo '<tr>
                                                         <td><center><img src="./uploads/users/thumb/'.$avatar.'" class="thumbnail"></center></td>
                                                         <td>'.$row['username'].'</td>
                                                         <td>'.$row['email'].'</span></td>
                                                         <td><a class="tooltip-top" href="#" title="Ban User"><i class="icon-info-sign"></i></a> <a class="u_delete tooltip-top" href="#" id="'.$row['id'].'" title="Delete" ><i class="icon-remove"></i></a></td>
                                                        </tr>';                                                
                                               }
                                             } catch(PDOException $e) {
                                               echo '<p class="bg-danger">'.$e->getMessage().'</p>';
                                             }
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                                              
                        </div>
                          <div class="span3">
                            <div class="box">
                                <div class="box-title">
                                    <span class="ico"><i class="icon-repeat"></i></span>Recent Activity
                                </div>
                                <div class="box-content nopadding">
                                    <ul class="activity-list">
                                      <?php
                                             try {
                                               $stmt = $db->prepare('SELECT * FROM activity ORDER BY id DESC limit 10');
                                               $stmt->execute();         
                                               while($row = $stmt->fetch()){
                                                 echo '<li><a href="#">
                                                             <i class="icon-user"></i>
                                                             '.$row['name'].'';
                                                 $seconds = time() - strtotime($row['added']);                                                                                                                     
                                                 $days = floor($seconds / 86400);
                                                 $seconds %= 86400;                                                 
                                                 $hours = floor($seconds / 3600);
                                                 $seconds %= 3600;                                                 
                                                 $minutes = floor($seconds / 60);
                                                 $seconds %= 60;
                                                 if($days > 0){
                                                    echo "<span> $days days ago</span>";
                                                 }else if($hours > 0){
                                                    echo "<span> $hours hours ago</span>";
                                                 }else if($minutes > 0){
                                                    echo "<span> $minutes minutes ago</span>";
                                                 }else if($seconds > 0){
                                                    echo "<span> $seconds seconds ago</span>";
                                                 }
                                               }
                                             } catch(PDOException $e) {
                                               echo '<p class="bg-danger">'.$e->getMessage().'</p>';
                                             }
                                             ?>
                                  </ul>
                              </div>
              </div>
</div>
 <?php
    include 'footer.php';
 ?> 