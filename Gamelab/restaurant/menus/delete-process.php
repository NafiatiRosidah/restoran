<?php

include("../config/database.php");

if(isset($_POST['delete'])) {

    $id = $_POST['id'];
    try {
        // Nonaktifkan constraint foreign key sementara
        $disable_fk = "SET FOREIGN_KEY_CHECKS=0";
        mysqli_query($db, $disable_fk);

        // Hapus data dari tabel menus
        $sql = "DELETE FROM menus WHERE id='$id'";
        $query = mysqli_query($db, $sql);

        // Aktifkan kembali constraint foreign key
        $enable_fk = "SET FOREIGN_KEY_CHECKS=1";
        mysqli_query($db, $enable_fk);

        if ($query) {
            header('Location: index.php?success=Data berhasil dihapus');
            exit(); // keluar dari skrip setelah menghapus data
        } else {
            header('Location: index.php?error=Data gagal dihapus');
            exit(); // keluar dari skrip jika terjadi kesalahan saat menghapus data
        }
    } catch(Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
        exit(); // keluar dari skrip jika terjadi kesalahan
    }
} else{
    die("Akses dilarang..");
}
?>
