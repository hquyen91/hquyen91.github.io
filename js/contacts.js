$(document).ready(function () {    
  // view contact
  var view_id, view_old_id, view_click = 0, edit_id, edit_old_id, edit_click = 0;
  $('.view').click(function (e){          
    view_id = $(this).val();
    var formData = new FormData();
    formData.append('Contact',view_id);
    $.ajax({
      url: "service.php",
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(data){
        var response = JSON.parse(data);
        $('.popup').attr('id', 'contact_'+response['id']);
        $('#view_name').text(response['name']);
        $("#thumb").attr("src","./uploads/contacts/"+response['photo']);
        $('#view_mobile').text(response['mobile']);
        $('#view_home').text(response['home']);
        $('#view_email').text(response['email']);
        $('#view_address').text(response['address']);
        $('#view_note').text(response['notes']);
        $('#view_added').text(response['added']);              
        if(!view_click || view_id != view_old_id){
          view_click = 1;
          view_old_id = view_id;
          $('#view_'+response['id']).trigger('click');
        }
      }
    });        
  });
  
  // Edit
  $('.edit').click(function (e){
    e.preventDefault();   
    edit_id = $(this).val();
    var formData = new FormData();
    formData.append('Contact',edit_id);
    $.ajax({
      url: "service.php",
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(data){
        var response = JSON.parse(data);
        $('.e_popup').attr('id', 'edit_contact_'+response['id']);
        $("#e_thumb").attr("src","./uploads/contacts/thumb/"+response['photo']); 
        $('#e_name').val(response['name']);
        $('#e_address').val(response['address']);
        $('#e_home').val(response['home']);
        $('#e_mobile').val(response['mobile']);
        $('#e_email').val(response['email']);
        $('#e_groups').val(response['group']);
        $('#e_note').val(response['notes']);
        $('#btn-edit').val(response['id']);
        if(!edit_click || edit_id != edit_old_id){
          edit_click = 1;
          edit_old_id = edit_id;
          $('#edit_'+response['id']).trigger('click');
        }
      }
    });                  
  });        
  
  //delete one row       
  var del_id;
  $('.del').click(function (e){          
    del_id = $(this).val();
  });
  $('.table a.delete').click(function(){
    if(confirm('Delete This Contact?')) $(this).parents('tr').fadeOut(function(){  
      var formData = new FormData();
      formData.append('del',del_id);            
      $.ajax({
        url: "service.php",
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(data){
          if(data == 'done'){
            $(this).remove();
          }else{
            alert('Error, Try Again Later'); 
          }
        }
      });      
    });
    return false;
  });
 
  
  /* backup function */
  $('#Cbackup').click(function (e){
    e.preventDefault();
    var now = new Date(); //without params it defaults to "now"
    var filename = now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"_"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds()+".vcf";                   
    var table = document.getElementById("bFiles");
    var rows = document.getElementById("bFiles").getElementsByTagName("tr").length;
    var row = table.insertRow(rows);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.className = 'taskDesc';
    cell2.className = 'taskStatus';
    cell3.className = 'taskOptions';           
    cell1.innerHTML = '<i class="icon-info-sign"></i><a href="export/'+filename+'">'+filename+'</a>';
    cell2.innerHTML = '<span class="in-progress">in progress</span>';
    cell3.innerHTML = '<a class="b_delete tooltip-top" title="Delete"><i class="icon-remove"></i></a>';
    
    var formData = new FormData(); 
    formData.append('id',1);      
    formData.append('name',filename);           
    $.ajax({
      url: 'export.php',
      type: 'POST',
      data: formData,
      async: true,
      success: function (data) {
        var response = JSON.parse(data);
        cell1.innerHTML = '<i class="icon-info-sign"></i><a href="export/'+response['filename']+'">'+response['filename']+'</a>';
        cell2.innerHTML = '<span class="done">Done</span>';
        cell3.innerHTML = '<a class="b_delete tooltip-top" id="'+response['id']+'" title="Delete"><i class="icon-remove"></i></a>';
      },
      cache: false,
      contentType: false,
      processData: false
    });
  });
  $('.table a.b_delete').click(function (e){     
    var row = $(this).parents('tr');
    var formData = new FormData();      
    formData.append('remove',$(this).attr("id"));
    $.ajax({
      url: 'export.php',
      type: 'POST',
      data: formData,
      async: true,
      success: function (data) {
        row.remove();
      },
      cache: false,
      contentType: false,
      processData: false
    });          
  }); 
    $('.table a.u_delete').click(function (e){    
    var row = $(this).parents('tr');
    var formData = new FormData();      
    formData.append('uremove',$(this).attr("id"));
    $.ajax({
      url: 'service.php',
      type: 'POST',
      data: formData,
      async: true,
      success: function (data) {
        row.remove();
      },
      cache: false,
      contentType: false,
      processData: false
    });          
  }); 
   
});
