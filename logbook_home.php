<?php
session_start();
if (!isset($_SESSION['loggedinLogs'])) {
    header('Location: logbook_login.php');
}
$showAlert = false;
if (isset($_POST['newLog'])) {
    $newLog = $_POST['newLog'];
    $subject = $_POST['subject'];
    include_once 'crystopher.php';
    $subject = encrypt_decrypt('encrypt', $subject, $_SESSION['logsPwd']);
    $newLog = encrypt_decrypt('encrypt', $newLog, $_SESSION['logsPwd']);
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('Y-m-d H:i:s');
    include_once 'dbCon.php';
    $con = OpenCon();
    $sql = "INSERT INTO `mylogs` VALUES (0,'$subject','$newLog','$curr_date')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = "alert-success";
        $alertMsg = "Log saved";
    } else {
        $showAlert = true;
        $alertClass = "alert-danger";
        $alertMsg = "Error, Log not saved";
    }
    CloseCon($con);
}
if (isset($_POST['editLog'])) {
    $editLog = $_POST['editLog'];
    $subject = $_POST['subject'];
    include_once 'crystopher.php';
    $subject = encrypt_decrypt('encrypt', $subject, $_SESSION['logsPwd']);
    $editLog = encrypt_decrypt('encrypt', $editLog, $_SESSION['logsPwd']);
    $id = $_POST['id'];
    include_once 'dbCon.php';
    $con = OpenCon();
    $sql = "UPDATE `mylogs` SET logBody='$editLog', subject='$subject' WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = "alert-success";
        $alertMsg = "Log ID $id updated";
    } else {
        $showAlert = true;
        $alertClass = "alert-danger";
        $alertMsg = "Error, Log ID $id not updated";
    }
    CloseCon($con);
}
if (isset($_GET['deleteLog'])) {
    include_once 'dbCon.php';
    $con = OpenCon();
    $id = $_GET['deleteLog'];
    $sql = "DELETE FROM `mylogs` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = "alert-success";
        $alertMsg = "Log $id deleted";
    } else {
        $showAlert = true;
        $alertClass = "alert-danger";
        $alertMsg = "Error, Log $id not deleted";
    }
    CloseCon($con);
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <title>Home - Logbook</title>
</head>

<body>
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
            <strong >$alertMsg</strong>
            <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="mt-3 text-center">
        <a href="logbook_newLog.php" class="btn btn-primary  ">New Log</a>
    </div>
    <div class="mt-3 mx-3 mb-0 text-center">
        <u>
            <h4> <a href="logbook_home.php"> All Logs </a></h4>
        </u>
    </div>
    <div style="margin-top: 0px; margin-bottom: 20px; margin-inline: 1%;">
        <table id="all_cust" class="table-light table table-striped table-bordered caption-top " style="width:100%">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Subject</th>
                    <th>Actions</th>
                    <th style='min-width:150px'>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'dbCon.php';
                $con = OpenCon();
                $sql = "SELECT id,date,subject FROM `mylogs` ";
                $result = mysqli_query($con, $sql);
                $rowNos = mysqli_num_rows($result);
                for ($x = 0; $x < $rowNos; $x++) {
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    $subject = $row['subject'];
                    include_once 'crystopher.php';
                    $date = $row['date'];
                    $subject = encrypt_decrypt('decrypt', $subject, $_SESSION['logsPwd']);
                    if ($subject != false) {
                        echo "<tr>
                                    <td>$id</td>
                                    <td>$subject</td>
                                    <td>
                                        <a href='logbook_view.php?viewLog=$id' class='btn btn-primary' >View</a>
                                    </td>
                                    <td>$date </td>
                            </tr>";
                    }
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
        <!-- for data table -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"> </script>
        <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script>
            $(document).ready(function() {
                $('#all_cust').DataTable({
                    "scrollX": true,
                    "pageLength": 25,
                    "order": [
                        [3, "desc"]
                    ]
                });
            });
        </script>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>