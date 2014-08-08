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

    // copy and resize old image into new image
    imagecopyresized( $tmp_img, $img, 0, 0, $crop_x, $crop_y, $thumb_w, $thumb_h, $new_w, $new_h );

    // save thumbnail into a file
    imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );

}


function get_userid($name, $con){
    $query = "SELECT `user_id` FROM `user` WHERE `username`='".$name."'";
    if(!mysqli_query($con, $query) || !mysqli_fetch_array(mysqli_query($con, $query))){
        return -1;
    }else{
        return mysqli_fetch_array(mysqli_query($con, $query))['user_id'];
    }
}

function storeImage($url, $dest, $filename){
    $dest= "..".$dest;
    if(file_exists($dest.$filename)){
        return false;
    }
    $image = strstr($url, ',');
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
if(isset($_POST['descrip'])){
    $descrip = $_POST['descrip'];
}else{
    $descrip = "";
}

$date = date("Y-m-d H:i:s");


$filename = $_POST['filename'];
$filetype = end(explode(".", $filename));
$allowedExts = array("png", "jpg", "jpeg");
$folder = "/profilerdata/" .$username."/pic/";
$dataurl = $_POST['image_src'];

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

if(!storeImage($dataurl, $folder, $filename)){
    $response["ret_code"] = -1;
    $response["message"] = 'File('. $filename . ') already exists!';
    echo json_encode($response);
    exit(-1);
}

//$src = $folder . $filename;

$dest = $folder . "thumbs/";
//$dest = $folder . "thumbs/" . $filename;
//$width = 282;
//make_thumb($filetype, $src, $dest, $width);
createThumbs($folder,$filename,$dest);
$sql = "INSERT INTO `identity_profiler`(`user_id`, `profile_id`, `category`, `media_type`, `file_type`, `profiler_url`, `title`, `file_name`,`description`, `delete_ind`, `create_date`, `modified_date`)
								VALUES ('".$userid."','".$profileid."','Pictures','Picture','".$filetype."','".$folder . $filename."','".$title."','".$filename."','".$descrip."', 0, '".$date."','".$date."')";

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
