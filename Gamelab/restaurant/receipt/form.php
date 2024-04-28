<?php
include("../layout/header.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM receipts WHERE id=$id";
$result = mysqli_query($db, $sql);

// Tambahkan penanganan kesalahan
if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$receipts = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;

?>

<div class="container mt-4">
    <?php if ($id == 0) : ?>
    <h1 class="mb-5">Add Receipt</h1>
    <form method="post" action="post-process.php">
        <div class="row">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="customer_name" value="<?= isset($receipts['customer_name']) ? $receipts['customer_name'] : '' ?>" required="">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Entry" <?= (isset($receipts['status']) && $receipts['status'] == 'Entry') ? 'selected' : '' ?>>Entry</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
    <?php else : ?>
    <h1 class="mb-5">Update Receipt</h1>
    <?php if ($receipts) : ?>
    <form method="post" action="post-process.php">
        <div class="row">
            <input type="hidden" name="id" value="<?= $receipts['id'] ?>">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="customer_name" value="<?= isset($receipts['customer_name']) ? $receipts['customer_name'] : '' ?>" required="">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Entry" <?= (isset($receipts['status']) && $receipts['status'] == 'Entry') ? 'selected' : '' ?>>Entry</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

    <hr>
    <h2>Details</h2>
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#detailFormModal">
        Add
    </button>
    <div class="table-responsive">
        <table id="data" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Note</th>
                    <th scope="col">Price</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col" width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-end"><b>0</b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="detailFormModal" aria-labelledby="detailFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailFormModalLabel">Detail Modal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow:hidden;">
                <form method="post" action="post-process.php">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="modal_receipt_id" value="<?= $receipts['id'] ?>">
                            <input type="hidden" name="modal_id">

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Menu</label>
                                <select class="form-select select2-hidden-accessible" name="modal_menu_id" id="select2-modal" data-placeholder="Choose one" data-select2-id="select2-data-select2-modal" tabindex="-1" aria-hidden="true">
                                    <?php foreach ($menu_list as $menu) : ?>
                                        <option value="<?= $menu['id'] ?>"><?= $menu['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <input type="text" class="form-control" name="modal_note">
                            </div>
                            <button type="submit" name="modal_submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <div class=" mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="modal_amount" required="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




</div>
    <?php else : ?>
    <div class="alert alert-danger" role="alert">
        Data tidak ditemukan.
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>


<!-- datatable -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#data').DataTable();

    $('#select2-modal').select2({
        theme: 'bootstrap-5',
        dropdownParent: $("#detailFormModal")
    });
});

function editModalShow(id, menuId, note, amount) {
    document.getElementsByName('modal_id')[0].value = id;
    document.getElementsByName('modal_menus_id')[0].value = menusId;
    document.getElementsByName('modal_note')[0].value = note;
    document.getElementsByName('modal_amount')[0].value = amount;
    $("#select2-modal").val(menuId).trigger("change");
}
</script>

<?php
include("../layout/footer.php");
?>
