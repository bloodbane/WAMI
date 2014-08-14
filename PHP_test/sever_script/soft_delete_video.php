<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/13/14
 * Time: 6:49 PM
 */

$response = array();
require_once __DIR__ . '/db_connect.php';
$user_id = $_POST["user_id"];
$videos = $_POST["videos"];
//$videos = explode(",", $filename);

$db = new DB_CONNECT();
$con = $db->connect() or die('Could not connect: ' . mysql_error());
$con->autocommit(FALSE);


$sql="UPDATE `wami`.`identity_profiler` SET `delete_ind` = '1' WHERE `identity_profiler`.`identity_profiler_id` IN (". $videos.")";

$result = mysqli_query($con,$sql);

if (!$result) {
    $response["message"] = "soft_delete_video: Problem delete picture for " .$username. " MySQL Error: " .mysqli_error($con);
    $response["ret_code"] = -1;
    $con->rollback();
    $con->autocommit(TRUE);
    echo json_encode($response);
    exit(-1);
}

$con->commit();
$con->autocommit(TRUE);
$response["ret_code"] = 0;
$response["message"] = "Sucessfully deleted the selected videos. ";
echo json_encode($response);
?>