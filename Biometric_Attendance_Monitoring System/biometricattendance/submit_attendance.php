<?php
//Connect to database
require'connectDB.php';
  session_start();
$tid = $_SESSION['tid'];
$sub = $_SESSION['sub'];
$id = $_SESSION['id'];
$output = '';

if(isset($_POST["submit_attendance"])){
  
    if ( empty($_POST['date_sel'])) {

        $Log_date = date("Y-m-d");
    }
    else if ( !empty($_POST['date_sel'])) {

        $Log_date = $_POST['date_sel']; 
    }
       // $sql = "SELECT * FROM users,users_logs WHERE  users_logs.checkindate='$Log_date' and users.subjects='$sub' ORDER BY users_logs.id DESC";
        $sql = "SELECT users.*,users_logs.checkindate FROM users LEFT JOIN users_logs on users_logs.serialnumber=users.serialnumber WHERE users.subjects='$sub' and users_logs.checkindate!='$Log_date'";
		echo $sql;
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0){
            $output .= '
                        <table class="table" bordered="1">  
                          <TR>
                            <TH>ID</TH>
                            <TH>Name</TH>
                            <TH>Serial Number</TH>
                            <TH>Fingerprint ID</TH>
                            <TH>Date log</TH>
                            <TH>Subjects</TH>
                          </TR>';
              while($row=$result->fetch_assoc()) {
				  if($row['checkindate']=="")
				  {
					  $username=$row['username'];
					  $serialnumber=$row['serialnumber'];
					  $sql = "insert into users_logs (username, serialnumber, checkindate, timein, timeout) values ('$username','$serialnumber','$Log_date','00:00:00','00:00:00')";
			mysqli_query($conn,$sql);
				  }
                  $output .= '
                              <TR> 
                                  <TD> '.$row['id'].'</TD>
                                  <TD> '.$row['username'].'</TD>
                                  <TD> '.$row['serialnumber'].'</TD>
                                  <TD> '.$row['fingerprint_id'].'</TD>
                                  <TD> '.$row['checkindate'].'</TD>
                                  <TD> '.$row['subjects'].'</TD>
                              </TR>';
              }
              $output .= '</table>';
             // header('Content-Type: application/xls');
              //header('Content-Disposition: attachment; filename=User_Log'.$Log_date.'.xls');
               //header( "location: AttendanceReport.php" );
              echo $output;
              exit();
        }
        else{
            header( "location: AttendanceReport.php" );
            exit();
        }
}
?>