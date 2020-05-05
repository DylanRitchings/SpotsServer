<?php

include 'connect.php';

$userId = $_POST['userId'];
$desc = $_POST['desc'];
$lat = (float) $_POST['lat'];
$lng = (float) $_POST['lng'];
$type = $_POST['type'];
$difficulty = (int) $_POST['difficulty'];
$hostility = (int) $_POST['hostility'];
$spotId = null;
// upload spot

$sql = "BEGIN; 
    INSERT INTO spots (`userId`,`desc`,`lat`,`lng`,`type`) VALUES ('$userId','$desc','$lat','$lng','$type');
    SET $spotId = LAST_INSERT_ID();
    INSERT INTO diffrating (`rating`) VALUES ('$difficulty');
    INSERT INTO userdiffrating (`ratingId`,`userId`,`spotId`) VALUES (LAST_INSERT_ID(),'$userId','$spotId');
    INSERT INTO hostrating (`rating`) VALUES ('$hostility');
    INSERT INTO userhostrating (`ratingId`,`userId`,`spotId`) VALUES (LAST_INSERT_ID(),'$userId','$spotId');
    COMMIT;";


//echo $sql;
if(mysqli_query($con,$sql)){
    echo("Spot uploaded successfully.");
}
else{

    echo 'Try Again';
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    echo $spotId;
    echo("Error description: " . mysqli_error($con));
    exit;

}

