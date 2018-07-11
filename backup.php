<?php
  include 'header.php';  
  if(!$user->is_logged_in())
     header('Location: index.php');
  else $stmt = $user->get_user_backup($CURUSER);
?>
          <div class="span10" id="content">                    
          <div class="span10">
            <div class="box">
              <div class="box-title">
                <span class="ico"><i class="icon-time"></i></span>Backup Files
              </div>
              <div class="box-content nopadding">
                <table class="table table-striped table-bordered" id="bFiles">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Opts</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     while($row = $stmt->fetch()){
                       echo '<tr>
                               <td class="taskDesc"><i class="icon-info-sign"></i><a href="export/'.$row['name'].'">'.$row['name'].'</a></td>
                               <td class="taskStatus"><span class="done">Done</span></td>
                               <td class="taskOptions"><a class="b_delete tooltip-top" href="#" id="'.$row['id'].'" title="Delete" ><i class="icon-remove"></i></a></td>
                             </tr>';            
                     }
                   ?>
                    
                  </tbody>
                </table>
                <br>
                <div class="alert alert-info">
                  <button class="close" data-dismiss="alert">×</button>
                  <strong>Info!</strong> You can import this file to your android phone.
                </div>
                <div class="form-actions" align="right">
                  <button class="btn btn-inverse" id="Cbackup"><i class="icon-refresh icon-white"></i> Tạo mới</button>
                </div>
              </div>
            </div>
           </div>                    
          </div>
 <?php
    include 'footer.php';
 ?> 