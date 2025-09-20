<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ลลิตภัทร เข็มพิมาย(น้าขิง)</title>
</head>

<body>
<h1>แสดงข้อมูลคณะ -- ลลิตภัทร เข็มพิมาย(น้าขิง)</h1>
<?php
include("connectdb.php");
$sql="select*from faculty ";
$rs=mysqli_query($conn,$sql);
while ($data=mysqli_fetch_array($rs)){
	echo $data['f_id']."<br>";
	echo $data['F_name']."<hr>";
	}
mysqli_close($conn);
?>


</body>
</html>