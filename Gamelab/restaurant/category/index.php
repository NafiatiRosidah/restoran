<?php
include("../layout/header.php");

$sql = "select * from categories";
$query = mysqli_query($db, $sql);
?>

<h1>categories</h1>
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
<a href="form.php" class="btn btn-primary my 3"> Add </a>


<table id="my-datatables" class="table  table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Note</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
            $i = 1;
while($categories = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $categories["name"]; ?></td>
            <td><?= $categories["note"]; ?></td>
            <td>
            <div class="d-flex">
                        <a href="form.php?id=<?= $categories["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?= $categories["id"]; ?>">
                            <button type="submit" name="submit" onclick="return confirm('Anda yakin menghapus data ini?');" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        </div>
            </td>
        </tr>
        <?php
        $i++;
}?>
    </tbody>
</table>
     

 <?php include("../layout/footer.php");