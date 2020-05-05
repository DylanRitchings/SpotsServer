<?php
include 'connect.php';

$galleryId = mysqli_real_escape_string( $con, $_GET['galleryId']);
$fileType = 'img';
$con->begin_transaction();
$images_stmt = $con->prepare('SELECT imageId FROM gallery WHERE `galleryId` = (?) AND `fileType` = (?);');
$images_stmt -> bind_param('ss',$galleryId,$fileType);
$images_stmt->execute();
$res = $images_stmt->get_result();
$con->commit();

$output = array();
while ($row = mysqli_fetch_assoc($res)) {
    $output[] = $row;
}


print(json_encode($output));
mysqli_close($con);