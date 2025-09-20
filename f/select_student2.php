<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ลลิตภัทร เข็มพิมาย(น้าขิง)</title>
</head>

<body>
<h1>แสดงข้อมูลนิสิต -- ลลิตภัทร เข็มพิมาย(น้าขิง)</h1>

<form method="post" action="">
คำค้น<input type="text" name="k" autofocus>
<button type="submit" name="Submit">ค้นหา</button>
</form>
<hr>

<?php
$k=@$_POST['k'];
include("connectdb.php");
$sql="select*from student as s
inner join faculty as f
on s.f_id=f.f_id
where (s.s_name like '%{$k}%' or s.s_id like '%{$k}%' or s.s_address like '%{$k}%' or f.f_name like '%{$k}%'  ) ";
$rs=mysqli_query($conn,$sql);
while ($data=mysqli_fetch_array($rs)){
	echo "<img src='http://202.28.32.211/picture/student/67/{$data['s_id']}.jpg' width='260'><br>";
	echo $data['s_id']."<br>";
	echo $data['s_name']."<br>";
	echo $data['s_address']."<br>";
	echo $data['s_gpax']."<br>";
	echo $data['F_name']."<hr>";
	}
mysqli_close($conn);
?>


</body>
</html>