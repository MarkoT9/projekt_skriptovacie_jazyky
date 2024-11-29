<?php
require_once 'classes/Db_connection.php';

$db = new Db_connection();
$conn = $db->connect();

$sql = "SELECT id, product_name, units_sold, in_stock, expire_date FROM products";
$result = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html lang="en">

<?php
include_once 'parts/head.php';
include_once 'parts/nav.php';
?>

    <body id="reportsPage" class="bg02">
    <div id="home">
        <div class="container">
            <div class="row">
                <div class="col-12">
                </div>
            </div>

            <div class="row tm-content-row tm-mt-big">
                <div class="col-xl-8 col-lg-12 tm-md-12 tm-sm-12 tm-col">
                    <div class="bg-white tm-block h-100">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <h2 class="tm-block-title d-inline-block">Products</h2>
                            </div>
                            <div class="col-md-4 col-sm-12 text-right">
                                <a href="add-product.php" class="btn btn-small btn-primary">Add New Product</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped tm-table-striped-even mt-3">
                                <thead>
                                <tr class="tm-bg-gray">
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col" class="text-center">Units Sold</th>
                                    <th scope="col" class="text-center">In Stock</th>
                                    <th scope="col">Expire Date</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <th scope="row">
                                                <input type="checkbox" aria-label="Checkbox">
                                            </th>
                                            <td class="tm-product-name"><?php echo htmlspecialchars($row['product_name']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($row['units_sold']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($row['in_stock']); ?></td>
                                            <td><?php echo htmlspecialchars($row['expire_date']); ?></td>
                                            <td><i class="fas fa-trash-alt tm-trash-icon"></i></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No products found</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tm-table-mt tm-table-actions-row">
                            <div class="tm-table-actions-col-left">
                                <button class="btn btn-danger">Delete Selected Items</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include_once 'parts/footer.php';
            ?>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('.tm-product-name').on('click', function () {
                window.location.href = "edit-product.php";
            });
        });
    </script>
    </body>

    </html>

<?php
$db->close();
?>