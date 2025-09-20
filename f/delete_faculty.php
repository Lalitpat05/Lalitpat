<meta charset="utf-8">
<?php
if(isset($_GET['fid'])){
	include("connectdb.php");
	$sql="delete from faculty where f_id='{$_GET['fid']}' ";
	mysqli_query($conn,$sql)or die ("ลบข้อมูลไม่ได้");
	
	echo"<script>";	
	echo"window.location='insert_faculty.php';";
	echo"</script>";
	}


?>