<?php
include('Backend/connection.php');
$stmt = $pdo->prepare('SELECT * FROM foods');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="uk-container uk-overflow-auto uk-width-1-2" id="pagination">
            <table class="uk-table uk-table-hover uk-responsive-height uk-responsive-width">
                <thead>
                    <tr>
                        <th class="uk-width-auto">Id</th>
                        <th class="uk-width-1-4">Name</th>
                        <th class="uk-width-1-2">Image URL</th>
                        <th class="uk-width-1-6">Price</th>
                        <th class="uk-width-expand">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($result as $res){
                        echo '<tr>
                        <td id="id" class="uk-text-unwrap">'.$res['id'].'</td>
                        <td id="name" class="uk-text-truncate">'.$res['name'].'</td>
                        <td id="image" class="uk-text-truncate">'.$res['image'].'</td>
                        <td id="price" class="uk-text-truncate">'.$res['price'].'</td>
                        <td class="uk-text-unwrap"><a id="edit"><span uk-icon="icon: pencil;"></span></a><a id="delete"><span uk-icon="icon: trash;"></span></a></td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).on("click", "a#delete", function(){
            let parentTag = $(this).parents("tr");
            const foodId = parentTag.find("#id").get(0).outerText;
            UIkit.modal.confirm(`You are trying to delete table number ${foodId}, Press OK to Continue!`).then(function(){
                $.ajax({
                    method: "POST",
                    url: "backend/deleteFood.php",
                    data: {id:foodId}
                }).done(function(){
                    parentTag.hide();
                    UIkit.notification({
                        message: '<span uk-icon=\'icon: check;\'></span> Delete success!',
                        status: 'success',
                        pos: 'top-right',
                        timeout: 3000
                    })
                });
            });
        });

    $(document).on("click", "a#edit", function(e){
        let parentTag = $(this).parents("tr");
        const foodId = parentTag.find("#id").get(0).outerText;
        self.location = `edit.php?id=${foodId}`;
    });

    $(document).ready(function(){
        let rows = []
        $('table tbody tr').each(function(i, row) {
            return rows.push(row);
        });

        $("#pagination").pagination({
            dataSource: rows,
            pageSize: 10,
            showPrevious: true,
            showNext: true,
            ulClassName: 'uk-pagination',
            className: 'uk',
            activeClassName: 'uk-active',
            disableClassName: 'uk-disable',
            callback: function(data, pagination){
                $("tbody").html(data);
            }
        });
    })
</script>
</html>