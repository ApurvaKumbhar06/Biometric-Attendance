<?php

$UserName = '';
$Password='';
$sql = '';
$rs = '';
$msg = '';
include('connectDB.php');
include('header.php');

if($_POST)
{
	if(isset($_POST['btn_login']))
	{
		if(isset($_POST['email']))
		{
			$user_name = $_POST['email'];
		}
		if(isset($_POST['teachid']))
		{
			$password = $_POST['teachid'];
		}
		
		if($_POST['btn_login']=='Login')
		{
			
			$sql="select * from teachers where email='$user_name' and teacher_id='$password' and del_teacherid=0";			
			$rs=mysqli_query($conn,$sql);
			if(!$rs){					
				?><script lang="javascript" type="text/javascript">alert("Login Unsuccesful..."); 
					window.location = "TeacherLogin.php";</script> <?php
			}
			else{
				
				if($row=mysqli_fetch_assoc($rs)){
					$id = $row['id'];	
                    $tid = $row['teacher_id'];
                    $sub = $row['subjects'];
					
					session_start();
					$_SESSION['id'] = $id;
                    //echo $_SESSION['id'];
					$_SESSION['tid'] = $tid;
                    $_SESSION['sub'] = $sub;
					$msg = "Login Successfully...";
         			header("location:SubjectwiseUsers.php");
               //echo $_SESSION['id'];
				}	
				else
				{
					?><script lang="javascript" type="text/javascript">alert("Login unsuccesful..."); 
					window.location = "TeacherLogin.php";</script> <?php
					//echo 'Login Unsuccesful';
				}
			}
		}
	}
}
else{
//include('include/home/header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Teacher Login Form</title>
<link rel="stylesheet" type="text/css" href="css/manageusers.css">
<style>
.form-style-5{
  height: 300px;

  margin: 30px 450px;

}
.topnav{
	display: none;
}
@media only screen and (max-width: 600px) {
    .form-style-5{
        margin: 30px 10px;
 
    }
}
</style>

</head>
<body>
<main>
	<h1 class="slideInDown animated">Teacher Login</h1>
	<div class="form-style-5 slideInDown animated">
		<div class="alert">
		<label id="alert"></label>
		</div>
		<form method="post" action="">
			
			<fieldset>
				<input type="text" name="email" id="email" placeholder="Enter Email...">
				<input type="password" name="teachid" id="teachid" placeholder="Enter Teacher ID...">
				
			</fieldset>
			
            <input type="submit" name="btn_login" id ="btn_login"  value="Login" style="
  padding: 10px 20px 10px 20px;
  color: #FFF;
  margin: 0 auto;
  background: #388994;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  width: 100%;
  border: 1px solid #3f9aa6;
  border-width: 1px 1px 3px;
  margin-bottom: 10px;
" >
            

		</form>
	</div>

	
</main>
</body>

</html>

<?php
//include('include/home/footer.php');
}
?>