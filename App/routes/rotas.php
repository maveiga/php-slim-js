<?php
use App\Controllers\ClienteController;
use App\Controllers\ExcelController;
use App\Controllers\LoginController;

$app = new \Slim\App();


$container = $app->getContainer();
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./App/Pages');
    $clienteController = new ClienteController($container);
};


$app->get('/', ClienteController::class . ':getCliente');
$app->get('/cadastros', ClienteController::class . ':renderCadastro');
$app->post('/cadastros', ClienteController::class . ':cadastroCliente');
$app->delete('/deletar/{id}', ClienteController::class . ':deleteCliente');
$app->get('/editarporid/{id}', ClienteController::class .':paginaedicao');
$app->post('/editar/{id}', ClienteController::class . ':editarCliente');
$app->get('/clientes-json', ClienteController::class . ':getClientesJSON');

$app->get('/home', LoginController::class .':getHome');
$app->post('/fazerlogin', LoginController::class .':fazerLogin');

$app->get('/sair', LoginController::class .':sair');


$app->get('/importar-excel', ExcelController::class . ':renderImportarExcel');
$app->post('/importar-excel', ExcelController::class . ':importarExcel');

$app->run();