<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 7/10/14
 * Time: 3:15 PM
 */

$response = array();
require_once __DIR__ . '/db_connect.php';
$user_id = $_POST["user_id"];
$profile_id = $_POST["profileid"];
//$profile_id = $_POST["profileid"];

$db = new DB_CONNECT();
$con = $db->connect() or die('Could not connect: ' . mysql_error());
if (isset($_POST["order"])){

}else{
    $order = "identity_profiler_id DESC";
}

$sql="SELECT * FROM identity_profiler WHERE (user_id = ".$user_id." AND " .
        "profile_id=". $profile_id .") ORDER BY ".$order;
$result = mysqli_query($con,$sql) or die(mysqli_error($con));
if (!$result) {
    $response["message"] = "get_image: Problem get image: " . $username . " MySQL Error: " . mysqli_error($con);
    $response["image_collection"] = null;
    echo json_encode($response);
    exit(-1);
}

//$con->commit();
//$con->autocommit(TRUE);

$response["image_collection"]=array();
$image=array();
while($row = mysqli_fetch_array($result)) {
    $image["image_url"]=$row['profiler_url'];
    $filename = end(explode("/", $image["image_url"]));
    $image["thumb_url"]=str_replace($filename, "thumbs/".$filename, $image["image_url"]);
    $image["title"] = $row['title'];
    $image["description"]=$row['description'];
    array_push($response["image_collection"],$image);
}

$response["ret_code"] = 0;
$response["message"] = "Fetched the image url. ";
echo json_encode($response);
?>