<?php
include('Backend/utility.php');
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
</head>
<body>
    <div class="uk-section uk-section-muted" uk-height-viewport>
    <div class="uk-margin-xlarge-top">
    <div class="uk-height-1-1 uk-flex uk-margin uk-margin-small-top uk-container">
        <div class="uk-card uk-border-rounded uk-box-shadow-large uk-card-body uk-animation-slide-left uk-width-xlarge uk-card-default">
            <h1 class="uk-card-title uk-text-center">{Title_1}</h1>
            <form id="login-form">
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="user"></span>
                        <input class="uk-input uk-form-large" type="text">
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="lock"></span>
                        <input class="uk-input uk-form-large" type="password">
                    </div>
                </div>
                <div class="uk-margin">
                    <button id="login-button" class="uk-button uk-button-secondary uk-width-1-2 uk-button-large uk-align-center">{Button}</button>
                </div>
                <div class="uk-margin">
                    <p class="uk-text-default uk-text-center">{Text_1} <a> {Redirect_1}</a></p>
                </div>
            </form>
            <div id="spinner" uk-spinner="ratio: 2" class="uk-position-center uk-hidden"></div>
        </div>
        <div data-src="Uploads/DM-Hellish.png" class="uk-card uk-box-shadow-large uk-border-rounded uk-card-body uk-width-2xlarge uk-background-cover uk-animation-slide-right uk-card-secondary uk-visible@s" uk-img>
            <div class="uk-overlay-primary uk-position-cover uk-dark">
                Your Company Logo Should Be Appear On Here
            </div>
        </div>
    </div>
    </div>
</div>
<script>
    $("#login-form").submit(function(e){
        e.preventDefault();
        $("#login-form").addClass("uk-invisible");
        $("#spinner").removeClass("uk-hidden");
    });
</script>
</body>
</html>