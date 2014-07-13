<?php
/**
 * Created by IntelliJ IDEA.
 * User: tanis
 * Date: 7/10/14
 * Time: 3:15 PM
 */

$usr_Id = intval($_GET['usr_Id']);
$con = mysqli_connect('localhost','root') or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
$dbname = "wami";
mysqli_select_db($con,$dbname) or die('Could not select database');


$sql="SELECT * FROM identity_profiler WHERE user_Id = ".$usr_Id;
$result = mysqli_query($con,$sql);

//echo "<table border='1'>";

while($row = mysqli_fetch_array($result)) {

    echo "<div class=\"col-xs-3\">";
    echo "<a href=\"#\" class=\"thumbnail\">";
    echo "<img src=\"/WAMI/PHP_test". $row['preview_url'] . "\" class=\"img-responsive\">";
    echo  "</a></div>";
    /*
    echo "<tr>";
    echo "<td>" . $row['identity_profiler_id'] . "</td>";
    echo "<td>" . $row['profiler_url'] . "</td>";
    echo "</tr>";
    */
}
//echo "</table>";

mysqli_close($con);

?>