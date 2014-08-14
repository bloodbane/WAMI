<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/13/14
 * Time: 3:46 PM
 */

$response = array();
require_once __DIR__ . '/db_connect.php';
$user_id = $_POST["user_id"];
$profile_id = $_POST["profileid"];
//$profile_id = $_POST["profileid"];

$db = new DB_CONNECT();
$con = $db->connect() or die('Could not connect: ' . mysql_error());
$con->autocommit(FALSE);

if (isset($_POST["order"])){

}else{
    $order = "identity_profiler_id DESC";
}

$sql="SELECT * FROM `identity_profiler` WHERE (`user_id` = ".$user_id." AND " .
    "`profile_id` = ". $profile_id . " AND " . " `delete_ind` = 0 " .
    " AND `category` = 'Videos'" . ") ORDER BY ".$order;
$result = mysqli_query($con,$sql) or die(mysqli_error($con));
if (!$result) {
    $response["message"] = "POST_video: Problem POST video: " . $username . " MySQL Error: " . mysqli_error($con);
    $response["video_collection"] = null;
    echo json_encode($response);
    exit(-1);
}

//$con->commit();
//$con->autocommit(TRUE);

$response["video_collection"]=array();
$video=array();
while($row = mysqli_fetch_array($result)) {
    $video["identity_profiler_id"]=$row["identity_profiler_id"];
    $video["video_url"]=$row['profiler_url'];
    $filename = end(explode("/", $video["video_url"]));
    //$video["thumb_url"]=str_replace($filename, "thumbs/".$filename, $video["video_url"]);
    $video["title"] = $row['title'];
    $video["description"]=$row['description'];
    array_push($response["video_collection"],$video);
}

$response["ret_code"] = 0;
$response["message"] = "Fetched the video url. ";
echo json_encode($response);

?>