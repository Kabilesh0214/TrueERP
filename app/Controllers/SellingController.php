<?php
class SellingController extends Controller
{
    public function index(): string
    {
        $salesModel    = new SalesInvoice();
        $customerModel = new Customer();
        $itemModel     = new Item();

        $invoices  = $salesModel->allWithCustomer();
        $customers = $customerModel->all();
        $items     = $itemModel->all();

        $totalRevenue = 0.0;
        foreach ($invoices as $inv) {
            $totalRevenue += (float)($inv['total_amount'] ?? 0);
        }

        return $this->view('selling.index', [
            'invoices'     => $invoices,
            'customers'    => $customers,
            'items'        => $items,
            'totalRevenue' => $totalRevenue,
            'totalOrders'  => count($invoices),
        ]);
    }
}
