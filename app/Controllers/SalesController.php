<?php
class SalesController extends Controller
{
    private SalesInvoice $salesModel;
    private Customer $customerModel;
    private Item $itemModel;
    private InvoiceService $invoiceService;

    public function __construct()
    {
        parent::__construct();
        $this->salesModel     = new SalesInvoice();
        $this->customerModel  = new Customer();
        $this->itemModel      = new Item();
        $this->invoiceService = new InvoiceService();
    }

    public function index(): string
    {
        $invoices = $this->salesModel->allWithCustomer();
        return $this->view('sales.index', [
            'invoices' => $invoices,
            'success'  => $this->session->getFlash('success'),
            'error'    => $this->session->getFlash('error'),
        ]);
    }

    public function create(): string
    {
        $customers = $this->customerModel->all('name ASC');
        $items     = $this->itemModel->all('name ASC');

        return $this->view('sales.create', [
            'customers' => $customers,
            'items'     => $items,
            'error'     => $this->session->getFlash('error'),
        ]);
    }

    public function store(): string
    {
        $customerId = (int)$this->request->post('customer_id');
        $itemIds    = $_POST['item_id'] ?? [];
        $quantities = $_POST['quantity'] ?? [];
        $dueDate    = $this->request->post('due_date');
        $notes      = $this->request->post('notes');

        if (!$customerId || empty($itemIds)) {
            $this->session->flash('error', 'Customer and at least one item are required.');
            return $this->redirect(url('/sales/create'));
        }

        $itemsData = [];
        foreach ($itemIds as $index => $itemId) {
            $qty = (int)($quantities[$index] ?? 1);
            if ($qty > 0 && !empty($itemId)) {
                $item = $this->itemModel->find((int)$itemId);
                if ($item) {
                    $itemsData[] = [
                        'item_id'    => (int)$itemId,
                        'quantity'   => $qty,
                        'unit_price' => (float)$item['unit_price'],
                    ];
                }
            }
        }

        if (empty($itemsData)) {
            $this->session->flash('error', 'Please select valid items with quantity.');
            return $this->redirect(url('/sales/create'));
        }

        try {
            $this->invoiceService->createInvoice($customerId, $itemsData, $dueDate, $notes);
            $this->session->flash('success', 'Sales Invoice created successfully.');
            return $this->redirect(url('/sales'));
        } catch (\Exception $e) {
            $this->session->flash('error', 'Failed to create invoice: ' . $e->getMessage());
            return $this->redirect(url('/sales/create'));
        }
    }

    public function show(): string
    {
        $id = (int)$this->request->get('id');
        $invoice = $this->salesModel->findWithDetails($id);

        if (!$invoice) {
            $this->session->flash('error', 'Sales Invoice not found.');
            return $this->redirect(url('/sales'));
        }

        return $this->view('sales.show', [
            'invoice' => $invoice,
        ]);
    }
}
