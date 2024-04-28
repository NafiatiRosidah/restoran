<?php
include("../config/database.php");

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $note = $_POST['note']; // Tambahkan ini untuk mendapatkan nilai 'note' dari form
    // Ganti 'categoriesname' menjadi 'note' karena tidak ada kolom 'categoriesname' dalam tabel 'categories'
    
    try{
        if($id){
            $sql ="UPDATE categories SET name='$name', note='$note' WHERE id=$id"; // Perbaikan sintaks SQL
        }else{
            $sql ="INSERT INTO categories (name, note) VALUES ('$name', '$note')"; // Perbaikan sintaks SQL
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
