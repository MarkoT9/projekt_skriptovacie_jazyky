<?php
// Zahrňte pripojenie k databáze a triedu produktov
require_once 'classes/Db_connection.php';
require_once 'classes/Product.php';

// Uistite sa, že ID produktu je odoslané v URL (napr. edit-product.php?id=1)
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Vytvorte nové pripojenie k databáze
    $db = new Db_connection();
    $conn = $db->connect();
    $product = new Product($conn);

    // Načítajte údaje o produkte z databázy
    $productData = $product->readOne($productId);

    // Skontrolujte, či produkt existuje
    if (!$productData) {
        echo "Produkt nenájdený.";
        exit;
    }
} else {
    echo "ID produktu chýba.";
    exit;
}

// Spracujte odoslanie formulára na aktualizáciu produktu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získajte údaje z formulára
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $expireDate = $_POST['expire_date'];
    $inStock = $_POST['in_stock'];
    $unitsSold = $_POST['units_sold'];  // Získajte predané jednotky

    // Zavolajte metódu na aktualizáciu
    $result = $product->update($productId, $productName, $category, $description, $inStock, $unitsSold, $expireDate);  // Predané jednotky sú teraz zahrnuté

    if ($result) {
        echo "Produkt bol úspešne aktualizovaný!";
        header('Location: products.php');  // Presmerovanie na stránku produktov po úspechu
        exit;
    } else {
        echo "Chyba: Nepodarilo sa aktualizovať produkt.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include_once 'parts/head.php';
include_once 'parts/nav.php';
?>

<body class="bg02">
<div class="container">
    <div class="row">
        <div class="col-12">
        </div>
    </div>

    <div class="row tm-mt-big">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12">
            <div class="bg-white tm-block">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title d-inline-block">Upravit produkt</h2>
                    </div>
                </div>
                <div class="row mt-4 tm-edit-product-row">
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <form action="edit-product.php?id=<?php echo $productId; ?>" method="POST" class="tm-edit-product-form">
                            <div class="input-group mb-3">
                                <label for="name" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Názov produktu</label>
                                <input id="name" name="product_name" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" value="<?php echo htmlspecialchars($productData['product_name']); ?>" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="description" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mb-2">Popis</label>
                                <textarea class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" name="description" rows="3" required><?php echo htmlspecialchars($productData['description']); ?></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label for="category" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Kategória</label>
                                <select class="custom-select col-xl-9 col-lg-8 col-md-8 col-sm-7" name="category" required>
                                    <option value="">Vyberte jednu</option>
                                    <option value="Oblečenie" <?php echo $productData['category'] == 'Oblečenie' ? 'selected' : ''; ?>>Oblečenie</option>
                                    <option value="Elektronika" <?php echo $productData['category'] == 'Elektronika' ? 'selected' : ''; ?>>Elektronika</option>
                                    <option value="Nábytok" <?php echo $productData['category'] == 'Nábytok' ? 'selected' : ''; ?>>Nábytok</option>
                                    <option value="Kuchynské potreby" <?php echo $productData['category'] == 'Kuchynské potreby' ? 'selected' : ''; ?>>Kuchynské potreby</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="expire_date" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Dátum expirácie</label>
                                <input id="expire_date" name="expire_date" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" value="<?php echo htmlspecialchars($productData['expire_date']); ?>" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="stock" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Počet kusov na sklade</label>
                                <input id="stock" name="in_stock" type="number" class="form-control validate col-xl-9 col-lg-8 col-md-7 col-sm-7" value="<?php echo htmlspecialchars($productData['in_stock']); ?>" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="units_sold" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Predané jednotky</label>
                                <input id="units_sold" name="units_sold" type="number" class="form-control validate col-xl-9 col-lg-8 col-md-7 col-sm-7" value="<?php echo htmlspecialchars($productData['units_sold']); ?>" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="ml-auto col-xl-8 col-lg-8 col-md-8 col-sm-7 pl-0">
                                    <button type="submit" class="btn btn-primary">Aktualizovať</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once 'parts/footer.php';
    ?>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="jquery-ui-datepicker/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(function () {
        // Inicializujte jQuery UI datepicker pre pole expire_date
        $('#expire_date').datepicker({
            dateFormat: 'yy-mm-dd'  // Nastavte formát dátumu na yyyy-mm-dd
        });
    });
</script>
</body>
</html>