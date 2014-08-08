<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 8/7/14
 * Time: 12:51 AM
 */


function createThumbs( $folder, $fname, $pathToThumbs, $thumbWidth )
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
    //$img = imagecreatefrompng($fname);
    //echo $pathToImages;
    //echo $fname;
    //echo $img;
    $width = imagesx( $img );
    $height = imagesy( $img );

    // calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor( $height * ( $thumbWidth / $width ) );

    // create a new temporary image
    $tmp_img = imagecreatetruecolor( $new_width, $new_height );

    // copy and resize old image into new image
    imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

    // save thumbnail into a file
    imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );

}
// call createThumb function and pass to it as parameters the path
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width.
// We are assuming that the path will be a relative path working
// both in the filesystem, and through the web for links
createThumbs("upload/", "FlowChart.png","upload/thumbs/",283);


?>

