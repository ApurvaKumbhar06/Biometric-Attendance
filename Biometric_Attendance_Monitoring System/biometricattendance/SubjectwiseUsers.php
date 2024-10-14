<?php 
include('connectDB.php');
session_start();
$tid = $_SESSION['tid'];
$sub = $_SESSION['sub'];
$id = $_SESSION['id'];

if ($id == "") {
  header('Location: TeacherLogin.php');
} else {
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Users</title>
<link rel="stylesheet" type="text/css" href="css/Users.css">
<script>
  $(window).on("load resize ", function() {
    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
</script>
</head>
<body>
<?php include'TeacherHeader.php'; ?> 
<main>
  <section>
  <!--User table-->
  <h1 class="slideInDown animated">Here are all the Users</h1>
  <div class="tbl-header slideInRight animated">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>ID | Name</th>
          <th>Serial Number</th>
          <th>Gender</th>
          <th>Subject</th>
          <th>Finger ID</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content slideInRight animated">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
        <?php
          //Connect to database

            $sql = "select u.id,u.username,u.serialnumber,u.gender,u.subjects,u.fingerprint_id, u.user_date,u.time_in from users as u,teachers as t where FIND_IN_SET('$sub',u.subjects) > 0 and t.id = $id;";

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
                      <TD><?php echo $row['id']; echo" | "; echo $row['username'];?></TD>
                      <TD><?php echo $row['serialnumber'];?></TD>
                      <TD><?php echo $row['gender'];?></TD>
                      <TD><?php echo $row['subjects'];?></TD>
                      <TD><?php echo $row['fingerprint_id'];?></TD>
                      </TR>
        <?php
                }   
            }
          }
        ?>
      </tbody>
    </table>
  </div>
</section>
</main>
</body>
</html>