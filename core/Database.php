<?php
class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require BASE_PATH . '/config/database.php';
            $driver = $config['driver'] ?? 'mysql';

            if ($driver === 'mysql') {
                $db = $config['mysql'];

                // Ensure database exists
                try {
                    $serverDsn = "mysql:host={$db['host']};port={$db['port']};charset={$db['charset']}";
                    $serverPdo = new PDO($serverDsn, $db['username'], $db['password']);
                    $serverPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$db['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                } catch (PDOException $e) {
                    // Continue if already exists
                }

                $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['dbname']};charset={$db['charset']}";
                self::$instance = new PDO($dsn, $db['username'], $db['password'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);

                self::ensureTables();
            } else {
                $path = $config['sqlite']['path'];
                $dir = dirname($path);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $isNew = !file_exists($path);
                self::$instance = new PDO("sqlite:" . $path);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                if ($isNew || filesize($path) === 0) {
                    self::initializeSchema();
                }
            }
        }

        return self::$instance;
    }

    private static function ensureTables(): void
    {
        try {
            $stmt = self::$instance->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() === 0) {
                self::initializeSchema();
            }
        } catch (Exception $e) {
            self::initializeSchema();
        }
    }

    public static function initializeSchema(): void
    {
        $schemaFile = BASE_PATH . '/database/schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            self::$instance->exec($sql);
            self::seedInitialData();
        }
    }

    public static function seedInitialData(): void
    {
        $pdo = self::$instance;
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch()['count'] ?? 0;

        if ($count == 0) {
            $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
            $staffPass = password_hash('staff123', PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['System Administrator', 'admin@erp.com', $adminPass, 'admin', 'active']);
            $stmt->execute(['Sales Staff', 'staff@erp.com', $staffPass, 'staff', 'active']);

            $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone, company, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['Acme Industrial', 'contact@acme.com', '+1-555-0101', 'Acme Corp', '100 Industrial Way, NY']);
            $stmt->execute(['Global Retailers', 'orders@globalretail.com', '+1-555-0102', 'Global Retail Ltd', '250 Market Blvd, CA']);

            $stmt = $pdo->prepare("INSERT INTO suppliers (name, contact_person, email, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['Apex Electronics Supplier', 'John Miller', 'sales@apexelectronics.com', '+1-555-0201', '77 Silicon Valley Rd']);
            $stmt->execute(['Office Superstore Logistics', 'Karen Lee', 'info@officesuper.com', '+1-555-0202', '404 Supply Chain Ave']);

            $stmt = $pdo->prepare("INSERT INTO items (code, name, category, unit, unit_price, cost_price, stock_quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(['ITM-001', 'Enterprise Laptop i7', 'Electronics', 'pcs', 899.99, 600.00, 20]);
            $stmt->execute(['ITM-002', 'Wireless Mechanical Keyboard', 'Electronics', 'pcs', 79.99, 45.00, 60]);
            $stmt->execute(['ITM-003', 'Ergonomic Mesh Chair', 'Furniture', 'pcs', 199.00, 120.00, 15]);
            $stmt->execute(['ITM-004', 'Laser Printer Toner Box', 'Supplies', 'box', 35.00, 18.00, 50]);

            $stmt = $pdo->prepare("INSERT INTO sales_invoices (invoice_number, customer_id, invoice_date, due_date, total_amount, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(['INV-2026-0001', 1, date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), 979.98, 'paid', 'Standard Net 30 payment terms']);

            $stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, item_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([1, 1, 1, 899.99, 899.99]);
            $stmt->execute([1, 2, 1, 79.99, 79.99]);
        }
    }
}
