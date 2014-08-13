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
/*
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
*/
//crop pictures into the same size thumbnail
function createThumbs( $folder, $fname, $pathToThumbs )
{
    $folder = "..".$folder;
    $pathToThumbs= "..".$pathToThumbs;
    $system=explode('.',$fname);

    if (preg_match('/jpg|jpeg/',$system[sizeof($system)-1])){
        $img=imagecreatefromjpeg("{$folder}{$fname}");
    }
    if (preg_match('/png/',$system[sizeof($system)-1])){
        $img=imagecreatefrompng("{$folder}{$fname}");
    }


    //echo "Creating thumbnail for {$fname} <br />";

    // load image and get image size
    $old_w = imagesx($img);
    $old_h = imagesy($img);

    $thumb_w = 320;
    $thumb_h = 280;

    $src_ratio = $old_w/$old_h;
    $thumb_ratio = $thumb_w/$thumb_h;

    //calculate rectangle zone select on src_file
    if ($src_ratio>$thumb_ratio) {
        $new_h = $old_h;
        $new_w = $old_h*$thumb_ratio;
        $crop_x = ($old_w-$new_w)/2;
        $crop_y = 0;
    }
    if ($src_ratio<$thumb_ratio) {
        $new_w = $old_w;
        $new_h = $old_w/$thumb_ratio;
        $crop_x = 0;
        $crop_y = ($old_h-$new_h)/2;
    }
    if ($src_ratio==$thumb_ratio) {
        $new_w = $old_w;
        $new_h = $old_h;
        $crop_x = 0;
        $crop_y = 0;
    }

    // create a new temporary image
    $tmp_img = imagecreatetruecolor( $thumb_w, $thumb_h );

    if (preg_match('/jpg|jpeg/',$system[sizeof($system)-1])){
        imagecopyresampled($tmp_img, $img, 0, 0, $crop_x, $crop_y, $thumb_w, $thumb_h, $new_w, $new_h);
        imagejpeg($tmp_img, "{$pathToThumbs}{$fname}", 100);
    }
    if (preg_match('/png/',$system[sizeof($system)-1])){
        imagealphablending($tmp_img, false);
        imagesavealpha($tmp_img, true);
        imagecopyresampled($tmp_img, $img, 0, 0, $crop_x, $crop_y, $thumb_w, $thumb_h, $new_w, $new_h);
        imagepng($tmp_img, "{$pathToThumbs}{$fname}", 0);
    }
}


function get_userid($name, $con){
    $query = "SELECT `user_id` FROM `user` WHERE `username`='".$name."'";
    if(!mysqli_query($con, $query) || !mysqli_fetch_array(mysqli_query($con, $query))){
        return -1;
    }else{
        return mysqli_fetch_array(mysqli_query($con, $query))['user_id'];
    }
}

function storeImage($dataurl, $dest, $filename, $pngFile){
    $dest= "..".$dest;

    if(file_exists($dest.$pngFile)){
        return false;
    }
    $image = strstr($dataurl, ',');
    $image = substr($image, 1);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);
    return file_put_contents($dest.$filename, $data);


}

function replaceImage($dataurl, $dest, $filename, $pngFile, $con, $userid, $profileid){
    $dest= "..".$dest;

    $sql="SELECT * FROM `identity_profiler` WHERE (`user_id` = ".$userid." AND " .
        "`profile_id` = ". $profileid . " AND "."`file_name`='".$pngFile."')";

    $result = mysqli_query($con,$sql);
    $del_image = "";
    while($row = mysqli_fetch_array($result)){
        $del_image = $del_image . $row['identity_profiler_id'].",";
    }
    $del_image = substr($del_image,0, strlen($del_image)-1);

    $sql = "UPDATE `wami`.`identity_profiler` SET `delete_ind` = '2' WHERE `identity_profiler`.`identity_profiler_id` IN (". $del_image.")";
    $result = mysqli_query($con,$sql);

    if (!$result) {
        $response["message"] = "upload_image: Problem replace picture, MySQL Error: " .mysqli_error($con);
        $response["ret_code"] = -1;
        $con->rollback();
        $con->autocommit(TRUE);
        echo json_encode($response);
        exit(-1);
    }

    $image = strstr($dataurl, ',');
    $image = substr($image, 1);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);
    return file_put_contents($dest.$filename, $data);

}

$response = array();
require_once __DIR__ . '/db_connect.php';

//print_r($_POST);

if(isset($_POST['username'])){
    $username = $_POST['username'];
}else{
    echo "don't recieve username";
}


//$username = $_POST['username'];
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
$allowedExts = array("png", "jpg", "jpeg");
$folder = "/profilerdata/" .$username."/".$profileid."/pic/";
$dataurl = $_POST['image_src'];

$pngFile = substr($filename, 0, strrpos($filename, '.')).'.png';

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
    replaceImage($dataurl, $folder, $filename, $pngFile, $con, $userid, $profileid);
}else{
    if(!storeImage($dataurl, $folder, $filename, $pngFile, $replace)){
        $response["ret_code"] = -1;
        $response["message"] = 'File('. $filename . ') already exists!';
        echo json_encode($response);
        exit(-1);
    }
}


//$src = $folder . $filename;

$dest = $folder . "thumbs/";
//$dest = $folder . "thumbs/" . $filename;
//$width = 282;
//make_thumb($filetype, $src, $dest, $width);
createThumbs($folder,$filename,$dest);

$src = ".." . $folder . $filename;
$dest = ".." . $folder . "thumbs/" . $filename;
$pngFile = substr($filename, 0, strrpos($filename, '.')).'.png';

rename($src, "..".$folder.$pngFile);
rename($dest, "..".$folder.'thumbs/'.$pngFile);


$url = $folder.$pngFile;
$sql = "INSERT INTO `identity_profiler`(`user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `file_name`,`description`, `delete_ind`, `create_date`, `modified_date`)
								VALUES ('".$userid."','".$profileid."','Pictures','Picture','png','".$url."','".$title."','".$pngFile."','".$description."', 0, '".$date."','".$date."')";

$result = mysqli_query($con, $sql) or die(mysqli_error($con));
if (!$result) {
    $response["ret_code"] = -1;
    $response["message"] = "upload_image.php: Problem updating identity_profile table. MySQL Error: " .mysqli_error($con);
    echo json_encode($response);
    exit(-1);
}



$response["ret_code"] = 0;
$response["message"] = "New profile image saved. ";
echo json_encode($response);
//echo "work";
?>
