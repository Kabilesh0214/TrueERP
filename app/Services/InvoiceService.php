<?php
class InvoiceService
{
    private SalesInvoice $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new SalesInvoice();
    }

    public function generateInvoiceNumber(): string
    {
        $count = $this->invoiceModel->count() + 1;
        return 'INV-' . date('Y') . '-' . str_pad((string)$count, 4, '0', STR_PAD_LEFT);
    }

    public function createInvoice(int $customerId, array $itemsData, ?string $dueDate = null, ?string $notes = null): int|string
    {
        $totalAmount = 0.0;
        $lineItems = [];

        foreach ($itemsData as $item) {
            $qty = (int)$item['quantity'];
            $price = (float)$item['unit_price'];
            $lineTotal = $qty * $price;
            $totalAmount += $lineTotal;

            $lineItems[] = [
                'item_id'     => (int)$item['item_id'],
                'quantity'    => $qty,
                'unit_price'  => $price,
                'total_price' => $lineTotal,
            ];
        }

        $invoiceData = [
            'invoice_number' => $this->generateInvoiceNumber(),
            'customer_id'    => $customerId,
            'invoice_date'   => date('Y-m-d'),
            'due_date'       => $dueDate ?: date('Y-m-d', strtotime('+30 days')),
            'total_amount'   => $totalAmount,
            'status'         => 'pending',
            'notes'          => $notes,
        ];

        return $this->invoiceModel->createInvoice($invoiceData, $lineItems);
    }
}
