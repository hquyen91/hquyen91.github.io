$(document).ready(function(){
    
  // DataTable initialization
  $('#datatable').DataTable();    
  $('#bFiles').DataTable();
  $('#userTable').DataTable();
  // Add contact to database
  $('#btn-add').click(function (e){
    e.preventDefault();   
    $("#response").html('<img src="img/loading.gif" />');
    setTimeout(upload, 100);
  });
  $('#btn-edit').click(function (e){
    e.preventDefault();
    var edit_id = $(this).val();
    $("#e_response").html('<img src="img/loading.gif" />');
    update(edit_id);
  });
  
  function upload(){
    var form = $('#add_contact')[0];  
    var formData = new FormData(form);          
    $.ajax({
      url: 'service.php',
      type: 'POST',
      data: formData,
      async: true,
      success: function (data) {
        $("#response").html("Done, Add new or close!");
        $('#add_contact')[0].reset();
        var response = JSON.parse(data);
        var t = $('#datatable').DataTable();
        var counter = 1;  
        t.row.add( [
          '<center><img src="./uploads/contacts/thumb/'+response['photo']+'" class="thumbnail"></center>',
          response['name'],
          response['mobile'],
          response['email'],
          '<button class="view btn btn-primary" id="view_'+response['id']+'" data-toggle="modal" href="#contact_'+response['id']+'" value="'+response['id']+'">View</button>&nbsp;'+
          '<button class="edit btn btn-primary" data-toggle="modal" href="#stack2" value="'+response['id']+'">Edit</button>&nbsp;'+
          '<a class="delete"><button class="del btn btn-danger" value="'+response['id']+'">Delete</button></a>'
        ]).draw();
      },
      cache: false,
      contentType: false,
      processData: false
    });
  } 
  // Edit contact
    function update(id){
    var form = $('#edit_contact')[0];  
    var formData = new FormData(form); 
    formData.append('id',id);      
    $.ajax({
      url: 'service.php',
      type: 'POST',
      data: formData,
      async: true,
      success: function (data) {
        $("#e_response").html("Done!");
        var response = JSON.parse(data);        
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }
});
