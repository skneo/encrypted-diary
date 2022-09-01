<?php
// session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- <a href="index.php"><img src="images/expense.png" alt="mobile_apps" width="40" height="40"></a> -->
        <a class="navbar-brand ms-2" href="logbook_home.php">Expense Tracker </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a id="home" class="active nav-link " aria-current="page" href="logbook_home.php">Home</a>
                </li>
            </ul>
            <a class="btn btn-primary me-3" href="change_password.php">Change Password</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>
<style>
    body {
        background-color: skyblue;
    }

    @media only screen and (min-width: 960px) {
        .navbar .navbar-nav .nav-item .nav-link {
            padding: 0 0.5em;
        }

        .navbar .navbar-nav .nav-item:not(:last-child) .nav-link {
            border-right: 1px solid #f8efef;
        }
    }
</style>