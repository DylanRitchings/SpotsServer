<?php
include 'connect.php';


$spotId = $_GET['spotId'];

//$diffratingid_stmt = $con->prepare('SELECT ratingId FROM userdiffrating WHERE spotId = (?);');
//$diffratingid_stmt->bind_param('d',$spotId);
//$diffratingid_stmt->execute();
//$diffratingid_stmt->bind_result($diffRatingId);
//$diffratingid_stmt->fetch();
////$diffrating_stmt = $con->prepare('SELECT rating FROM diffrating WHERE ratingId = (?);');
////$diffrating_stmt->bind_param('i',$diffRatingId);
////$diffrating_stmt->execute();
//$diffrating_stmt->fetch();

//$con->commit();
//
//$diffRatings = array();
//
//while($row = mysqli_fetch_assoc($res))
//{
//    $diffRatings[]=$row;
//}
//print(json_encode($output));

//$con->begin_transaction();
//
//$hostratingid_stmt = $con->prepare('SELECT ratingId FROM userhostrating WHERE spotId = (?);');
//$hostratingid_stmt->bind_param('d',$spotId);
//$hostratingid_stmt->execute();
//$hostratingid_stmt->bind_result($hostRatingId);
//$hostratingid_stmt->fetch();
////
////$hostrating_stmt = $con->prepare('SELECT rating FROM hostrating WHERE ratingId = (?);');
////$hostrating_stmt->bind_param('i',$hostRatingId);
////$hostrating_stmt->execute();
////$hostrating_stmt->fetch();


//SELECT D.rating, H.rating FROM  diffrating D join userdiffrating UD ON D.primarykey = UD.foreignkey
//                                  join userhostrating ON table2.primarykey = table3.foreignkey

//$ratings_stmt = $con->prepare('SELECT D.rating, H.rating FROM diffrating D, hostrating H WHERE D.ratingId = (?) AND H.ratingId = (?);');
//$ratings_stmt->bind_param('ii',$diffRatingId,$hostRatingId);
//$ratings_stmt = $con->prepare('SELECT D.rating diffrating, H.rating hostrating FROM diffrating D JOIN userdiffrating UD ON D.ratingId = UD.ratingId JOIN userhostrating UH ON UD.spotId = UH.spotId JOIN hostrating H ON UH.ratingId = H.ratingId WHERE UD.spotId = (?)
//;');
//$ratings_stmt->bind_param('i',$spotId);
//
//$ratings_stmt->execute();
//
//
//while($row = mysqli_fetch_assoc($res))
//{
//    $output[]=$row;
//}
//print(json_encode($output));
//
//$con->commit();
//
//$hostRatings = array();
//
//while($row = mysqli_fetch_assoc($res))
//{
//    $hostRatings[]=$row;
//}
//$output = array($diffRatings,$hostRatings);
//echo("Errorcode: " . mysqli_errno($con));
$con->begin_transaction();
$ratings_stmt = $con->prepare('SELECT D.rating rating, "diff" as ratingtype  FROM diffrating D
JOIN userdiffrating UD on D.ratingId = UD.ratingId
WHERE UD.spotId = (?)
UNION 
SELECT H.rating rating, "host" as ratingtype FROM hostrating H
JOIN userhostrating UH on H.ratingId = UH.ratingId
WHERE UH.spotId = (?)');
$ratings_stmt->bind_param('ii',$spotId,$spotId);

$ratings_stmt->execute();
$res = $ratings_stmt->get_result();
$con->commit();

$output = array();
while($row = mysqli_fetch_assoc($res))
{
    $output[]=$row;
}

print(json_encode($output));

mysqli_close($con);
