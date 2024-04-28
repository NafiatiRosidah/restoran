<?php

include("../config/database.php");

session_start(); // Mulai sesi

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect jika user tidak login
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM receipts WHERE user_id = $user_id";

$result = mysqli_query($db, $sql);

// Tambahkan penanganan kesalahan
if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$receipts_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $user = $_SESSION['user_id']; // Ubah $user menjadi $_SESSION['user_id']
    $customer = $_POST['customer_name'];
    $status = $_POST['status'];
    $receipt = $_POST['receipt_date'];
    try {
        if($id) {
            $sql = "UPDATE receipts SET user_id='$user', customer_name='$customer', status='$status', receipt_date='$receipt' WHERE id=$id";
        } else {
            $sql = "INSERT INTO receipts(user_id, customer_name, status, receipt_date) VALUES ('$user', '$customer', '$status', '$receipt')";
        }
        $result = mysqli_query($db, $sql);

        if ($result) {
            header("Location: index.php?success=Data tersimpan");
            exit;
        } else {
            header("Location: index.php?error=Data tidak tersimpan");
            exit;
        }
    } catch (Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
        exit;
    }
}

// Menambahkan penanganan form modal
if (isset($_POST['modal_submit'])) {
    $id = $_POST['modal_id'];
    $receipt_id = $_POST['modal_receipt_id'];
    $menu_id = $_POST['modal_menu_id'];
    $note = $_POST['modal_note'];
    $amount = $_POST['modal_amount'];

    try {
        if ($id) {
            // Update detail receipt
            $sql = "UPDATE receipt_details SET menu_id='$menu_id', note='$note', amount='$amount' WHERE id=$id";
        } else {
            // Tambahkan detail receipt baru
            $sql = "INSERT INTO receipt_details(receipt_id, menu_id, note, amount) VALUES ('$receipt_id', '$menu_id', '$note', '$amount')";
        }
        $result = mysqli_query($db, $sql);

        if ($result) {
            header("Location: index.php?success=Data tersimpan");
            exit;
        } else {
            header("Location: index.php?error=Data tidak tersimpan");
            exit;
        }
    } catch (Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
        exit;
    }
}

// Ambil data menu dari tabel 'menus'
$sql_menu = "SELECT * FROM menus";
$result_menu = mysqli_query($db, $sql_menu);
$menu_list = mysqli_fetch_all($result_menu, MYSQLI_ASSOC);

?>
