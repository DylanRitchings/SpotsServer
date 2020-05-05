<?php
include 'connect.php';

$userId = mysqli_real_escape_string( $con, $_POST['userId']);
$spotId = $_POST['spotId'];
$rating = (int) $_POST['rating'];

$con->begin_transaction();

$check_stmt = $con->prepare('SELECT ratingId FROM userhostrating WHERE `userId` = (?) AND `spotId` = (?)');
$check_stmt -> bind_param('si',$userId,$spotId);
$check_stmt->execute();
//$check_stmt->bind_result($check);
$con->commit();
$check = mysqli_fetch_assoc($check_stmt->get_result());
$ratingId = $check['ratingId'];

if (is_null($ratingId) ) {

    $hostrating_stmt = $con->prepare('INSERT INTO hostrating (`rating`) VALUES (?)');
    $hostrating_stmt->bind_param('d',$rating);
    $hostrating_stmt->execute();

    $hostRatingId = $hostrating_stmt->insert_id;

    $userhostrating_stmt = $con->prepare('INSERT INTO userhostrating (`ratingId`,`userId`,`spotId`) VALUES (?,?,?)');
    $userhostrating_stmt->bind_param('isi', $hostRatingId, $userId, $spotId);
    $userhostrating_stmt->execute();
}
else{
    $ratingIdInt = (float) $ratingId;
    // print (json_encode($ratingIdInt));
    $hostrating_stmt = $con->prepare('UPDATE hostrating SET `rating` = (?) WHERE `ratingId`= (?)');
    $hostrating_stmt->bind_param('di',$rating,$ratingIdInt);
    $hostrating_stmt->execute();

//    $hostRatingId = $hostrating_stmt->insert_id;
}


$con->commit();
mysqli_close($con);

