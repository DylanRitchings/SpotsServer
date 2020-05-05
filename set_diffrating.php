<?php
include 'connect.php';

$userId = mysqli_real_escape_string( $con, $_POST['userId']);
$spotId = $_POST['spotId'];
$rating = (int) $_POST['rating'];

$con->begin_transaction();

$check_stmt = $con->prepare('SELECT ratingId FROM userdiffrating WHERE `userId` = (?) AND `spotId` = (?)');
$check_stmt -> bind_param('si',$userId,$spotId);
$check_stmt->execute();
//$check_stmt->bind_result($check);
$con->commit();
$check = mysqli_fetch_assoc($check_stmt->get_result());
$ratingId = $check['ratingId'];

if (is_null($ratingId) ) {

    $diffrating_stmt = $con->prepare('INSERT INTO diffrating (`rating`) VALUES (?)');
    $diffrating_stmt->bind_param('d',$rating);
    $diffrating_stmt->execute();

    $diffRatingId = $diffrating_stmt->insert_id;

    $userdiffrating_stmt = $con->prepare('INSERT INTO userdiffrating (`ratingId`,`userId`,`spotId`) VALUES (?,?,?)');
    $userdiffrating_stmt->bind_param('isi', $diffRatingId, $userId, $spotId);
    $userdiffrating_stmt->execute();
}
else{
    $ratingIdInt = (float) $ratingId;
   // print (json_encode($ratingIdInt));
    $diffrating_stmt = $con->prepare('UPDATE diffrating SET `rating` = (?) WHERE `ratingId`= (?)');
    $diffrating_stmt->bind_param('di',$rating,$ratingIdInt);
    $diffrating_stmt->execute();

//    $diffRatingId = $diffrating_stmt->insert_id;
}


$con->commit();
mysqli_close($con);
