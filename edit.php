<?php
session_start();
error_reporting(1);
include('Backend/connection.php');
include('Backend/utility.php');
$code = $checkAuth($_SESSION['user']);
$access = $checkAccess($_SESSION['user'], true);
$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM foods WHERE id = :id');
$stmt->execute(array(':id' => $id));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
                <li><a href="home.php">Home</a></li>
                <li><a href="transaction.php">Transaction</a></li>
            </ul>
            <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#offcanvas-nav" uk-toggle hidden></a>
            <div id="offcanvas-nav" uk-offcanvas="overlay: true">
                <div class="uk-offcanvas-bar">
                    <ul class="uk-nav uk-nav-default">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="transaction.php">Transaction</a></li>
                        </li>
                        <li class="uk-nav-header">Management</li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="admin.php"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Admin Dashboard</a></li>
                        <li><a href="logout.php"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Logout</a></li>
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
            <form id="updateForm" class="uk-form-horizontal">
                <legend class="uk-legend">Modify <?php echo $result['name']; ?></legend>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Id</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="id" type="text" placeholder="" value="<?php echo $result['id']; ?>" disabled>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Food Name</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="name" type="text" placeholder="Food's Name">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Image</label>
                    <div class="uk-form-controls">
                        <div class="js-upload" uk-form-custom>
                            <input class="uk-input" name="filename" type="text" hidden>
                            <input type="file" id="file" name="file" multiple>
                            <button class="uk-button uk-button-default" type="button" tabindex="-1">Select</button>
                        </div>
                        <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Price</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="price" type="text" placeholder="Food's Price">
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-form-controls">
                        <input type="submit" class="uk-button uk-button-primary uk-width-auto@s uk-margin-small-bottom" value="Update">
                        <input type="submit" class="uk-button uk-button-danger uk-width-auto@s uk-margin-small-bottom" value="Close">
                    </div>
                </div>
            </form>
            <ul class="uk-pagination">
                <li><a id="previous"><span class="uk-margin-small-right" uk-pagination-previous></span></a></li>
                <li class="uk-margin-auto-left"><a id="next"><span class="uk-margin-small-left" uk-pagination-next></span></a></li>
            </ul>
        </div>
    </div>
</body>
<script type="text/javascript">
function GetURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
};

$("a#previous").on('click', function(e){
    const foodId = GetURLParameter("id");
    if(foodId > 1){
        let prev = foodId - 1;
        const url = window.location.href.split('?')[0] + `?id=${prev}`;
        window.location.replace(url)
    }
})

$("a#next").on('click', function(e){
    const id = GetURLParameter("id");
    if(id < <?php $totalRowFoods() ?>){
        let next = parseInt(id) + 1;
        const url = window.location.href.split('?')[0] + `?id=${next}`;
        window.location.replace(url)
    }
})

$(window).on('resize', function(){
    var win = $(this);
    if(win.width() <= 395){
        $(".uk-pagination, a").each(function(){
            console.log("ve")
        })
    }
})

$("form").on('submit', function(e){
    e.preventDefault();
});

$('input[type="submit"][value="Update"]').on('click', function(e){
    const foodId = GetURLParameter("id");
    const payload = `id=${foodId}&` + $("#updateForm").serialize();
    $.ajax({
        url: "Backend/updateFood.php",
        data: payload,
        method: "POST"
    }).done(function(e){
        UIkit.notification({
            message: '<span uk-icon=\'icon: check;\'></span> Update has been applied!',
            status: 'success',
            pos: 'top-right',
            timeout: 3000
        })
    })
})

$('input[type="submit"][value="Close"]').on('click', function(e){
    window.location.href = "admin.php";
})

$(document).ready(function(){
    const foodId = GetURLParameter("id");
    $.ajax({
        method: "POST",
        url: "Backend/getFood.php",
        data: {id:foodId}
    }).done(function(e){
        const json = jQuery.parseJSON(e);
        $('input[name="id"]').val(json.id);
        $('input[name="name"]').val(json.name);
        $('input[name="filename"]').val(json.image);
        $('input[name="price"]').val(json.price);
    });
    
    $(window).on('resize load', function(){
        var win = $(this);
        if(win.width() <= 395){
                $(".pc-nav").attr('hidden','hidden');
                $("a.uk-navbar-toggle").removeAttr('hidden');
        }
        else{
            $(".pc-nav").removeAttr('hidden');
            $("a.uk-navbar-toggle").attr('hidden','hidden');
        }
    })
});

var bar = document.getElementById('js-progressbar');
UIkit.upload('.js-upload', {
    
    url: 'Backend/upload.php',
    allow: '*.(jpg|jpeg|gif|png)',
    name: "file",
    multiple: false,
    
    loadStart: function (e) {
        console.log('loadStart', arguments);

        bar.removeAttribute('hidden');
        bar.max = e.total;
        bar.value = e.loaded;
    },

    progress: function (e) {
        console.log('progress', arguments);

        bar.max = e.total;
        bar.value = e.loaded;
    },

    loadEnd: function (e) {
        console.log('loadEnd', arguments);

        bar.max = e.total;
        bar.value = e.loaded;
    },
    complete: function(e){
        setTimeout(function () {
            bar.setAttribute('hidden', 'hidden');
        }, 3000);
        $('input[name="filename"]').val(e.responseText);
    }
});
</script>
</html>