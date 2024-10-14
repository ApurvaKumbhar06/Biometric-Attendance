<?php
//Connect to database
require'connectDB.php';
  session_start();
$tid = $_SESSION['tid'];
$sub = $_SESSION['sub'];
$id = $_SESSION['id'];
$output = '';

if(isset($_POST["To_Excel"])){
  
    if ( empty($_POST['date_sel'])) {

        $Log_date = date("Y-m-d");
    }
    else if ( !empty($_POST['date_sel'])) {

        $Log_date = $_POST['date_sel']; 
    }
        $sql = "SELECT * FROM users,users_logs WHERE  users_logs.checkindate='$Log_date' and users.subjects='$sub' ORDER BY users_logs.id DESC";
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
                            <TH>Time In</TH>
                            <TH>Time Out</TH>
                          </TR>';
              while($row=$result->fetch_assoc()) {
                  $output .= '
                              <TR> 
                                  <TD> '.$row['id'].'</TD>
                                  <TD> '.$row['username'].'</TD>
                                  <TD> '.$row['serialnumber'].'</TD>
                                  <TD> '.$row['fingerprint_id'].'</TD>
                                  <TD> '.$row['checkindate'].'</TD>
                                  <TD> '.$row['subjects'].'</TD>
                                  <TD> '.$row['timein'].'</TD>
                                  <TD> '.$row['timeout'].'</TD>
                              </TR>';
              }
              $output .= '</table>';
              header('Content-Type: application/xls');
              header('Content-Disposition: attachment; filename=User_Log'.$Log_date.'.xls');
              
              echo $output;
              exit();
        }
        else{
            header( "location: UsersLog.php" );
            exit();
        }
}
?>