$(document).ready(function(){
    // Add user
    $(document).on('click', '.teacher_add', function(){
      //user Info
      var name = $('#name').val();
      var email = $('#email').val();
      var dept = $('#dept').val();
      var sub = $('#sub').val();
      //Additional Info
      var timein = $('#timein').val();
      var gender = $(".gender:checked").val();
      
      $.ajax({
        url: 'manage_teachers_conf.php',
        type: 'POST',
        data: {
          'Add': 1,
          'name': name,
          'email': email,
          'timein': timein,
          'gender': gender,
          'dept': dept,
          'sub': sub
        },
        success: function(response){
          $('#name').val('');
          $('#email').val('');
          $('#dept').val('');
          $('#sub').val('');
  
          $('#timein').val('');
          $('#gender').val('');
          
          $('#alert').show();
          $('#alert').text(response);
          $.ajax({
            url: "manage_teacherss_up.php"
            }).done(function(data) {
            $('#manage_teachers').html(data);
          });
        }
      });
    });

    // Add user Fingerprint
    $(document).on('click', '.teachid_add', function(){
    alert("hi");
      var teachid = $('#teachid').val();;
      alert(teachid);
      $.ajax({
        url: 'manage_teachers_conf.php',
        type: 'POST',
        data: {
          'Add_teachID': 1,
          'teachid': teachid,
        },
        success: function(response){
          $('#teachid').val('');
          
          $('#alert').show();
          $('#alert').text(response);
          $.ajax({
            url: "manage_teachers_up.php"
            }).done(function(data) {
            $('#manage_teachers').html(data);
          });
        }
      });
    });
    // Update user
    $(document).on('click', '.teacher_upd', function(){
      //user Info
      var name = $('#name').val();
      var email = $('#email').val();
      var dept = $('#dept').val();
      var sub = $('#sub').val();
      //Additional Info
      var timein = $('#timein').val();
      var gender = $(".gender:checked").val();
  
      $.ajax({
        url: 'manage_teachers_conf.php',
        type: 'POST',
        data: {
          'Update': 1,
          'name': name,
          'email': email,
          'timein': timein,
          'gender': gender,
          'dept': dept,
          'sub': sub
        },
        success: function(response){
          $('#name').val('');
          $('#email').val('');
          $('#dept').val();
          $('#sub').val();
          $('#timein').val('');
          $('#gender').val('');
  
          $('#alert').show();
          $('#alert').text(response);
          
          $.ajax({
            url: "manage_teachers_up.php"
            }).done(function(data) {
            $('#manage_teachers').html(data);
          });
        }
      });   
    });
    // delete user
    $(document).on('click', '.teacher_rmo', function(){
        $.ajax({
          url: 'manage_teachers_conf.php',
          type: 'POST',
          data: {
          'delete': 1,
        },
        success: function(response){
          $('#name').val('');
          $('#email').val('');
          $('#dept').val();
          $('#sub').val();
          $('#timein').val('');
          $('#gender').val('');
  
          $('#alert').show();
          $('#alert').text(response);
          $.ajax({
            url: "manage_teachers_up.php"
            }).done(function(data) {
            $('#manage_teachers').html(data);
          });
        }
        });
    });
    // select user
    $(document).on('click', '.select_btn', function(){
      var Finger_id = $(this).attr("id");
      $.ajax({
        url: 'manage_teachers_conf.php',
        type: 'GET',
        data: {
        'select': 1,
        'Teach_id': Teach_id,
        },
        success: function(response){
  
          $('#alert').show();
          $('#alert').text(response);
  
          $.ajax({
            url: "manage_teachers_up.php"
            }).done(function(data) {
            $('#manage_teachers').html(data);
          });
        }
      });
    });
  });