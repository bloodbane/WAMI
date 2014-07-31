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
    $sql = "SELECT `user_id` FROM `user` WHERE `user_name`='".$name."'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if (!$result) {
        return -1;
    }
    return mysqli_fetch_array($result)['user_id'];
}

function storeImage($url, $dest, $filename){
    if(file_exists($dest.$filename)){
        return true;
    }
    $remove_part = explode(",", $url)[0]+",";
    $data = str_replace($remove_part, "", $url);
    $data = str_replace(" ", "+", $data);
    $data = base64_decode($data);
    $ext = end(explode(".", $filename));
    $source = imagecreatefromstring($data);
    if($source){
        imagejpeg($source, $dest.$filename, 100);
        return false;
    }else{
        echo 'An error occurred.';
    }
}

$response = array();
require_once __DIR__ . '/db_connect.php';

$username = $_POST['username'];
$profileid = $_POST['profileid'];
$imagename = $_POST['imagename'];
$descrip = $_POST['descrip'];
$date = date("Y-m-d H:i:s");
$filename = $_POST['filename'];
$temp = explode(".", $filename);
$filetype = end($temp);
$allowedExts = array("png", "jpg", "jpeg");
$folder = "../profilerdata/" . strtolower($username) ."/pic/";
$dataurl = $_POST['dataurl'];

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

$query = "INSERT INTO `identity_profiler`(`user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `image_name`, `description`, `delete_ind`, `create_date`, `modified_date`)
								VALUES ('".$userid."','".$profileid."','Pictures','Picture','".$filetype."','".$folder . $filename."','".$imagename."','".$descrip."', 0, ".$date.",'".$date."')";
mysqli_query($con, $query);
$src = $folder . $filename;
$dest = $folder . "thumb/" . $filename;
$width = 282;
make_thumb($filetype, $src, $dest, $width);
$msg = $filename.' uploaded!';

echo $msg;
?>



<?php
/**
 * save_new_profile_image_data.php
 *
 * Created Byr: Robert Lanter
 * Date: 5/28/14
 * Time: 2:36 PM
 *
 * Saves profile image data
 */
$response = array();
require_once __DIR__ . '/db_connect.php';
$file_name = $_POST["file_name"];
$identity_profile_id = $_POST["identity_profile_id"];
$image_src = $_POST["image_src"];

$db = new DB_CONNECT();
$con = $db->connect();

//get rid of file header then save to file system as a .png
$image = strstr($image_src, ',');
$image = substr($image, 1);
$image = str_replace(' ', '+', $image);
$data = base64_decode($image);
file_put_contents("assets/main_image/" .$file_name, $data);

//get rid of file type extension. File name is saved without the .png.
$file_name = substr($file_name, 0, -4);
$sql = "UPDATE identity_profile SET image_url = '" .$file_name. "', modified_date = NOW()
       WHERE identity_profile_id = " .$identity_profile_id;

$result = mysqli_query($con, $sql) or die(mysqli_error($con));
if (!$result) {
    $response["ret_code"] = -1;
    $response["message"] = "save_new_profile_image_data.php: Problem updating identity_profile table. MySQL Error: " .mysqli_error($con);
    echo json_encode($response);
    exit(-1);
}

$response["ret_code"] = 0;
$response["message"] = "New profile image saved. ";
echo json_encode($response);
?>
