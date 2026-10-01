<?php
class StockController extends Controller
{
    public function index(): string
    {
        $itemModel      = new Item();
        $warehouseModel = new Warehouse();

        $items      = $itemModel->all();
        $warehouses = $warehouseModel->all();

        $totalValuation = 0.0;
        $lowStockCount  = 0;
        foreach ($items as $item) {
            $qty = (int)($item['stock_quantity'] ?? 0);
            $cost = (float)($item['cost_price'] ?? 0);
            $totalValuation += ($qty * $cost);
            if ($qty < 20) {
                $lowStockCount++;
            }
        }

        return $this->view('stock.index', [
            'items'          => $items,
            'warehouses'     => $warehouses,
            'totalValuation' => $totalValuation,
            'lowStockCount'  => $lowStockCount,
        ]);
    }

    public function storeWarehouse(): void
    {
        $whModel = new Warehouse();
        $whModel->create([
            'name'          => $this->request->post('name') ?: 'New Warehouse',
            'location'      => $this->request->post('location') ?: '',
            'manager'       => $this->request->post('manager') ?: '',
            'capacity_sqft' => (int)($this->request->post('capacity_sqft') ?: 10000),
            'status'        => 'Active',
        ]);

        $this->session->flash('success', 'Warehouse facility registered successfully.');
        $this->redirect('/stock');
    }
}
