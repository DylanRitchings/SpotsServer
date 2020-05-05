<?php

include 'connect.php';
$galleryId = mysqli_real_escape_string( $con, $_POST['galleryId']);
$imageId = mysqli_real_escape_string( $con, $_POST['imageId']);
$fileType = mysqli_real_escape_string( $con, $_POST['fileType']);

$con->begin_transaction();
$gallery_stmt = $con->prepare('INSERT INTO gallery (`galleryId`,`imageId`,`fileType`) VALUES (?,?,?)');
$gallery_stmt->bind_param('sss', $galleryId, $imageId,$fileType);
$gallery_stmt->execute();
$con->commit();

mysqli_close($con);