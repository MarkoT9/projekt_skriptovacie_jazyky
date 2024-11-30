<!DOCTYPE html>
<html lang="en">

<?php
include_once 'parts/head.php';
include_once 'parts/nav.php';
require_once 'classes/Db_connection.php';
require_once 'classes/Product.php';

// Inicializacia databazy
$db = new Db_connection();
$conn = $db->connect();
$product = new Product($conn);

// Top produkty
$topProducts = $product->readTopProducts(10);
?>

<body id="reportsPage">
<div class="" id="home">
    <div class="container">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
        <!-- row -->
        <div class="row tm-content-row tm-mt-big">
            <div class="tm-col tm-col-big">
                <div class="bg-white tm-block h-100">
                    <h2 class="tm-block-title">Latest Hits</h2>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="tm-col tm-col-big">
                <div class="bg-white tm-block h-100">
                    <h2 class="tm-block-title">Performance</h2>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="tm-col tm-col-small">
                <div class="bg-white tm-block h-100">
                    <canvas id="pieChart" class="chartjs-render-monitor"></canvas>
                </div>
            </div>

            <div class="tm-col tm-col-big">
                <div class="bg-white tm-block h-100">
                    <div class="row">
                        <div class="col-8">
                            <h2 class="tm-block-title d-inline-block">Top Product List</h2>

                        </div>
                        <div class="col-4 text-right">
                            <a href="products.php" class="tm-link-black">View All</a>
                        </div>
                    </div>
                    <ol class="tm-list-group tm-list-group-alternate-color tm-list-group-pad-big">
                        <?php if (!empty($topProducts)): ?>
                            <?php foreach ($topProducts as $product): ?>
                                <li class="tm-list-group-item">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                    <span class="text-muted">(Predané: <?php echo $product['units_sold']; ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="tm-list-group-item">No products found</li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
            <div class="tm-col tm-col-big">
                <div class="bg-white tm-block h-100">
                    <h2 class="tm-block-title">Calendar</h2>
                    <div id="calendar"></div>
                    <div class="row mt-4">
                        <div class="col-12 text-right">
                            <a href="#" class="tm-link-black">View Schedules</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tm-col tm-col-small">
                <div class="bg-white tm-block h-100">
                    <h2 class="tm-block-title">Upcoming Tasks</h2>
                    <ol class="tm-list-group">
                        <li class="tm-list-group-item">List of tasks</li>
                        <li class="tm-list-group-item">Lorem ipsum doloe</li>
                        <li class="tm-list-group-item">Read reports</li>
                        <li class="tm-list-group-item">Write email</li>

                        <li class="tm-list-group-item">Call customers</li>
                        <li class="tm-list-group-item">Go to meeting</li>
                        <li class="tm-list-group-item">Weekly plan</li>
                        <li class="tm-list-group-item">Ask for feedback</li>

                        <li class="tm-list-group-item">Meet Supervisor</li>
                        <li class="tm-list-group-item">Company trip</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'parts/footer.php';
?>
</body>
</html>