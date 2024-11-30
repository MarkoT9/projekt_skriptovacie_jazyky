<?php
require_once 'Db_connection.php';

class Product {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Vytvor produkt
    public function create($productName, $category, $description, $inStock, $unitsSold, $expireDate) {
        // Priprav SQL dopyt s ďalšími polami
        $stmt = $this->conn->prepare(
            "INSERT INTO products (product_name, category, description, in_stock, units_sold, expire_date) 
        VALUES (?, ?, ?, ?, ?, ?)"
        );

        // Pripoj parametre a zabezpeč správne typy pre každé pole
        $stmt->bind_param("sssiis", $productName, $category, $description, $inStock, $unitsSold, $expireDate);

        // Spusti dopyt a vráť výsledok
        return $stmt->execute();
    }

    // Zobraz všetky produkty
    public function readAll() {
        $sql = "SELECT * FROM products";
        return $this->conn->query($sql);
    }

    // Zobraz produkt podľa id
    public function readOne($id) {
        $stmt = $this->conn->prepare("SELECT id, product_name, category, description, units_sold, in_stock, expire_date FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Aktualizuj produkt
    public function update($id, $productName, $category, $description, $inStock, $unitsSold, $expireDate) {
        $stmt = $this->conn->prepare(
            "UPDATE products 
         SET product_name = ?, 
             category = ?, 
             description = ?, 
             in_stock = ?, 
             units_sold = ?, 
             expire_date = ? 
         WHERE id = ?"
        );
        $stmt->bind_param("sssiisi", $productName, $category, $description, $inStock, $unitsSold, $expireDate, $id);
        return $stmt->execute();
    }

    // Vymaž produkt
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Zobraz top produkty
    public function readTopProducts($limit) {
        $stmt = $this->conn->prepare("SELECT product_name, units_sold FROM products ORDER BY units_sold DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $topProducts = [];
        while ($row = $result->fetch_assoc()) {
            $topProducts[] = $row;
        }
        return $topProducts;
    }
}
?>