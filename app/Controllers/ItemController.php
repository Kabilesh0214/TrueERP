<?php
class ItemController extends Controller
{
    private Item $itemModel;

    public function __construct()
    {
        parent::__construct();
        $this->itemModel = new Item();
    }

    public function index(): string
    {
        $items = $this->itemModel->all();
        return $this->view('items.index', [
            'items'   => $items,
            'success' => $this->session->getFlash('success'),
            'error'   => $this->session->getFlash('error'),
        ]);
    }

    public function create(): string
    {
        return $this->view('items.create', [
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function store(): string
    {
        $code           = $this->request->post('code');
        $name           = $this->request->post('name');
        $category       = $this->request->post('category');
        $unit           = $this->request->post('unit') ?: 'pcs';
        $unit_price     = (float)$this->request->post('unit_price');
        $cost_price     = (float)$this->request->post('cost_price');
        $stock_quantity = (int)$this->request->post('stock_quantity');

        if (empty($code) || empty($name)) {
            $this->session->flash('error', 'Item code and name are required.');
            return $this->redirect(url('/items/create'));
        }

        if ($this->itemModel->findByCode($code)) {
            $this->session->flash('error', 'An item with this code already exists.');
            return $this->redirect(url('/items/create'));
        }

        $this->itemModel->create([
            'code'           => $code,
            'name'           => $name,
            'category'       => $category,
            'unit'           => $unit,
            'unit_price'     => $unit_price,
            'cost_price'     => $cost_price,
            'stock_quantity' => $stock_quantity,
        ]);

        $this->session->flash('success', 'Item created successfully.');
        return $this->redirect(url('/items'));
    }

    public function edit(): string
    {
        $id = (int)$this->request->get('id');
        $item = $this->itemModel->find($id);

        if (!$item) {
            $this->session->flash('error', 'Item not found.');
            return $this->redirect(url('/items'));
        }

        return $this->view('items.edit', [
            'item'  => $item,
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function update(): string
    {
        $id = (int)$this->request->post('id');
        $this->itemModel->update($id, [
            'code'           => $this->request->post('code'),
            'name'           => $this->request->post('name'),
            'category'       => $this->request->post('category'),
            'unit'           => $this->request->post('unit'),
            'unit_price'     => (float)$this->request->post('unit_price'),
            'cost_price'     => (float)$this->request->post('cost_price'),
            'stock_quantity' => (int)$this->request->post('stock_quantity'),
        ]);

        $this->session->flash('success', 'Item updated successfully.');
        return $this->redirect(url('/items'));
    }

    public function delete(): string
    {
        $id = (int)$this->request->post('id');
        $this->itemModel->delete($id);
        $this->session->flash('success', 'Item deleted successfully.');
        return $this->redirect(url('/items'));
    }
}
