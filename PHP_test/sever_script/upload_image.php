<?php
/**
 * Input username, query user_id from user table.
 * Insert new row into identity_profiler, required fields:
 * profile_id, image_name, description
 *
 * Auto generated fields:
 * user_id: from user table,
 * category: Pictures
 * media_type: Picture
 * file_type: $_FILE
 * profiler_url: /wami/profilerdata/'. username .'/pic/'. filename
 * delete_ind: 0 (not deleted)
 * create_date: upload time;
 * modified_date: upload time
 */

function make_thumb($ext, $src, $dest, $desired_width){
    if($ext=="jpeg" || $ext=="jpg"){
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width / $width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        imagejpeg($virtual_image, $dest,100);
    }else{
        $source_image = imagecreatefrompng($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width/$width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagealphablending($virtual_image, false);
        imagesavealpha($virtual_image, true);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        imagepng($virtual_image, $dest, 0);
    }
}

function get_userid($name, $con){
    $query = "SELECT `user_id` FROM `user` WHERE `user_name`='".$name."'";
    if(!mysqli_query($con, $query) || !mysqli_fetch_array(mysqli_query($con, $query))){
        return -1;
    }else{
        return mysqli_fetch_array(mysqli_query($con, $query))['user_id'];
    }
}

function storeImage($url, $dest, $filename){
    if(file_exists($dest.$filename)){
        return true;
    }
    $image = strstr($url, ',');
    $image = substr($image, 1);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);
    file_put_contents($dest.$filename, $data);
    return false;
}



$response = array();
require_once __DIR__ . '/db_connect.php';
$username = $_POST['username'];
$profileid = $_POST['profileid'];
$title = $_POST['title'];
$descrip = $_POST['descrip'];
$date = NOW();


$filename = $_POST['filename'];
$filetype = end(explode(".", $filename));
$allowedExts = array("png", "jpg", "jpeg");
$folder = "../profilerdata/" .$username."/pic/";
$dataurl = $_POST['image_src'];

// Connect to MySQL
$db = new DB_CONNECT();
$con = $db->connect();
$con->autocommit(FALSE);

$userid = get_userid($username, $con);
if($userid == -1){
    $msg = $username . ' does not exist!';
    die();
}

if(storeImage($dataurl, $folder, $filename)){
    $msg = 'File('. $filename . ') already exists!';
    die();
}

$query = "INSERT INTO `identity_profiler`(`user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `description`, `delete_ind`, `create_date`, `modified_date`)
								VALUES ('".$userid."','".$profileid."','Pictures','Picture','".$filetype."','".$folder . $title."','".$imagename."','".$descrip."', 0, ".$date.",'".$date."')";
mysqli_query($con, $query);
$src = $folder . $filename;
$dest = $folder . "thumb/" . $filename;
$width = 282;
make_thumb($filetype, $src, $dest, $width);

$response["ret_code"] = 0;
$response["message"] = "New profile image saved. ";
echo json_encode($response);
echo "wokr?";
?>
