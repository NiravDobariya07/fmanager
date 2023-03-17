<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'connection.php';

if($_POST['action'] == 'createFolder'){
    $user_id = $_SESSION['user_id'];
    $folder_name = $_POST['foldername'];
    $folder_id = $_POST['folder_id'];


    if($_FILES['file']['size'] > 0){
        $folder_name = time().mt_rand(1000,9999).$_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        if(!is_dir('images')){
            mkdir('images', 0777, true);
        }

        if(move_uploaded_file($_FILES['file']['tmp_name'],'images/'.$folder_name)){
            $sql = "INSERT INTO folders(`user_id`,`name`,`folder_id`,`type`,`size`)VALUES($user_id,'$folder_name',$folder_id,'file',$file_size)";
            $result = mysqli_query($con, $sql);
        }
    }else{
        $sql = "INSERT INTO folders(`user_id`,`name`,`folder_id`,`type`)VALUES($user_id,'$folder_name','$folder_id','dir')";
        $result = mysqli_query($con, $sql);
    }
    $data = ['status'=>'success'];
    echo json_encode($data);
}

if($_POST['action'] == 'getList'){
    $user_id = $_SESSION['user_id'];
    $folder_id = $_POST['folder_id'];

   $sql = "SELECT * FROM `folders`";
   if($folder_id == 0){
    $sql .= " WHERE `folder_id` = 0";
   }else{
    $sql .= " WHERE `folder_id` = '$folder_id'";
   }
   $sql .= " AND `user_id` = $user_id ";

   $sql .= " ORDER BY `type` ASC";
   $li = '';
   $result = mysqli_query($con, $sql);
   if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            if($row['type'] == 'dir'){
                $li .= '<tr><td> <span class="folder-list-item" id="'.$row['id'].'">'.$row['name'].'</td>
                <td> <span class="folder-list-item"></td>
                <td> <button type="button" class="btn btn-primary edit-dir" name="'.$row['name'].'" id="'.$row['id'].'">Update<span></td>
                <td> <button type="button" class="btn btn-danger delete-dir" name="'.$row['name'].'" id="'.$row['id'].'">Delete<span></td>
                    <td> <span class="folder-list-item">'.$row['type'].'</td></tr> ';    
            }else{
                $li .= '<tr><td id="'.$row['id'].'"> <a href="images/'.$row['name'].'" target="_blank"> '.$row['name'].'</td>
                <td> <span class="folder-list-item">'.$row['size'].'</td>
                <td> <button type="button" class="btn btn-primary edit-dir" name="'.$row['name'].'" id="'.$row['id'].'">Update<span></td>
                <td> <button type="button" class="btn btn-danger delete-dir" name="'.$row['name'].'" id="'.$row['id'].'">Delete<span></td>
                    <td> <span class="folder-list-item">'.$row['type'].'</td></tr>';    
            }
        }
        $data = ['status'=>'success','data'=>$li];
    }else{
        $li = '<td colspan="5" class="folder-list-item"> No Folder Found!.<td>';
        $data = ['status'=>'success','data'=>$li];        
    }
    echo json_encode($data);
}

if($_POST['action'] == 'updateDir'){
    $folder_name = $_POST['foldername'];
    $id = $_POST['updateId'];
    $sql = "UPDATE folders SET `name` = '".$folder_name."' WHERE `id` = '".$id."'";
    $result = mysqli_query($con, $sql);
    $data = ['status'=>'success'];
    echo json_encode($data);
}
if($_POST['action'] == 'deleteId'){
    $did = $_POST['did'];
    function deleteFiles($con,$did){
        $folder_id = $did;
    
        $sql = mysqli_query($con,"select id from folders where folder_id = $folder_id");
        if(mysqli_num_rows($sql) > 0){ 
            
            while($row = mysqli_fetch_assoc($sql)){
                deleteFiles($con , $row['id']);
            }
        }
        $sql = mysqli_query($con,"delete from folders where id =$folder_id");
        // $result=$con->query($sql);
     }

     deleteFiles($con,$did);
}

?>
