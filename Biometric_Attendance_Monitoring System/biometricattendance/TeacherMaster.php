	
<?php
$id='';
$name = '';
$gender = '';
$email = '';
$dept = '';
$sub = '';
$tid='';
$timein='';
$sql = '';
$grid = '';
$rs = '';
$msg = '';
$data = '';

include('connectDB.php'); // Connection

if($_POST)
{
	if(isset($_POST['oper']))
	{
		if(isset($_POST['txt_id']))
		{
			$id = $_POST['txt_id'];
		}
		if(isset($_POST['name']))
		{
			$name = $_POST['name'];
		}
		if(isset($_POST['gender']))
		{
			$gender = $_POST['gender'];
		}
		
		if(isset($_POST['dept']))
		{
			$dept = $_POST['dept'];
		}
		
		if(isset($_POST['sub']))
		{
			$sub = $_POST['sub'];
		}
		if(isset($_POST['email']))
		{
			$email = $_POST['email'];
		}

		if(isset($_POST['teachid']))
		{
			$tid = $_POST['teachid'];
		}

		if(isset($_POST['timein']))
		{
			$timein = $_POST['timein'];
		}
		
		
		if($_POST['oper']=='grid')
		{

		} // End if Condition Grid

		else if($_POST['oper']=='insert')
		{
			$sql = "insert into teachers (username, gender, email, department, subjects, teacher_id,time_in) values ('$name','$gender','$email','$dept','$sub','$tid','$timein')";
			mysqli_query($conn,$sql);
			echo $sql;
		} // End if Condition Insert

		else if($_POST['oper']=='update')
		{
			$sql = "update teachers set email ='$email',gender ='$gender',department ='$dept',teacher_id ='$tid',username ='$name',subjects ='$sub',time_in ='$timein' where  id = $id";
			mysqli_query($conn,$sql);
			echo $sql;
		} // End if Condition Update

		else if($_POST['oper']=='delete')
		{
			$sql = "update teachers set del_teacherid=1 where id = $id";
			//echo $sql;
			mysqli_query($conn,$sql);
			
		} // End if Condition Delete (Logically Delete Not Physically)

		else if($_POST['oper']=='search')
		{

			$sql="select * from teachers where id=".$id;
			$rs=mysqli_query($conn,$sql);
			//echo $sql;
			if(!$rs){					
				echo '0';
			}
			else{
				if($row=mysqli_fetch_assoc($rs)){		
					$id = $row['id'];
					$name = $row['username'];
					$gender = $row['gender'];
					$dept = $row['department'];
					$tid = $row['teacher_id'];
					$sub = $row['subjects'];
					$timein = $row['time_in'];
					

					$data = array('id' => $row['id'],'email' => $row['email'],'name' => $row['username'],'dept' => $row['department'],'tid' => $row['teacher_id'],'sub' => $row['subjects'],'gender' => $row['gender'], 'timein' => $row['time_in']);
					echo json_encode($data);				
				}
			}

		} // End if Condition Search

	} // End if Condition Oper

} // End if Condition $_POST

