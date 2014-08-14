<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/13/14
 * Time: 7:07 PM
 */
/*
function get_userid($name, $con){
    $query = "SELECT `user_id` FROM `user` WHERE `username`='".$name."'";
    if(!mysqli_query($con, $query) || !mysqli_fetch_array(mysqli_query($con, $query))){
        return -1;
    }else{
        return mysqli_fetch_array(mysqli_query($con, $query))['user_id'];
    }
}

function storeVideo($video, $dest, $filename){
    $dest= "..".$dest;

    if(file_exists($dest.$filename)){
        return false;
    }
    move_uploaded_file($video["tmp_name"], $dest . $video["name"]);


}

function replaceVideo( $dest, $filename, $con, $userid, $profileid){
    $dest= "..".$dest;

    $sql="SELECT * FROM `identity_profiler` WHERE (`user_id` = ".$userid." AND " .
        "`profile_id` = ". $profileid . " AND "."`file_name`='".$filename."')";

    $result = mysqli_query($con,$sql);
    $del_video = "";
    while($row = mysqli_fetch_array($result)){
        $del_video = $del_video . $row['identity_profiler_id'].",";
    }
    $del_video = substr($del_video,0, strlen($del_video)-1);

    $sql = "UPDATE `wami`.`identity_profiler` SET `delete_ind` = '2' WHERE `identity_profiler`.`identity_profiler_id` IN (". $del_video.")";
    $result = mysqli_query($con,$sql);

    if (!$result) {
        $response["message"] = "upload_video: Problem replace picture, MySQL Error: " .mysqli_error($con);
        $response["ret_code"] = -1;
        $con->rollback();
        $con->autocommit(TRUE);
        echo json_encode($response);
        exit(-1);
    }

    move_uploaded_file($_FILES["file"]["tmp_name"], $dest . $_FILES["file"]["name"]);

}

$response = array();
require_once __DIR__ . '/db_connect.php';

//print_r($_POST);

if(isset($_POST['username'])){
    $username = $_POST['username'];
}else{
    echo "don't recieve username";
}

echo 'file count=', count($_FILES),"\n";
var_dump($_FILES);
echo "\n";

$video = $_FILES["file"];

$profileid = $_POST['profileid'];

if(isset($_POST['title'])){
    $title = $_POST['title'];
}else{
    $title = "";
}
if(isset($_POST['description'])){
    $description = $_POST['description'];
}else{
    $description = "";
}
if(isset($_POST['replace'])){
    $replace = $_POST['replace'];
}else{
    $replace = false;
}

$date = date("Y-m-d H:i:s");


$filename = $_POST['filename'];
$filetype = end(explode(".", $filename));
$allowedExts = array("mp4", "m4v");
$folder = "/profilerdata/" .$username."/".$profileid."/video/";

// Connect to MySQL
$db = new DB_CONNECT();
$con = $db->connect();

$userid = get_userid($username, $con);
if($userid == -1){
    $response["ret_code"] = -1;
    $response["message"] = $username . ' does not exist!';
    echo json_encode($response);
    exit(-1);
}

if($replace){
    replaceVideo($video, $folder, $filename, $con, $userid, $profileid);
}else{
    if(!storeVideo($video, $folder, $filename)){
        $response["ret_code"] = -1;
        $response["message"] = 'File('. $filename . ') already exists!';
        echo json_encode($response);
        exit(-1);
    }
}


$url = $folder.$filename;
$sql = "INSERT INTO `identity_profiler`(`user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `file_name`,`description`, `delete_ind`, `create_date`, `modified_date`)
								VALUES ('".$userid."','".$profileid."','Videos','Video','mp4','".$url."','".$title."','".$filename."','".$description."', 0, '".$date."','".$date."')";

$result = mysqli_query($con, $sql) or die(mysqli_error($con));
if (!$result) {
    $response["ret_code"] = -1;
    $response["message"] = "upload_video.php: Problem updating identity_profile table. MySQL Error: " .mysqli_error($con);
    echo json_encode($response);
    exit(-1);
}



$response["ret_code"] = 0;
$response["message"] = "New profile video saved. ";
echo json_encode($response);
*/
echo "Upload: " . $_FILES["file"]["name"] . "<br>";
echo "Type: " . $_FILES["file"]["type"] . "<br>";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "Stored in: " . $_FILES["file"]["tmp_name"];
?>