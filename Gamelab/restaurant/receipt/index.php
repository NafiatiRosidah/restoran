<?php
include("../layout/header.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM receipts WHERE user_id = $user_id";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

?>

<?php
if(isset($_GET['error'])) {
?>
    <div class="alert alert-danger">
    <?= $_GET['error']; ?>
    </div>
<?php
}
if(isset($_GET['success'])) {
?>
    <div class="alert alert-success">
    <?= $_GET['success']; ?>
    </div>
<?php
}
?>

<div class="container mt-4">
    <h1 class="text-center">Receipt List</h1>

    <a href="form.php" class="btn btn-primary my-3" style="width:100px">Add</a>

    <div class="table-responsive">
        <table id="data" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['receipt_date']; ?></td>
                        <td><?= $row['customer_name']; ?></td>
                        <td class="text-end"><?= $row['tax']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td><?= $row['user_id']; ?></td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="form.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                <form action="delete-process.php" method="post" onsubmit="return confirm('Anda yakin menghapus data ini?');">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include("../layout/footer.php");
?>
