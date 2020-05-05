<?php
include 'connect.php';

$con->begin_transaction();
$spots_stmt = $con->prepare('SELECT * FROM spots;');
$spots_stmt->execute();
$res = $spots_stmt->get_result();
$con->commit();

$output = array();

while($row = mysqli_fetch_assoc($res))
	{
		$output[]=$row;
	}
	print(json_encode($output));

//if($result = mysqli_query($con,$sql)){
//	while($row = mysqli_fetch_assoc($result))
//	{
//		$output[]=$row;
//	}
//	print(json_encode($output));
//}
//else{
//	echo 'Try Again';
//	echo "Error: Unable to connect to MySQL." . PHP_EOL;
//	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//}

mysqli_close($con);