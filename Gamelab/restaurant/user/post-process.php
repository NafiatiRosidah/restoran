<?php

include("../config/database.php");

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    try{
        if($id){
            $sql ="update users set name='$name', username='$username', 
            password='$password' where id=$id"; 
        }else{
        $sql ="insert into users(name, username, password)values('$name',
        '$username','$password')";
        }
        $result = mysqli_query($db, $sql);
    
        if($result){
            header("Location: index.php?success=Eksekusi data success");
        }else{
            header("Location: index.php?error=Eksekusi data error.");
        }

    } catch(Exception $exception) {
        header("Location: index.php?error=" . $exception->getMessage()); 

    }
    
}
?>