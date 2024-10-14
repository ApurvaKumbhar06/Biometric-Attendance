<?php

session_start();
//Connect to database
require'connectDB.php';

if (isset($_POST['log_date'])) {
  if ($_POST['date_sel'] != 0) {
      $_SESSION['seldate'] = $_POST['date_sel'];
  }
  else{
      $_SESSION['seldate'] = date("Y-m-d");
  }
}

if ($_POST['select_date'] == 1) {
    $_SESSION['seldate'] = date("Y-m-d");
}
else if ($_POST['select_date'] == 0) {
    $seldate = $_SESSION['seldate'];
}

$sql = "SELECT * FROM users_logs WHERE checkindate='$seldate' ORDER BY id DESC";
$result = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($result, $sql)) {
    echo '<p class="error">SQL Error</p>';
}
else{
  mysqli_stmt_execute($result);
    $resultl = mysqli_stmt_get_result($result);
  if (mysqli_num_rows($resultl) > 0){
      while ($row = mysqli_fetch_assoc($resultl)){
?>
            <TR>
            <TD><?php echo $row['id'];?></TD>
            <TD><?php echo $row['username'];?></TD>
            <TD><?php echo $row['serialnumber'];?></TD>
            <TD><?php echo $row['fingerprint_id'];?></TD>
            <TD><?php echo $row['checkindate'];?></TD>
            <TD><?php echo $row['timein'];?></TD>
            <TD><?php echo $row['timeout'];?></TD>
            </TR>
<?php
      }   
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Attendancewise User Report</title>
<link rel="stylesheet" type="text/css" href="css/userslog.css">
<script>
  $(window).on("load resize ", function() {
    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
</script>
<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
</script>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/user_log.js"></script>
<script>
  $(document).ready(function(){
 
      $.ajax({
        url: "AttendanceReport.php",
        type: 'POST',
        data: {
            'select_date': 1,
        }
      });
    setInterval(function(){
      $.ajax({
        url: "AttendanceReport.php",
        type: 'POST',
        data: {
            'select_date': 0,
        }
        success: function(response) {
           

            $('#userlog').html(response);
          
            //$('#dataTable').DataTable({responsive:true});


        }
        })
    },5000);
  });
</script>

</head>
<body>
<?php include'TeacherHeader.php'; ?> 
<main>
  <section>
  <!--User table-->
  <h1 class="slideInDown animated">Here are the Users daily logs</h1>
  	<div class="form-style-5 slideInDown animated">
  		<form method="POST" action="Export_Excel.php">
  			<input type="date" name="date_sel" id="date_sel">
        <button type="button" name="user_log" id="user_log">Select Date</button>
  			<input type="submit" name="To_Excel" value="Export to Excel">
  		</form>
  	</div>
  <div class="tbl-header slideInRight animated">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Serial Number</th>
          <th>Fingerprint ID</th>
          <th>Date</th>
          <th>Time In</th>
          <th>Time Out</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content slideInRight animated">
    
    <table cellpadding="0" cellspacing="0" border="0" id="userslog">
</table>
   
  </div>
</section>
</main>
</body>
</html>