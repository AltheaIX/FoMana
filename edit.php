<?php
include('Backend/connection.php');
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
    <title>Document</title>
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
        </div>
    </div>
</body>
<script type="text/javascript">

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
});

var bar = document.getElementById('js-progressbar');
UIkit.upload('.js-upload', {
    
    url: 'Backend/upload.php',
    allow: '*.(jpg|gif|png)',
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
        }, 2000);
        $('input[name="filename"]').val(e.responseText);
    }
});
</script>
</html>