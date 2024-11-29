<?php
require_once 'classes/Db_connection.php';
require_once 'classes/Product.php';

$db = new Db_connection();
$conn = $db->connect();
$product = new Product($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $selectedIds = $_POST['selected_ids'];

    foreach ($selectedIds as $id) {
        $product->delete($id);
    }

    // Navrat po vymazani
    header("Location: products.php");
    exit();
} else {
    // Navrat ak nie id
    header("Location: products.php?error=No items selected");
    exit();
}
?>