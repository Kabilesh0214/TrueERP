<?php
class BuyingController extends Controller
{
    public function index(): string
    {
        $poModel       = new PurchaseOrder();
        $supplierModel = new Supplier();

        $purchaseOrders = $poModel->all();
        $suppliers      = $supplierModel->all();

        $supplierMap = [];
        foreach ($suppliers as $s) {
            $supplierMap[$s['id']] = $s['name'];
        }

        $totalSpend = 0.0;
        $openOrders = 0;
        foreach ($purchaseOrders as $po) {
            $totalSpend += (float)($po['total_amount'] ?? 0);
            if (($po['status'] ?? '') !== 'Received') {
                $openOrders++;
            }
        }

        return $this->view('buying.index', [
            'purchaseOrders' => $purchaseOrders,
            'suppliers'      => $suppliers,
            'supplierMap'    => $supplierMap,
            'totalSpend'     => $totalSpend,
            'openOrders'     => $openOrders,
        ]);
    }

    public function storePO(): void
    {
        $poModel = new PurchaseOrder();
        $amount = (float)($this->request->post('total_amount') ?? 0);

        $poNumber = 'PO-' . date('Y') . '-' . str_pad((string)(count($poModel->all()) + 1), 3, '0', STR_PAD_LEFT);

        $poModel->create([
            'po_number'    => $poNumber,
            'supplier_id'  => $this->request->post('supplier_id'),
            'order_date'   => $this->request->post('order_date') ?: date('Y-m-d'),
            'status'       => $this->request->post('status') ?: 'Ordered',
            'total_amount' => $amount,
            'notes'        => $this->request->post('notes') ?: '',
        ]);

        $this->session->flash('success', "Purchase Order {$poNumber} created successfully.");
        $this->redirect('/buying');
    }
}