else{

include('header.php');
?>

<style>
.myRec{
	color:#49BF4C;
	cursor:pointer;
}
.myRec:hover{
}
</style>


<!-- Start JavaScript -->

<script lang="javascript" type="text/javascript">

function searchRecord(id)
{	
	//alert("hi");
	var recid = $('#'+id).attr('recid');
	
	$.ajax({

		url:"TeacherMaster.php",
		type:"post",
		data:{'oper':'search','txt_id':recid},
		
		success: function (response) {	
	//alert(response);
			if(response!='0')
			{
				
				var data = JSON.parse(response);
				
				$('#txt_id').val(data.id);
				$('#name').val(data.name);
				$('#gender').val(data.gender);
				$('#dept').val(data.dept);
				$('#teachid').val(data.tid);
				$('#email').val(data.email);
				$('#sub').val(data.sub);
				$('#timein').val(data.timein);
													
				$('#btn_save').val('Update Teacher');
			}
			else
			{
				alert("Record Not Found.");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("Record Not Found.");
		}

	}); // End Ajax

} // End Search Record


$('document').ready(function(){
	
//	fillGrid(); // Call Internal Function
	//alert('hi');
	
	$('#btn_delete').click(function(){

		if($('#txt_id').val()!="")
		{
			if(confirm("Do you want to Delete?"))
			{
				$.ajax({
					url:"TeacherMaster.php",
					type:"post",
					data:{'oper':'delete','txt_id':$('#txt_id').val()},
					success: function (response) {							   
						//fillGrid();
						alert("Record Deleted Successfully.");
						window.location = "TeacherMaster.php";
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   alert("Record Not Deleted Successfully.");
					}

				}); // End Ajax

			} // End 2nd if Condition

			clearControl(); // Call Internal Function

		} // End 1st if Condition 
		else
		{
			alert("Please Select a Record");
		}		 	

	}); // End Button Delete Click Function

	$('#btn_save').click(function(){

			//alert("hi2");
		if(valCheck()==true)
		{			
			//alert("hiiiii");

			if($('#btn_save').val()=="SAVE")
			{
				var gender = $(".gender:checked").val();
				//alert(gender);
				$.ajax({
					url:"TeacherMaster.php",
					type:"post",
					data:{'oper':'insert','sub':$('#sub').val(),'teachid':$('#teachid').val(),'name':$('#name').val(),'gender':gender,'timein':$('#timein').val(),'dept':$('#dept').val(),'email':$('#email').val()},
					success: function (response) {	
						//alert(response);
						//fillGrid();
						alert("Record Saved Successfully.");
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   alert("Record Not Saved Successfully.");
					}

				}); // End Ajax
				
			} // End 2nd if Condition
			else
			{					var gender = $(".gender:checked").val();

				
				$.ajax({


					url:"TeacherMaster.php",
					type:"post",
					data:{'oper':'update','txt_id':$('#txt_id').val(),'name':$('#name').val(),'gender':gender,'dept':$('#dept').val(),'sub':$('#sub').val(),'teachid':$('#teachid').val(),'email':$('#email').val(),'timein':$('#timein').val()},
					success: function (response) {	
					alert(response);
					
						//fillGrid();									
						alert("Record Update Successfully.");
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   alert("Record Not Update Successfully.");
					}

				}); // End Ajax

			} // End else
			window.location = "TeacherMaster.php";
			clearControl(); // Call Internal Function

		} // End 1st if Condiotion

	}); // End Button Save and Update Click Function

	

}); // End Ready


function valCheck()
{
	var b = false;
	

	if($('#name').val()=="")
	{
		alert("Please Enter name...");
		$('#name').focus();
	}

	if($('#gender').val()=="")
	{
		alert("Please Select Gender...");
		$('#gender').focus();
	}
	
	if($('#email').val()=="")
	{
		alert("Please Enter Email...");
		$('#email').focus();
	}
	if($('#dept').val()=="")
	{
		alert("Please Select Department...");
		$('#dept').focus();
	}
	if($('#sub').val()=="")
	{
		alert("Please Enter Subjects...");
		$('#sub').focus();
	}
	if($('#teachid').val()=="")
	{
		alert("Please Enter Teacher ID...");
		$('#teachid').focus();
	}

	if($('#timein').val()=="")
	{
		alert("Please Select In Time...");
		$('#timein').focus();
	}
	
	

	else
	{
		b = true;
	}
	return b;

} // End ValCheck Function
	
	function validateemail()  
	{  
	var x=$('#txt_email').val();  
	var atposition=x.indexOf("@");  
	var dotposition=x.lastIndexOf(".");  
	if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length){  
	  alert("Please enter a valid e-mail address");  
	  return false;  
	  }  
	}


</script>

<!DOCTYPE html>
<html>
<head>
	<title>Teacher Registration Form</title>
<link rel="stylesheet" type="text/css" href="css/manageusers.css">
<style>
	.form-style-5{
  height: 850px;
}
</style>

</head>
<body>
<main>
	<h1 class="slideInDown animated">Add a new Teacher or update his information <br> or remove him</h1>
	<div class="form-style-5 slideInDown animated">
		<div class="alert">
		<label id="alert"></label>
		</div>
		<form type="post" action="">
			<fieldset>
			<legend><span class="number">1</span> Add Teacher ID:</legend>
			<input type="number" name="txt_id" id="txt_id" placeholder="ID..." hidden>

				<input type="number" name="teachid" id="teachid" placeholder="Teacher ID...">
			</fieldset>
			<fieldset>
				<legend><span class="number">2</span> Teacher Info</legend>
				<input type="text" name="name" id="name" placeholder="Teacher Name...">
				<input type="email" name="email" id="email" placeholder="Teacher Email...">
				<select name="dept" id="dept">
					<option value="sel">Select Department</option>
  <option value="comp">Computer Scienece</option>
  <option value="civil">Civil</option>
  <option value="elec">Electricals</option>
  <option value="mech">Mechanical</option>
  <option value="entc">Electronics $ Telecommunications</option>
</select>
<textarea name="sub" id="sub" cols="5" rows="3" placeholder="Enter subject here..."></textarea>

			</fieldset>
			<fieldset>
			<legend><span class="number">3</span> Additional Info</legend>
			<label>
				Time In:
				<input type="time" name="timein" id="timein">
				<input type="radio" name="gender" class="gender" value="Female">Female
	          	<input type="radio" name="gender" class="gender" value="Male" checked="checked">Male
	      	</label >
			</fieldset>
			<button type="button" id="btn_save" name="btn_save" value="SAVE">Add Teacher</button>

			<button type="button" name="btn_delete" id="btn_delete" value="Delete">Remove Teacher</button>
		</form>
	</div>

	<div class="section">
	<!--User table-->
		<div class="tbl-header slideInRight animated">
		    <table cellpadding="0" cellspacing="0" border="0">
		      <thead>
		        <tr>
	        	  <th>ID</th>
				  <th>Teacher ID</th>
		          <th>Name</th>
		          <th>Gender</th>
				  <th>Dept</th>
  				<th>Sub</th>
		          <th>Date</th>
		          <th>Time in</th>
		        </tr>
		      </thead>
		    </table>
		</div>
		<div class="tbl-content slideInRight animated">
		<table cellpadding="0" cellspacing="0" border="0">
<tbody>
<?php
  //Connect to database
  require'connectDB.php';

    $sql = "SELECT * FROM teachers WHERE del_teacherid=0 ORDER BY id DESC";
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
              	<TD><?php  
                		
                    $teachid = $row['teacher_id'];
					$id = $row['id'];
                	?>
                	<form>
					<!-- $grid.="<td class=' text-center'><div id='id_".$row['id']."' class='myRec' recid='".$row['id']."' onClick='searchRecord(this.id);'>Select</div></td>"; -->

                		<button type="button" class="select_btn" recid="<?php echo $id;?>" onClick='searchRecord(this.id);' id="<?php echo $id;?>" title="select this TID"><?php echo $id;?></button>
                	</form>
                </TD>
				<TD><?php echo $row['teacher_id'];?></TD>

              <TD><?php echo $row['username'];?></TD>
              <TD><?php echo $row['gender'];?></TD>
              <TD><?php echo $row['department'];?></TD>
              <TD><?php echo $row['subjects'];?></TD>

              <TD><?php echo $row['user_date'];?></TD>
              <TD><?php echo $row['time_in'];?></TD>
              </TR>
<?php
        }   
    }
  }
?>
</tbody>
</table>
		</div>
	</div>

</main>
</body>
</html>

<?php
}
?>