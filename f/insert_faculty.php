<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ลลิตภัทร เข็มพิมาย(น้าขิง)</title>
</head>

<body>
<h1>เพิ่มข้อมูลคณะ -- ลลิตภัทร เข็มพิมาย(น้าขิง)</h1>
<form method="post" action="">
ชื่อคณะ<input type="text" name="fname" autofocus required>
<button type="submit" name="Submit">บันทึก</button>
</form>
<hr>

<?php
if(isset($_POST['Submit'])){
	include("connectdb.php");
	$fname=$_POST['fname'];
	$sql="insert into faculty values(null,'{$fname}');";
	mysqli_query($conn,$sql)or die ("inser error");
	
	echo"<script>";
	echo "alert('บันทึกข้อมูล');";
	echo"</script>";
	}
?>

<?php
include("connectdb.php");
$sql="select*from faculty ";
$rs=mysqli_query($conn,$sql);
while ($data=mysqli_fetch_array($rs)){
	echo $data['f_id']."<br>";
	echo $data['F_name']."<br>";
	echo "<a href='delete_faculty.php?fid={$data['f_id']}' onClick='return confirm(\"ยืนยันการลบ?\")'>ลบ</a><hr>";
	}
mysqli_close($conn);

?>

</body>
</html>