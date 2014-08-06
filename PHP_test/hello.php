<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/hello.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>



    <script type="text/javascript" src="./jwplayer/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="5g4ZNyvFGmOFxIKlQJh5cbpNbbLCDyNNXCODJw==";</script>


    <link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/hello.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css" rel="stylesheet">


</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">WAMI</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <form class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">
    <p>
        <?php
        /**
         * Created by IntelliJ IDEA.
         * User: tanis
         * Date: 7/3/14
         * Time: 9:35 PM
         */
        echo '<h1>Hello World!</h1>';
        ?>
    </p>
    <?php
    $array = array(1 => array(1,2));
    $s2=array(2=>array(4,6));
    array_push($array,$s2);
    $response["result"] = $array;
    $response["message"] = "Fetched the image url. ";
    $out = array_values($response);
    print_r($out);
    ?>

    <!--
    <p>
        <script type="text/javascript">
            document.write("Today is " + Date());
        </script>
    </p>
    -->
    <p>
    <?php
        function longdate($timestamp)
        {
            return date("l F jS Y", $timestamp);
        }
        echo "Today is " . longdate(time());
    ?>
    </p>
    <form name="f1">
        <br>Choose a style:</br>
        <input type="radio" name="sc" value="plain"> plain html</input>
        <input type="radio" name="sc" value="bootstrap"> BootStrap</input>
    </form>
    <br />

    <div>
        <button id="try">Try it</button>
    </div>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="modalLabel">Information</h4>
                </div>
                <div><h4 align="center">Hello World!</h4></div>
                <div><p align="center">I have load a Lucy trailer for you...</p></div>
                <div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">OK</div>
            </div>
        </div>
    </div>
    <br />

    <div id="Lucy_2">Loading the player...</div>

    <div>
        <form action="sever_script/upload_file.php" method="post"
               enctype="multipart/form-data">
            <label for="file">Filename:</label>
            <input type="file" name="file" id="file"><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

    <br />
    <div id="Lucy_1">Waiting to load the player...</div>

    <br />
    <div>
        <table id="myTable">
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Savings</th>
            </tr>
            <tr>
                <td>Peter</td>
                <td>Griffin</td>
                <td>$100</td>
            </tr>
            <tr>
                <td>Lois</td>
                <td>Griffin</td>
                <td>$150</td>
            </tr>
            <tr>
                <td>Joe</td>
                <td>Swanson</td>
                <td>$300</td>
            </tr>
            <tr>
                <td>Cleveland</td>
                <td>Brown</td>
                <td>$250</td>
            </tr>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#myTable').dataTable();
        });
    </script>

</div>

</body>
</html>

