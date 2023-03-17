<?php
session_start();
if(!isset($_SESSION['username'])){
   header("location:login.php");
   exit;
}
?>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
    .folder-list {
        cursor: pointer;
    }

    v .folder-list {
        cursor: pointer;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        /* padding: .2em 1em .2em .2em; */
        border: 1px solid #def;
        height: 50px;
        font-size: 12px;
        text-align: center;
        white-space: nowrap;
    }

    .update {
        margin-top: 5px;
        text-align: center;
    }
    </style>

</head>

<body>
    <div class="container">
        <button type="button" class="btn btn-outline-success"><a href="logout.php"> logout</a></button>
    </div>

    <div>
        <form id="createFolder" enctype="multipart/form-data">
            <input type="text" name="foldername" id="foldername" placeholder="folder name">
            <input type="file" name="file" id="file" accept="image/*">
            <input type="hidden" name="action" value="createFolder">
            <input type="hidden" name="folder_id" value="0">
            <input type="hidden" name="updateId" value="">
            <input type="hidden" name="deleteId" value="">
            <input type="submit" name="submit" value="submit">
        </form>
        <table id="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>update</th>
                    <th>Delete</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody id="folder-list" class="folder-list">

            </tbody>
        </table>
    </div>


</body>
<script>
var folder_id = 0;
$(document).on('submit', '#createFolder', function() {
    event.preventDefault();
    // console.log(folder_id)
    var form = $('#createFolder')[0];
    var formData = new FormData(form);

    $.ajax({
        type: "post",
        url: "functions_collection.php",
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            document.getElementById('createFolder').reset()
            $('input[name="action"').val('createFolder');
            $('input[name="folder_id"').val(folder_id);
            getFolderName(folder_id)
        }
    });
});

function getFolderName(folder_id) {
    $.ajax({
        type: "post",
        url: "functions_collection.php",
        data: {
            'action': 'getList',
            folder_id: folder_id
        },
        dataType: "json",
        success: function(response) {
            if (response.status == 'success') {
                $('.folder-list').html(response.data)
            }
        }
    });
}

$(document).on('click', '.folder-list-item', function() {
    folder_id = $(this).attr('id');
    console.log(folder_id)
    $('input[name="folder_id"]').val(folder_id)
    getFolderName(folder_id);
})
getFolderName(folder_id);

$(document).on('click', '.edit-dir', function() {
    let name = $(this).attr('name');
    let id = $(this).attr('id');
    $('input[name="foldername"]').val(name)
    $('input[name="action"').val('updateDir');
    $('input[name="updateId"').val(id);
});
$(document).on('click', '.delete-dir', function() {
    var folder_name = $(this).attr("name");
    let did = $(this).attr('id');
    var action = "deleteId";
    if (confirm("ARE you sure you want to remove it?")) {
        $.ajax({
            url: "functions_collection.php",
            method: "POST",
            data: {
                folder_name: folder_name,
                action: action,
                did: did
            },
            success: function(data) {
                // alert(data);
                getFolderName(folder_id);
            }
        });
    }




});
</script>

</html>