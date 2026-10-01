<?php
class DashboardController extends Controller
{
    public function index(): string
    {
        $userModel     = new User();
        $customerModel = new Customer();
        $supplierModel = new Supplier();
        $itemModel     = new Item();
        $salesModel    = new SalesInvoice();

        $stats = [
            'total_users'     => $userModel->count(),
            'total_customers' => $customerModel->count(),
            'total_suppliers' => $supplierModel->count(),
            'total_items'     => $itemModel->count(),
            'total_sales'     => $salesModel->count(),
        ];

        $recentSales = $salesModel->allWithCustomer();
        $recentSales = array_slice($recentSales, 0, 5);

        return $this->view('dashboard.index', [
            'user'        => $this->session->get('user'),
            'stats'       => $stats,
            'recentSales' => $recentSales,
        ]);
    }
}
