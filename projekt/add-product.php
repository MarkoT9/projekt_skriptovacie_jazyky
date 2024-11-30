<?php
// Zahrňte pripojenie k databáze a triedu produktov
include_once 'classes/Db_connection.php';
include_once 'classes/Product.php';

// Skontrolujte, či bol formulár odoslaný
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Získajte údaje z formulára
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $expireDate = $_POST['expire_date'];
    $inStock = $_POST['in_stock'];

    $db = new Db_connection();
    $conn = $db->connect();
    $product = new Product($conn);

    // Vložte nový produkt do databázy
    $result = $product->create($productName ,$category ,$description ,$inStock ,0 ,$expireDate);  // Predpokladáme, že jednotky predané sú na začiatku 0

    if ($result) {
        echo "Produkt bol úspešne pridaný!";
        header('Location: products.php');  // Presmerovanie na stránku produktov po úspechu
        exit;
    } else {
        echo "Chyba: Nepodarilo sa pridať produkt.";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
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
                        <h2 class="tm-block-title d-inline-block">Pridať produkt</h2>
                    </div>
                </div>
                <div class="row mt-4 tm-edit-product-row">
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <form action="add-product.php" method="POST" class="tm-edit-product-form">
                            <div class="input-group mb-3">
                                <label for="name" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Názov produktu</label>
                                <input id="name" name="product_name" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="description" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mb-2">Popis</label>
                                <textarea class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" name="description" rows="3" required></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label for="category" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Kategória</label>
                                <select class="custom-select col-xl-9 col-lg-8 col-md-8 col-sm-7" name="category" required>
                                    <option value="">Vyberte jednu</option>
                                    <option value="Oblečenie">Oblečenie</option>
                                    <option value="Elektronika">Elektronika</option>
                                    <option value="Nábytok">Nábytok</option>
                                    <option value="Kuchynské potreby">Kuchynské potreby</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="expire_date" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Dátum expirácie</label>
                                <input id="expire_date" name="expire_date" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="stock" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Jednotky na sklade</label>
                                <input id="stock" name="in_stock" type="number" class="form-control validate col-xl-9 col-lg-8 col-md-7 col-sm-7" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="ml-auto col-xl-8 col-lg-8 col-md-8 col-sm-7 pl-0">
                                    <button type="submit" class="btn btn-primary">Pridať</button>
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
        // Inicializujte jQuery UI datepicker na poli expire_date
        $('#expire_date').datepicker({
            dateFormat: 'yy-mm-dd'  // Formátujte dátum na yyyy-mm-dd
        });
    });
</script>
</body>
</html>