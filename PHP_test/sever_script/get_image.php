<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 7/10/14
 * Time: 3:15 PM
 */

$response = array();
require_once __DIR__ . '/db_connect.php';
$user_id= $_POST["user_id"];

$db = new DB_CONNECT();
$con = $db->connect() or die('Could not connect: ' . mysql_error());
$con->autocommit(FALSE);


try {
    $sql="SELECT * FROM identity_profiler WHERE user_id = ".$user_id;
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
    if (!$result) {
        $response["message"] = "get_image: Problem get image: " .$username. " MySQL Error: " .mysqli_error($con);
        $response["result"] = null;
        $con->rollback();
        $con->autocommit(TRUE);
        echo json_encode($response);
        exit(-1);
    }


}catch (Exception $e){
    $response["result"] = null;
    $response["message"] = "get_image.php: Transaction failed: " . $e->getMessage();
    $con->rollback();
    $con->autocommit(TRUE);
    echo json_encode($response);
    return;
}

//$con->commit();
//$con->autocommit(TRUE);

$image_batch=array();
$image=array();
while($row = mysqli_fetch_array($result)) {
    $image["image_url"]=$row['profiler_url'];
    $image["thumb_url"]=$row['preview_url'];
    array_push($image_batch,$image);
}

$response["result"] = $image_batch;
$response["message"] = "Fetched the image url. ";
echo json_encode($response);
?>