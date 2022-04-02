<?php
session_start();
include('Backend/utility.php');
include('Backend/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit-icons.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>.uk-notification-message{background-color:rgb(59, 59, 59);}</style>
</head>
<body>
    <div class="uk-section uk-section-muted" uk-height-viewport>
    <div class="uk-margin-xlarge-top">
    <div class="uk-height-1-1 uk-flex uk-margin uk-margin-small-top uk-container">
        <div class="uk-card uk-border-rounded uk-box-shadow-large uk-card-body uk-animation-slide-left uk-width-xlarge uk-card-default">
            <h1 class="uk-card-title uk-text-center">Welcome to FoMana</h1>
            <form id="login-form">
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="user"></span>
                        <input class="uk-input uk-form-large" name="username" type="text">
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="lock"></span>
                        <input class="uk-input uk-form-large" name="password" type="password">
                    </div>
                </div>
                <div class="uk-margin">
                    <button id="login-button" class="uk-button uk-button-secondary uk-width-1-2 uk-button-large uk-align-center">Login</button>
                </div>
                <div class="uk-margin">
                    <p class="uk-text-default uk-text-center">Not have account yet? <a> Register Now</a></p>
                </div>
            </form>
            <div id="spinner" uk-spinner="ratio: 2" class="uk-position-center uk-hidden"></div>
        </div>
        <div data-src="" class="uk-card uk-box-shadow-large uk-border-rounded uk-card-body uk-width-2xlarge uk-background-cover uk-animation-slide-right uk-card-secondary uk-visible@s" uk-img>
            <div class="uk-overlay-primary uk-position-cover uk-dark">
                <div class="uk-position-center">
                    <h3 class="uk-text-center">FoMana</h3>
                    <p class="uk-text-center">Your free and simple management website for business starter.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script>
    $("#login-form").submit(function(e){
        e.preventDefault();
        var loginForm = $("#login-form");
        var Spinner = $("#spinner");
        loginForm.addClass("uk-invisible");
        Spinner.removeClass("uk-hidden");
        $.ajax({
            method: "POST",
            url: "Backend/login.php",
            data: $("#login-form").serialize()
        }).done(function(e){
            if(e == "Incorrect username or password. Try again."){
                UIkit.notification({
                    message: '<span uk-icon=\'icon: close;\'></span> Wrong username or password!',
                    status: 'warning',
                    pos: 'top-right',
                    timeout: 3000
                })
                Spinner.addClass("uk-hidden");
                loginForm.removeClass("uk-invisible");
            }
            else if(e == "Login Success."){
                UIkit.notification({
                    message: '<span uk-icon=\'icon: check;\'></span> Login Success!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 3000
                })
                Spinner.addClass("uk-hidden");
                loginForm.removeClass("uk-invisible");
                window.location.href = "home.php";
            }
            else{
                UIkit.notification({
                    message: '<span uk-icon=\'icon: warning;\'></span> Error has occured!',
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 3000
                })
                Spinner.addClass("uk-hidden");
                loginForm.removeClass("uk-invisible");
            }
        });
    });
</script>
</body>
</html>