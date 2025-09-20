<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ลลิตภัทร เข็มพิมาย(น้าขิง)</title>
</head>

<body>
<h1>เพิ่มข้อมูลนิสิต -- ลลิตภัทร เข็มพิมาย(น้าขิง)</h1>
<form method="post" action="">
รหัสนิสิต<input type="text" name="sid" autofocus required><br>
ชื่อนิสิต<input type="text" name="sname" required><br>
ที่อยู่<br>
<textarea name="saddress"></textarea><br>
เกรดเฉลี่ย<input type="text" name="sgpax" required><br>


<select name="fid">
<?php
	include("connectdb.php");
	$sql2="SELECT * FROM faculty";
	$rs2=mysqli_query($conn,$sql2);
	while($data2=mysqli_fetch_array($rs2)){
	?>	
<option value="<?php echo $data2['f_id'];?>"><?php echo $data2['F_name'];?></option><?php } ?>
</select>
<br><br>
<button type="submit" name="Submit">บันทึก</button>
</form>
<hr>

<?php
if(isset($_POST['Submit'])){
	include("connectdb.php");
	$sid=$_POST['sid'];
	$sname=$_POST['sname'];
	$saddress=$_POST['saddress'];
	$sgpax=$_POST['sgpax'];
	$fid=$_POST['fid'];
	$sql="insert into student(s_id,s_name,s_address,s_gpax,f_id) values('{$sid}','{$sname}','{$saddress}','{$sgpax}','{f_id}');";
	mysqli_query($conn,$sql)or die ("insert error");
	
	echo"<script>";
	echo "alert('บันทึกข้อมูล');";
	echo "window.location='select_student.php';";
	echo"</script>";
	}
?>


</body>
</html>