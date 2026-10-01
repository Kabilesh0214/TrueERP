<?php
class SalesInvoice extends Model
{
    protected string $table = 'sales_invoices';

    public function allWithCustomer(): array
    {
        $sql = "SELECT s.*, c.name as customer_name, c.company as customer_company 
                FROM sales_invoices s 
                LEFT JOIN customers c ON s.customer_id = c.id 
                ORDER BY s.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function findWithDetails(int|string $id): ?array
    {
        $sql = "SELECT s.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address
                FROM sales_invoices s 
                LEFT JOIN customers c ON s.customer_id = c.id 
                WHERE s.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $invoice = $stmt->fetch();
        if (!$invoice) return null;

        $itemsSql = "SELECT ii.*, i.name as item_name, i.code as item_code 
                     FROM invoice_items ii 
                     LEFT JOIN items i ON ii.item_id = i.id 
                     WHERE ii.invoice_id = ?";
        $itemsStmt = $this->db->prepare($itemsSql);
        $itemsStmt->execute([$id]);
        $invoice['items'] = $itemsStmt->fetchAll();
        return $invoice;
    }

    public function createInvoice(array $invoiceData, array $lineItems): int|string
    {
        $this->db->beginTransaction();
        try {
            $invoiceId = $this->create($invoiceData);
            $stmt = $this->db->prepare("INSERT INTO invoice_items (invoice_id, item_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
            $updateStock = $this->db->prepare("UPDATE items SET stock_quantity = stock_quantity - ? WHERE id = ?");

            foreach ($lineItems as $item) {
                $stmt->execute([$invoiceId, $item['item_id'], $item['quantity'], $item['unit_price'], $item['total_price']]);
                $updateStock->execute([$item['quantity'], $item['item_id']]);
            }

            $this->db->commit();
            return $invoiceId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
