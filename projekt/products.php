<?php
require_once 'classes/Db_connection.php';

$db = new Db_connection();
$conn = $db->connect();

$sql = "SELECT id, product_name, units_sold, in_stock, expire_date FROM products";
$result = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Products Page - Dashboard Template</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">
        <link rel="stylesheet" href="css/fontawesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/tooplate.css">
    </head>

    <body id="reportsPage" class="bg02">
    <div id="home">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-xl navbar-light bg-light">
                        <a class="navbar-brand" href="index.html">
                            <i class="fas fa-3x fa-tachometer-alt tm-site-icon"></i>
                            <h1 class="tm-site-title mb-0">Dashboard</h1>
                        </a>
                        <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item"><a class="nav-link" href="index.html">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="products.html">Products</a></li>
                                <li class="nav-item"><a class="nav-link" href="accounts.html">Accounts</a></li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link d-flex" href="login.html">
                                        <i class="far fa-user mr-2 tm-logout-icon"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
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

            <footer class="row tm-mt-small">
                <div class="col-12 font-weight-light">
                    <p class="d-inline-block tm-bg-black text-white py-2 px-4">
                        Copyright &copy; 2024 Admin Dashboard. Created by
                        <a rel="nofollow" href="https://www.tooplate.com" class="text-white tm-footer-link">Tooplate</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('.tm-product-name').on('click', function () {
                window.location.href = "edit-product.html";
            });
        });
    </script>
    </body>

    </html>

<?php
$db->close();
?>