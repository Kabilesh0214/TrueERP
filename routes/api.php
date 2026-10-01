<?php
/** @var Application $app */

$app->router->get('/api/v1/health', function () {
    return json_response(['status' => 'ok', 'app' => 'PHP ERP API v1', 'timestamp' => time()]);
});

$app->router->get('/api/v1/items', function () {
    $itemModel = new Item();
    return json_response(['items' => $itemModel->all()]);
});

$app->router->get('/api/v1/customers', function () {
    $customerModel = new Customer();
    return json_response(['customers' => $customerModel->all()]);
});
