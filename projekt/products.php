<?php
// Zahrňte potrebné súbory pre databázu a triedu Produkt
include_once 'classes/Db_connection.php';
include_once 'classes/Product.php';
include_once 'parts/head.php';
include_once 'parts/nav.php';

// Vytvorte pripojenie k databáze a objekt Produkt
$db = new Db_connection();
$conn = $db->connect();
$product = new Product($conn);

// Spracovanie odstránenia produktu, ak bola požiadavka odoslaná cez POST
if (isset($_POST['delete'])) {
    $productId = $_POST['delete'];

    // Overte ID produktu
    if (is_numeric($productId)) {
        // Zavolajte metódu na odstránenie z triedy Produkt
        if ($product->delete($productId)) {
            // Skrytý úspech, bez zobrazenia správy
        } else {
            // Skrytá chyba, bez zobrazenia správy
        }
    }
    exit(); // Ukončte spracovanie
}

// Vykonajte dotaz na získanie všetkých produktov
$sql = "SELECT id, product_name, units_sold, in_stock, expire_date FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<body id="reportsPage" class="bg02">
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
                        <h2 class="tm-block-title d-inline-block">Produkty</h2>
                    </div>
                    <div class="col-md-4 col-sm-12 text-right">
                        <a href="add-product.php" class="btn btn-small btn-primary">Pridať nový produkt</a>
                    </div>
                </div>

                <!-- Formulár pre hromadné odstránenie -->
                <form id="bulk-delete-form" method="POST" action="bulk-delete.php">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped tm-table-striped-even mt-3">
                            <thead>
                            <tr class="tm-bg-gray">
                                <th scope="col">
                                    <input type="checkbox" id="select-all" aria-label="Vybrať všetky">
                                </th>
                                <th scope="col">Názov produktu</th>
                                <th scope="col" class="text-center">Predané jednotky</th>
                                <th scope="col" class="text-center">Na sklade</th>
                                <th scope="col">Dátum expirácie</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <th scope="row">
                                            <input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>" aria-label="Zaškrtávacie políčko">
                                        </th>
                                        <td class="tm-product-name"><?php echo htmlspecialchars($row['product_name']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['units_sold']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['in_stock']); ?></td>
                                        <td><?php echo htmlspecialchars($row['expire_date']); ?></td>
                                        <td>
                                            <!-- Tlačidlo na úpravu -->
                                            <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="text-primary">
                                                <i class="fas fa-edit tm-edit-icon"></i>
                                            </a>
                                            <!-- Tlačidlo na odstránenie -->
                                            <i class="fas fa-trash-alt tm-trash-icon delete-product" data-id="<?php echo $row['id']; ?>"></i>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Žiadne produkty sa nenašli</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tm-table-mt tm-table-actions-row">
                        <div class="tm-table-actions-col-left">
                            <button type="submit" class="btn btn-danger">Odstrániť vybrané položky</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once 'parts/footer.php'; ?>
</div>

<!-- Skripty -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    // Funkcionalita zaškrtávacieho políčka "Vybrať všetky"
    document.getElementById('select-all').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        for (const checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    // Potvrdenie o hromadnom odstránení (bez potvrdenia)
    document.getElementById('bulk-delete-form').addEventListener('submit', function (e) {
        // Odstránime potvrdenie o hromadnom odstránení
        e.preventDefault(); // Dočasne zabrániť odeslání
        this.submit(); // Po odstránení potvrdenia odošleme formulár bez akýchkoľvek otázok
    });

    // Odstránenie jednotlivého produktu (bez potvrdenia)
    document.querySelectorAll('.delete-product').forEach((icon) => {
        icon.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');

            // Odoslanie požiadavky DELETE cez AJAX (bez zobrazenia správy)
            $.ajax({
                url: 'products.php',  // Správna stránka pre spracovanie
                type: 'POST',
                data: {
                    delete: productId,  // Posielame ID produktu na odstránenie
                },
                success: function(response) {
                    location.reload();  // Po úspešnom odstránení reload stránky bez zobrazenia správy
                },
                error: function() {
                    // Zobrazí sa len v prípade chyby
                    alert("Vyskytla sa chyba pri odstraňovaní produktu.");
                }
            });
        });
    });
</script>
</body>

</html>

<?php
// Zavrite pripojenie k databáze po dokončení vykonávania skriptu
$db->close();
?>?>