<?php
class AccountingController extends Controller
{
    public function index(): string
    {
        $invoiceModel = new SalesInvoice();
        $paymentModel = new Payment();
        $customerModel = new Customer();

        $invoices = $invoiceModel->allWithCustomer();
        $payments = $paymentModel->all();

        // Calculate financial statistics
        $totalReceivables = 0.0;
        $totalPaid = 0.0;
        $pendingCount = 0;

        foreach ($invoices as $inv) {
            $amt = (float)($inv['total_amount'] ?? 0);
            if (($inv['status'] ?? '') === 'paid') {
                $totalPaid += $amt;
            } else {
                $totalReceivables += $amt;
                $pendingCount++;
            }
        }

        foreach ($payments as $p) {
            $totalPaid += (float)($p['amount'] ?? 0);
        }

        $customers = $customerModel->all();

        return $this->view('accounting.index', [
            'invoices'         => $invoices,
            'payments'         => $payments,
            'customers'        => $customers,
            'totalReceivables' => $totalReceivables,
            'totalPaid'        => $totalPaid,
            'pendingCount'     => $pendingCount,
        ]);
    }

    public function storePayment(): void
    {
        $paymentModel = new Payment();
        $amount = (float)($this->request->post('amount') ?? 0);

        if ($amount <= 0) {
            $this->session->flash('error', 'Payment amount must be greater than zero.');
            $this->redirect('/accounting');
        }

        $paymentNumber = 'PAY-' . date('Y') . '-' . str_pad((string)(count($paymentModel->all()) + 1), 4, '0', STR_PAD_LEFT);

        $paymentModel->create([
            'payment_number' => $paymentNumber,
            'invoice_id'     => $this->request->post('invoice_id') ?: null,
            'customer_id'    => $this->request->post('customer_id') ?: null,
            'payment_date'   => $this->request->post('payment_date') ?: date('Y-m-d'),
            'amount'         => $amount,
            'payment_method' => $this->request->post('payment_method') ?: 'Bank Transfer',
            'reference'      => $this->request->post('reference') ?: 'Direct Entry',
            'status'         => 'Completed',
        ]);

        // If linked to an invoice, mark invoice as paid
        $invoiceId = $this->request->post('invoice_id');
        if ($invoiceId) {
            $invModel = new SalesInvoice();
            $invModel->update((int)$invoiceId, ['status' => 'paid']);
        }

        $this->session->flash('success', "Payment {$paymentNumber} recorded successfully.");
        $this->redirect('/accounting');
    }
}
