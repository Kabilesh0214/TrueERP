<?php
class SupplierController extends Controller
{
    private Supplier $supplierModel;

    public function __construct()
    {
        parent::__construct();
        $this->supplierModel = new Supplier();
    }

    public function index(): string
    {
        $suppliers = $this->supplierModel->all();
        return $this->view('suppliers.index', [
            'suppliers' => $suppliers,
            'success'   => $this->session->getFlash('success'),
            'error'     => $this->session->getFlash('error'),
        ]);
    }

    public function create(): string
    {
        return $this->view('suppliers.create', [
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function store(): string
    {
        $name           = $this->request->post('name');
        $contact_person = $this->request->post('contact_person');
        $email          = $this->request->post('email');
        $phone          = $this->request->post('phone');
        $address        = $this->request->post('address');

        if (empty($name)) {
            $this->session->flash('error', 'Supplier name is required.');
            return $this->redirect(url('/suppliers/create'));
        }

        $this->supplierModel->create([
            'name'           => $name,
            'contact_person' => $contact_person,
            'email'          => $email,
            'phone'          => $phone,
            'address'        => $address,
        ]);

        $this->session->flash('success', 'Supplier created successfully.');
        return $this->redirect(url('/suppliers'));
    }

    public function edit(): string
    {
        $id = (int)$this->request->get('id');
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            $this->session->flash('error', 'Supplier not found.');
            return $this->redirect(url('/suppliers'));
        }

        return $this->view('suppliers.edit', [
            'supplier' => $supplier,
            'error'    => $this->session->getFlash('error'),
        ]);
    }

    public function update(): string
    {
        $id = (int)$this->request->post('id');
        $this->supplierModel->update($id, [
            'name'           => $this->request->post('name'),
            'contact_person' => $this->request->post('contact_person'),
            'email'          => $this->request->post('email'),
            'phone'          => $this->request->post('phone'),
            'address'        => $this->request->post('address'),
        ]);

        $this->session->flash('success', 'Supplier updated successfully.');
        return $this->redirect(url('/suppliers'));
    }

    public function delete(): string
    {
        $id = (int)$this->request->post('id');
        $this->supplierModel->delete($id);
        $this->session->flash('success', 'Supplier deleted successfully.');
        return $this->redirect(url('/suppliers'));
    }
}
