<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/7/14
 * Time: 12:51 AM
 */


function createThumbs( $folder, $fname, $pathToThumbs)
{
    $system=explode('.',$fname);

    //echo $system[sizeof($system)-1];

    if (preg_match('/jpg|jpeg/',$system[sizeof($system)-1])){
        $img=imagecreatefromjpeg("{$folder}{$fname}");
    }
    if (preg_match('/png/',$system[sizeof($system)-1])){
        $img=imagecreatefrompng("{$folder}{$fname}");
    }


    echo "Creating thumbnail for {$fname} <br />";

    // load image and get image size
    $width = imagesx( $img );
    $height = imagesy( $img );

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

    // calculate thumbnail size
    //$new_width = $thumbWidth;
    //$new_height = floor( $height * ( $thumbWidth / $width ) );

    // create a new temporary image
    $tmp_img = imagecreatetruecolor( $thumb_w, $thumb_h );

    // copy and resize old image into new image
    imagecopyresized( $tmp_img, $img, 0, 0, $crop_x, $crop_y, $thumb_w, $thumb_h, $new_w, $new_h );

    // save thumbnail into a file
    imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );

}
// call createThumb function and pass to it as parameters the path
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width.
// We are assuming that the path will be a relative path working
// both in the filesystem, and through the web for links
createThumbs("profilerdata/Tanis/pic/", "mdog.jpg","profilerdata/Tanis/pic/thumbs/");


?>

