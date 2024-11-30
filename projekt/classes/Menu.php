<?php
include_once 'Db_connection.php';

class Menu
{
    private $menuData; // Premenná pre uloženie údajov o menu
    private $dbConnection; // Premenná pre pripojenie k databáze

    public function __construct()
    {
        $this->dbConnection = new Db_connection(); // Vytvorenie pripojenia k databáze
        $this->loadData(); // Načítanie údajov o menu
    }

    // Načítanie údajov o menu z databázy alebo použití záložného JSON súboru
    public function loadData()
    {
        $conn = $this->dbConnection->connect(); // Pripojenie k databáze

        // Pokus o získanie údajov z databázy
        if ($conn) {
            $sql = "SELECT name, url FROM menu";  // Dotaz na databázu pre položky menu
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $this->menuData = []; // Inicializácia poľa pre údaje o menu
                while ($row = $result->fetch_assoc()) {
                    // Načítanie iba stĺpcov 'name' a 'url'
                    $this->menuData[] = [
                        'name' => $row['name'],
                        'url' => $row['url']
                    ];
                }
                // Uloženie údajov o menu do JSON súboru
                $this->saveDataToFile();
            } else {
                // Ak neboli nájdené žiadne údaje v databáze, použije sa záložný JSON
                $this->loadDataFromFile();
            }
        } else {
            // Ak sa nepodarilo pripojiť k databáze, načíta sa data zo súboru JSON
            $this->loadDataFromFile();
        }

        // Ak sú údaje o menu stále prázdne, použije sa záložné menu
        if (empty($this->menuData)) {
            $this->loadHardcodedMenu(); // Načítanie pevne zakódovaného menu
        }

        $this->dbConnection->close(); // Zatvorenie pripojenia k databáze
    }

    // Načítanie údajov o menu zo súboru JSON ako nahradné riešenie
    private function loadDataFromFile()
    {
        if (file_exists("menu.json")) {
            $this->menuData = json_decode(file_get_contents("menu.json"), true); // Načítanie údajov zo súboru JSON
        } else {
            $this->menuData = []; // Ak súbor neexistuje, nastavenie prázdneho poľa
        }
    }

    // Uloženie údajov do JSON súboru
    public function saveDataToFile()
    {
        // Uloženie údajov o menu do JSON súboru
        file_put_contents("menu.json", json_encode($this->menuData, JSON_PRETTY_PRINT));
    }

    // Pevne zakódované údaje o menu, ktoré sa použijú ako posledné záložné riešenie
    private function loadHardcodedMenu()
    {
        $this->menuData = [
            [
                'name' => 'Dashboard',  // Názov položky menu
                'url' => 'index.php'    // URL položky menu
            ],
            [
                'name' => 'Products',
                'url' => 'products.php'
            ],
            [
                'name' => 'Accounts',
                'url' => 'accounts.php'
            ]
        ];
    }

    // Získanie údajov o menu (na zobrazenie)
    public function getMenuData()
    {
        return $this->menuData; // Vrátenie údajov o menu
    }
}
?>