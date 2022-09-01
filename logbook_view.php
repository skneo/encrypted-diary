<?php
session_start();
if (!isset($_SESSION['loggedinLogs'])) {
    header('Location: logbook_login.php');
}
$showAlert = false;
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <title>View Log | Logbook</title>
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

    if (isset($_GET['viewLog'])) {
        include_once 'dbCon.php';
        $con = OpenCon();
        $id = $_GET['viewLog'];
        $sql = "SELECT * FROM `mylogs` WHERE `id`='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $date = $row['date'];
        $subject = $row['subject'];
        $logBody = $row['logBody'];
        include_once 'crystopher.php';
        $subject = encrypt_decrypt('decrypt', $subject, $_SESSION['logsPwd']);
        $logBody = encrypt_decrypt('decrypt', $logBody, $_SESSION['logsPwd']);
        mysqli_close($con);
    }
    ?>
    <div class="container my-3">
        <center>
            <a href="logbook_home.php" class="btn btn-primary mb-2"> &larr; All Logs</a>
            <h5><b>Log ID:</b> <?php echo $id ?></h5>
        </center>
        <p><b> Date:</b> <?php echo $date ?></p>
        <p><b> Subject:</b> <?php echo $subject ?></p>
        <p style="white-space: pre-wrap;"><?php echo $logBody ?></p>
        <a href='logbook_editLog.php?editLog=<?php echo $id ?>' class='btn btn-info '>Edit</a>
        <a href='logbook_home.php?deleteLog=<?php echo $id ?>' onclick="return confirm('Sure to delete Log ?')" class='btn btn-danger float-end'>Delete</a>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>