<?php

include 'connect.php';

$userId = mysqli_real_escape_string( $con, $_POST['userId']);
$desc = mysqli_real_escape_string($con, $_POST['desc']);
$lat = (float) $_POST['lat'];
$lng = (float) $_POST['lng'];
$type = mysqli_real_escape_string($con, $_POST['type']);
$difficulty = (int) $_POST['difficulty'];
$hostility = (int) $_POST['hostility'];
$galleryId = mysqli_real_escape_string( $con, $_POST['galleryId']);
$imageId = mysqli_real_escape_string( $con, $_POST['imageId']);
//$spotId = null;


$con->begin_transaction();

$spots_stmt = $con->prepare('INSERT INTO spots (`userId`,`desc`,`lat`,`lng`,`type`,`galleryId`) VALUES (?,?,?,?,?,?)');
$spots_stmt->bind_param('ssddss', $userId, $desc, $lat, $lng, $type, $galleryId);
$spots_stmt->execute();

$spotId = $spots_stmt->insert_id;

//difficulty rating
$diffrating_stmt = $con->prepare('INSERT INTO diffrating (`rating`) VALUES (?);');
$diffrating_stmt->bind_param('d',$difficulty);
$diffrating_stmt->execute();

$diffRatingId = $diffrating_stmt->insert_id;

$userdiffrating_stmt = $con->prepare('INSERT INTO userdiffrating (`ratingId`,`userId`,`spotId`) VALUES (?,?,?)');
$userdiffrating_stmt->bind_param('isi', $diffRatingId, $userId, $spotId);
$userdiffrating_stmt->execute();

//hostility rating
$hostrating_stmt = $con->prepare('INSERT INTO hostrating (`rating`) VALUES (?);');
$hostrating_stmt->bind_param('d',$hostility);
$hostrating_stmt->execute();

$hostRatingId = $hostrating_stmt->insert_id;

$userhostrating_stmt = $con->prepare('INSERT INTO userhostrating (`ratingId`,`userId`,`spotId`) VALUES (?,?,?)');
$userhostrating_stmt->bind_param('isi', $hostRatingId, $userId, $spotId);
$userhostrating_stmt->execute();

//$gallery_stmt = $con->prepare('INSERT INTO gallery (`galleryId`,`imageId`) VALUES (?,?,?)');
//$gallery_stmt->bind_param('ss', $galleryId, $imageId,"img");
//$gallery_stmt->execute();

$con->commit();

mysqli_close($con);