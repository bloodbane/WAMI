<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/14/14
 * Time: 2:21 AM
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
    " AND `category` = 'Audios'" . ") ORDER BY ".$order;
$result = mysqli_query($con,$sql) or die(mysqli_error($con));
if (!$result) {
    $response["message"] = "POST_audio: Problem POST audio: " . $username . " MySQL Error: " . mysqli_error($con);
    $response["audio_collection"] = null;
    echo json_encode($response);
    exit(-1);
}

//$con->commit();
//$con->autocommit(TRUE);

$response["audio_collection"]=array();
$audio=array();
while($row = mysqli_fetch_array($result)) {
    $audio["identity_profiler_id"]=$row["identity_profiler_id"];
    $audio["audio_url"]=$row['profiler_url'];
    $filename = end(explode("/", $audio["audio_url"]));
    //$audio["thumb_url"]=str_replace($filename, "thumbs/".$filename, $audio["audio_url"]);
    $audio["title"] = $row['title'];
    $audio["description"]=$row['description'];
    array_push($response["audio_collection"],$audio);
}

$response["ret_code"] = 0;
$response["message"] = "Fetched the audio url. ";
echo json_encode($response);
?>