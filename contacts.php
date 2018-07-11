<?php
  include 'header.php';  
?>   
                <div class="span9" id="content">
                    <div class="row-fluid quick-actions">
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box">                              
                                <div class="box-title">
                                  All Contact <i><a <?php if($user->is_logged_in()) echo "data-toggle='modal'"; ?> href="<?php if($user->is_logged_in()) echo '#add'; else echo 'login.php'; ?>"><img src="./img/user-add.png"></a></i>
                                </div>
                                <div class="box-content nopadding">                                  
                                    <table id="datatable" class="table table-striped table-bordered">
                                      <thead>
                                        <tr>
                                          <th>Ảnh</th>
                                          <th>Họ và tên</th>
                                          <th>Số mobile</th>
                                          <th>Email</th>
                                          <th>&nbsp;</th>
                                        </tr>
                                      </thead>
                                      <tbody>              
                                       <?php  
                                         $stmt = $contact->get_user_contact($CURUSER); //thay đổi $id=1 set admin
                                         while($row = $stmt->fetch()){
                                           if($row['mobile'])
                                             $number = $row['mobile'];
                                           else $number = $row['home'];
                                           $photo = $row['photo'];
                                           if(!$photo) 
                                               $photo = "1.png";
                                           echo '<tr>
                                                   <td><center><img src="./uploads/contacts/thumb/'.$photo.'" class="thumbnail"></center></td>
                                                   <td>'.$row['name'].'</td>
                                                   <td>'.$number.'</td>
                                                   <td>'.$row['email'].'</td>
                                                   <td>
                                                   <button class="view btn btn-view" id="view_'.$row['id'].'" data-toggle="modal" href="#contact_'.$row['id'].'" value="'.$row['id'].'">View</button>
                                                   <button class="edit btn btn-primary" id="edit_'.$row['id'].'" data-toggle="modal" href="#edit_contact_'.$row['id'].'" value="'.$row['id'].'">Edit</button>
                                                   <a class="delete"><button class="del btn btn-danger" value="'.$row['id'].'">Delete</button></a>
                                                   </td>
                                                 </tr>
                                               ';
                                         }
                                       ?>
                                      </tbody>
                                    </table>                                  
                                </div>                           
                            </div>
                        </div>
                    </div>
          <!-- Add contact -->
          <div id="add" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3>Add Contact</h3>
            </div>
            <form method="POST" enctype="multipart/form-data" class="form-horizontal" name="add_contact" id="add_contact">
              <div class="modal-body">                              
                <div class="control-group">
                  <label class="control-label">Name</label>
                  <div class="controls">
                    <input type="text" name="name" id="name" title="Must be 2-40 characters in length" pattern=".{2,40}" required/>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Address</label>
                  <div class="controls">
                    <input type="text" name="address" id="address" title="Must be 2-255 characters in length" pattern=".{2,255}"/>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Home number</label>
                  <div class="controls">
                    <input type="text" name="home" id="home" />
                    <div style="color: red;" id="alert_home"></div>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Mobile number</label>
                  <div class="controls">
                    <input type="text" name="mobile" id="mobile" />
                    <div style="color: red;" id="alert_mobile"></div>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Email</label>
                  <div class="controls">
                    <input type="email" name="email" id="email" />
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Group</label>
                  <div class="controls">
                    <input type="text" name="groups" id="groups" />
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Photo</label>
                  <div class="controls">
                    <input type="file" class="file" name="photo" id="photo" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Note</label>
                  <div class="controls">
                    <textarea name="note" id="note"></textarea>
                  </div>
                </div>   
                <center><div style="color: red;" id="response"></div></center>
              </div>
              <div class="modal-footer">                 
                <input type="submit" class="btn btn-primary" name="btn-add" id="btn-add" value="Done" />
                <button type="button" data-dismiss="modal" class="btn">Close</button>              
              </div>
            </form>
          </div> 
          <!-- View Contact details -->
          <div class="popup modal hide fade" tabindex="-1" data-focus-on="input:first">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="view_name"></h3>
            </div>
            <div class="modal-body">
              <table>
                <tr>
                  <td style="vertical-align:top;">
                    <left>
                      <p>&nbsp;&nbsp;<strong>Mobile:</strong> <b id="view_mobile"></b></p>
                      <p>&nbsp;&nbsp;<strong>Home:</strong> <b id="view_home"></b></p>
                      <p>&nbsp;&nbsp;<strong>Email:</strong> <b id="view_email"></b></p>
                      <p>&nbsp;&nbsp;<strong>Address:</strong> <b id="view_address"></b></p>
                      <p>&nbsp;&nbsp;<strong>Note:</strong> <b id="view_note"></b></p>
                      <p>&nbsp;&nbsp;<strong>Added:</strong> <b id="view_added"></b></p>
                    </left>
                  </td>    
                </tr>
              </table>
              <br />
            </div>
            <div class="modal-footer">              
              <button type="button" data-dismiss="modal" class="btn btn-primary">Ok</button>
            </div>
           </div> 
                  <!-- Edit Contact details -->       
          <div class="e_popup modal hide fade" tabindex="-1" data-focus-on="input:first">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3>Edit</h3>
            </div>
            <form method="POST" enctype="multipart/form-data" class="form-horizontal" name="edit_contact" id="edit_contact">
              <div class="modal-body">                              
                <div class="control-group">
                  <label class="control-label">Name</label>
                  <div class="controls">
                    <input type="text" name="e_name" id="e_name" title="Must be 2-40 characters in length" pattern=".{2,40}" required/>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Address</label>
                  <div class="controls">
                    <input type="text" name="e_address" id="e_address" title="Must be 2-255 characters in length" pattern=".{2,255}"/>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Home number</label>
                  <div class="controls">
                    <input type="text" name="e_home" id="e_home" />
                    <div style="color: red;" id="alert_e_home"></div>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Mobile number</label>
                  <div class="controls">
                    <input type="text" name="e_mobile" id="e_mobile" />
                    <div style="color: red;" id="alert_e_mobile"></div>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Email</label>
                  <div class="controls">
                    <input type="email" name="e_email" id="e_email" />
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Group</label>
                  <div class="controls">
                    <input type="text" name="e_groups" id="e_groups" />
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label">Photo</label>
                  <div class="controls">
                    <img id="e_thumb" /><br>
                    <input type="file" class="file" name="e_photo" id="e_photo" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Note</label>
                  <div class="controls">
                    <textarea name="e_note" id="e_note"></textarea>
                  </div>
                </div>   
                <center><div style="color: red;" id="e_response"></div></center>
              </div>
              <div class="modal-footer">                 
                <button type="submit" class="btn btn-primary" name="btn-edit" id="btn-edit">Submit</button>
                <button type="button" data-dismiss="modal" class="btn">Close</button>              
              </div>
            </form>
          </div> 
        </div>

 <?php
    include 'footer.php';
 ?> 