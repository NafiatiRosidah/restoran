<?php
include ("../layout/header.php");

$id = isset($_GET['id'])? $_GET['id']: 0;

$sql = "SELECT * FROM menus WHERE id=$id";
$result = mysqli_query($db, $sql);
$menus = $result->num_rows > 0 ? mysqli_fetch_assoc($result): null;

// Query untuk mengambil data kategori
$category_query = mysqli_query($db, "SELECT * FROM categories");
?>

<h2 style="color: grey;" class="text-center"><?= $id ? "EDIT" : "ADD"; ?> MENUS</h2>

<form action="post-process.php" method="POST">
    <div class="row">
        <input type="hidden" name="id" value="<?= $id ; ?>">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $menus ? $menus['name'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="text" class="form-control" name="note" value="<?= $menus ? $menus['note'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="Aktif" <?= ($menus && $menus['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="Non Aktif" <?= ($menus && $menus['status'] == 'Non Aktif') ? 'selected' : ''; ?>>Non Aktif</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <?php
                    while ($category = mysqli_fetch_assoc($category_query)) {
                        $selected = ($menus && $menus['category_id'] == $category['id']) ? 'selected' : '';
                        echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" name="price" value="<?= $menus ? $menus['price'] : 0; ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" name="submit" class="btn btn-primary"><?= $id ? "Update" : "Add"; ?></button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?php
include ("../layout/footer.php");
?>
