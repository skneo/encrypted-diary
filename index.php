<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    header('Location: logbook_login.php');
}
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'dbCon.php';
    $con = OpenCon();
    $username = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);

    $sql = "SELECT * FROM enjoyers WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $count  = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $username1 = $row['username'];
        $passwordHash = $row['password'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('Y-m-d H:i:s');
        if ($username == $username1 && password_verify($password, $passwordHash)) {
            $sql = "UPDATE `enjoyers` SET `last_login`='$curr_date', `login_ip`='$ip_address' WHERE `username`='$username'";
            $result = mysqli_query($con, $sql); // or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($con), E_USER_ERROR);
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            if (isset($_SESSION['url_req'])) {
                $url = $_SESSION['url_req'];
                header("location:  $url");
            } else {
                header("Location: logbook_login.php");
            }
        } else {
            echo "<div id='loginAlert' class='alert alert-danger alert-dismissible fade show py-2' role='alert'>
                <strong>Login failed! Wrong Credentials. </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        echo "<div id='loginAlert' class='alert alert-danger alert-dismissible fade show py-2' role='alert'>
                <strong>Login failed! Wrong Credentials. </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
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
    <title>Login | Apps</title>
</head>

<body>
    <div class="text-center mt-5 w-25 container" style="min-width: 300px;">
        <div class="mt-3">
            <img src="images/user.png" alt="user" width="120">
        </div>
        <form action="index.php" method="POST">
            <div class="mb-2 ">
                <label for="username" class="form-label float-start">Username</label>
                <input type="text" name="username" id="username" class="mt-3 form-control" placeholder="Enter username">
            </div>
            <div class="mb-3 ">
                <label for="password" class="form-label float-start">Password</label>
                <input type="password" name="password" id="password" class="my-3 form-control" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary px-5 ">Login</button>
        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>
<style>
    body {
        background-color: skyblue;
    }
</style>