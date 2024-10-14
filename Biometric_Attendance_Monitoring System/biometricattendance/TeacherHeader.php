
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/header.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<header>
<div class="header">
	<div class="logo">
		<a >Biometric Attendance</a>
	</div>
</div>

<div class="topnav" id="myTopnav">
	<a href="SubjectwiseUsers.php">Users</a>
    <a href="UsersLog.php">Users Log</a>
	<a href="AttendanceReport.php">Attendance Report</a>

    <a href="index.php">Logout</a>
    

    <a href="javascript:void(0);" class="icon" onclick="navFunction()">
	  <i class="fa fa-bars"></i></a>
</div>
</header>
<script>
	function navFunction() {
	  var x = document.getElementById("myTopnav");
	  if (x.className === "topnav") {
	    x.className += " responsive";
	  } else {
	    x.className = "topnav";
	  }
	}
</script>


	

	
