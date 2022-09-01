<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
if (isset($_SESSION['loggedinLogs'])) {
    header('Location: logbook_home.php');
}
$showAlert = false;
if (isset($_POST['logsPassword'])) {
    include_once 'dbCon.php';
    $con = OpenCon();
    $logsPassword = $_POST['logsPassword'];
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM enjoyers WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $passwordHash = $row['logKey'];
    if (password_verify($logsPassword, $passwordHash)) {
        $_SESSION['loggedinLogs'] = true;
        $_SESSION['logsPwd'] = $logsPassword;
        header('Location: logbook_home.php');
    } else {
        $showAlert = true;
        $alertClass = "alert-danger";
        $alertMsg = "Wrong password";
    }
    mysqli_close($con);
}
if (isset($_POST['logsPwdChange'])) {
    include_once 'dbCon.php';
    $con = OpenCon();
    $logsPassword = $_POST['logsPwdChange'];
    $passwordHash = password_hash($logsPassword, PASSWORD_DEFAULT);
    $username = $_SESSION['username'];
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('Y-m-d H:i:s');
    $sql = "UPDATE enjoyers SET logKey='$passwordHash', logKeyChangedOn='$curr_date' WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = "alert-success";
        $alertMsg = "Logbook password changed";
    } else {
        $showAlert = true;
        $alertClass = "alert-danger";
        $alertMsg = "Error, Logbook password changed";
    }
    mysqli_close($con);
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <title>Login - Logbook</title>
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
    <script>
        var changePwd = function() {
            document.getElementById('loginDiv').classList.add('d-none');
            document.getElementById('changePwdDiv').classList.remove('d-none');
        }
        var check = function() {
            var pwd1 = document.getElementById('logsPwdChange').value;
            var pwd2 = document.getElementById('clogsPwdChange').value;
            if ((pwd1 == pwd2) && pwd1.trim() != '') {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Both passwords matched';
                document.getElementById('changePwdBtn').disabled = false;
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Both passwords not matched';
                document.getElementById('changePwdBtn').disabled = true;
            }
        }
    </script>
    <div class="container mt-3 text-center" id="loginDiv">
        <form action="logbook_login.php" method="post">
            <div class="mb-3 ">
                <label for="logsPassword" class="form-label float-start">Logbook Password</label>
                <input type="password" autocomplete="new-password" name="logsPassword" id="logsPassword" class="my-3 form-control">
            </div>
            <button type="submit" class="btn btn-primary px-5 ">Login into Logbook</button><br><br><br>
        </form>
        <button class="btn btn-danger px-5 " onclick="changePwd()">Change Logbook password</button>
    </div>
    <div id="changePwdDiv" class="container mt-3 text-center d-none">
        <h5 class="text-danger mb-3">Caution: Logs saved with old password will only open with old password, they will not open with new password</h5>
        <form action="logbook_login.php" method="post">
            <div class="mb-3 ">
                <label for="logsPwdChange" class="form-label float-start">Enter new Logbook password</label>
                <input onkeyup='check();' type="password" name="logsPwdChange" id="logsPwdChange" class="my-3 form-control">
            </div>
            <div class="mb-3 ">
                <label for="clogsPwdChange" class="form-label float-start">Enter new Logbook password again</label>
                <input onkeyup='check();' type="password" name="clogsPwdChange" id="clogsPwdChange" class="my-3 form-control">
                <span id='message' class="float-start"></span><br>
            </div>
            <hr>
            <button type="submit" id="changePwdBtn" class="btn btn-primary px-5 ">Submit</button><br><br><br>
        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>