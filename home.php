<?php
session_start();
error_reporting(1);
include('Backend/connection.php');
include('Backend/utility.php');
$code = $checkAuth($_SESSION['user']);
$access = $checkAccess($_SESSION['user'], false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $access; ?></title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit-icons.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://pagination.js.org/dist/2.1.5/pagination.min.js"></script>
    <style>.uk-notification-message{background-color:rgb(59, 59, 59);}</style>
</head>
<body>
<nav class="uk-navbar-container uk-navbar-transparent uk-light uk-background-secondary" uk-navbar>
        <div class="uk-navbar-left uk-margin-large-left">
            <ul class="uk-navbar-nav pc-nav">
                <li class="uk-active"><a href="home.php">Home</a></li>
                <li><a href="transaction.php">Transaction</a></li>
            </ul>
            <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#offcanvas-nav" uk-toggle hidden></a>
            <div id="offcanvas-nav" uk-offcanvas="overlay: true">
                <div class="uk-offcanvas-bar">
                    <ul class="uk-nav uk-nav-default">
                        <li class="uk-active"><a href="#">Active</a></li>
                        <li class="uk-parent">
                            <a href="#">Parent</a>
                            <ul class="uk-nav-sub">
                                <li><a href="#">Sub item</a></li>
                                <li><a href="#">Sub item</a></li>
                            </ul>
                        </li>
                        <li class="uk-nav-header">Header</li>
                        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: table"></span> Item</a></li>
                        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span> Item</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: trash"></span> Item</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-navbar-center">
            <a class="uk-navbar-item uk-logo">FoMana</a>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav pc-nav">
            <li class="">
                <a class="uk-active uk-margin-large-right">My Account</a>
                <div uk-dropdown="pos: bottom-center">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li class="uk-active">Management</li>
                            <li class="uk-nav-divider"></li>
                            <?php if($access != "User"){echo '<li><a href="admin.php"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Admin Dashboard</a></li>';} ?>
                            <li><a href="logout.php"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Logout</a></li>
                        </ul>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <div class="uk-section uk-section-muted" uk-height-viewport>
        <div class="uk-container uk-overflow-auto uk-width-1-2">
        </div>
    </div>
</body>
</html>