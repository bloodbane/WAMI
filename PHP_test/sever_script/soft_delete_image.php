<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/9/14
 * Time: 10:20 PM
 */
$response = array();
require_once __DIR__ . '/db_connect.php';
$user_id = $_POST["user_id"];
$images = $_POST["images"];
//$images = explode(",", $filename);

$db = new DB_CONNECT();
$con = $db->connect() or die('Could not connect: ' . mysql_error());
$con->autocommit(FALSE);


$sql="UPDATE `wami`.`identity_profiler` SET `delete_ind` = '1' WHERE `identity_profiler`.`identity_profiler_id` IN (". $images.")";

$result = mysqli_query($con,$sql) or die(mysqli_error($con));

if (!$result) {
    $response["message"] = "soft_delete_image: Problem creating default profile: " .$username. " MySQL Error: " .mysqli_error($con);
    $response["ret_code"] = -1;
    $con->rollback();
    $con->autocommit(TRUE);
    echo json_encode($response);
    exit(-1);
}

$con->commit();
$con->autocommit(TRUE);
$response["ret_code"] = 0;
$response["message"] = "Sucessfully deleted the selected images. ";
echo json_encode($response);

?>