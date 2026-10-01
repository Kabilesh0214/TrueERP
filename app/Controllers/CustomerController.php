<?php
class CustomerController extends Controller
{
    private Customer $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new Customer();
    }

    public function index(): string
    {
        $customers = $this->customerModel->all();
        return $this->view('customers.index', [
            'customers' => $customers,
            'success'   => $this->session->getFlash('success'),
            'error'     => $this->session->getFlash('error'),
        ]);
    }

    public function create(): string
    {
        return $this->view('customers.create', [
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function store(): string
    {
        $name    = $this->request->post('name');
        $email   = $this->request->post('email');
        $phone   = $this->request->post('phone');
        $company = $this->request->post('company');
        $address = $this->request->post('address');

        if (empty($name)) {
            $this->session->flash('error', 'Customer name is required.');
            return $this->redirect(url('/customers/create'));
        }

        $this->customerModel->create([
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'company' => $company,
            'address' => $address,
        ]);

        $this->session->flash('success', 'Customer added successfully.');
        return $this->redirect(url('/customers'));
    }

    public function edit(): string
    {
        $id = (int)$this->request->get('id');
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            $this->session->flash('error', 'Customer not found.');
            return $this->redirect(url('/customers'));
        }

        return $this->view('customers.edit', [
            'customer' => $customer,
            'error'    => $this->session->getFlash('error'),
        ]);
    }

    public function update(): string
    {
        $id = (int)$this->request->post('id');
        $this->customerModel->update($id, [
            'name'    => $this->request->post('name'),
            'email'   => $this->request->post('email'),
            'phone'   => $this->request->post('phone'),
            'company' => $this->request->post('company'),
            'address' => $this->request->post('address'),
        ]);

        $this->session->flash('success', 'Customer updated successfully.');
        return $this->redirect(url('/customers'));
    }

    public function delete(): string
    {
        $id = (int)$this->request->post('id');
        $this->customerModel->delete($id);
        $this->session->flash('success', 'Customer deleted successfully.');
        return $this->redirect(url('/customers'));
    }
}
