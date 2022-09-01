<?php
// Create connection
function OpenCon()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "notebookdb";

    $con = mysqli_connect($servername, $username, $password, $db_name);
    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    return $con;
}
//close connection
function CloseCon($con)
{
    mysqli_close($con);
}
