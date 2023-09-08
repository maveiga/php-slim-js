<?php

namespace App\Controllers;
use Slim\Http\Response;
use Slim\Http\Request;
use App\DAO\ClienteDAO;
use App\Models\ClienteModel;

class ClienteController {
    private $view;
    public function __construct($container) {
        $this->view = $container->get('view');
    }


    public function getCliente(Request $request, Response $response, array $args):Response{
        $clienteDao = new ClienteDAO();
        $clientes = $clienteDao->getAllClientes();
        
        // Verifica se a variável de sessão 'logged_in' está definida e é verdadeira
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            return $this->view->render($response, 'home.html', ['clientes' => $clientes]);
        } else {
            // Se 'logged_in' não estiver definida ou for falsa, redirecione para a página de login
            return $this->view->render($response, 'login.html');
        }
    }
    

    public function getClientesJSON(Request $request, Response $response, array $args): Response {
        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->getAllClientes();
        
        $responseData = [
            'clientes' => $clientes
        ];
    
        return $response->withJson($responseData, 200);
    }
    

    public function cadastroCliente(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setNome($data['nome']);
        $cliente->setIdade((int) $data['idade']);
        if ($clienteDAO->cadastroClientes($cliente)) {
            $responseData = [
                'message' => 'Cliente cadastrado com sucesso.'
            ];
        } else {
            $responseData = [
                'message' => 'Erro ao cadastrar o cliente.'
            ];
        }
    
        return $response->withJson($responseData, 200);
    }
    



    public function renderCadastro(Request $request, Response $response, array $args): Response {
        return $this->view->render($response, 'cadastro.html');
    }

    public function deleteCliente(Request $request, Response $response, array $args){
        $clienteDAO = new ClienteDAO();
        $id = $args['id'];
        
        if ($clienteDAO->deletarCliente($id)) {
            $responseData = [
                'message' => 'Cliente excluído com sucesso.'
            ];
        } else {
            $responseData = [
                'message' => 'Erro ao excluir o cliente.'
            ];
        }
    
        return $response->withJson($responseData, 200);
    }
    

    public function paginaedicao(Request $request, Response $response, array $args): Response
    {
        $clienteDAO = new ClienteDAO();
        $id = $args['id'];
        $cliente = $clienteDAO->getClienteId($id);
    
        if (!$cliente) {
            $message = 'Cliente não encontrado.';
            return $response->withStatus(404)->withJson(['message' => $message]);
        }
    
        return $response->withJson(['cliente' => $cliente]);
    }
    


    public function editarCliente(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $id = $args['id'];
        $cliente->setNome($data['nome']);
        $cliente->setIdade((int) $data['idade']);
        if ($clienteDAO->atualizarCliente($id, $cliente)) {
            $responseData = [
                'message' => 'Cliente Atualizado com sucesso.'
            ];
        } else {
            $responseData = [
                'message' => 'Erro ao Atualizado o cliente.'
            ];
        }
    
        return $response->withJson($responseData, 200);
    }
    }
    



    
    


