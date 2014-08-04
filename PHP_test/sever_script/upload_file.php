<?php
error_reporting(0);
if(isset($_POST['submit']))
{
    $target = "WAMI/PHP_test/";
    $allowedExts = array("jpg", "jpeg");
    $extension = end(explode(".", $_FILES["file_upload"]["name"]));
    $target = $target . basename( $_FILES['file_upload']['name']);
    $date = date("Y-m-d H:i:s");

    //Function to generate image thumbnails
    function make_thumb($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired 
         * width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0,
            $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination with 100% 
         * quality*/
        imagejpeg($virtual_image, $dest,100);
    }

    require_once('../connection.php');

    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting 
            to database");
    mysql_select_db($dbname) or die ("Error selecting the database");

    //check for allowed extensions
    if ((($_FILES["file_upload"]["type"] == "image/jpg")
            || ($_FILES["file_upload"]["type"] == "image/jpeg"))
        && in_array($extension, $allowedExts))
    {
        $photoname = $_FILES["file_upload"]["name"];
        if (file_exists("../uploads/" . $photoname))
        {
            die( '<div class="error">Sorry <b>'. $photoname .
                '</b> already exists</div>');
        }

        if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $target))
        {
            $query = "INSERT INTO photos (photo_name,date_added) 
                    VALUES ('$photoname','$date')";
            mysql_query($query);
            $sql = "SELECT MAX(id) FROM photos";
            $max = mysql_query($sql);
            $row = mysql_fetch_array($max);
            $maxId = $row['MAX(id)'];

            $type = $_FILES["file_upload"]["type"];
            switch($type)
            {
                case "image/jpeg":
                    $ext = ".jpeg";
                    break;
                case "image/jpg";
                    $ext = ".jpg";
                    break;
            }

            //define arguments for the make_thumb function
            $source = "../uploads/".$photoname;
            $destination = "../thumbnails/thumb_". $maxId . $ext ."";
            //specify your desired width for your thumbnails
            $width = "282";
            //Finally call the make_thumb function
            make_thumb($source,$destination,$width);

            $msg = '<div class="success">
                        <b>Upload: </b>' . basename($photoname) . '<br />
                        <b>Type: </b>' . $_FILES["file_upload"]["type"] . '<br />
                        <b>Size: </b>' . ceil(($_FILES["file_upload"]["size"] / 1024)) . 'Kb<br />
                    </div>';
        }
        else
        {
            $msg = '<div class="error">Sorry, there was a problem uploading your file.</div>';
        }
    }
    else
    {
        $msg = '<div class="error">The file type you are trying to upload is not allowed!</div>';
    }
}
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
