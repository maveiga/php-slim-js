<?php

namespace App\Controllers;
use Slim\Http\Response;
use Slim\Http\Request;
use App\DAO\LoginDao;
use App\Models\LoginModel;

class LoginController {
    private $view;
    public function __construct($container) {
        $this->view = $container->get('view');
        
    }

    public function getHome(Request $request, Response $response, array $args):Response{
       
        return $this->view->render($response, 'login.html');
    }

    public function fazerLogin(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody(); // Obtém os dados do corpo da requisição

        // Crie uma instância do modelo de login e configure os dados
        $loginModel = new LoginModel();
        $loginModel->setLogin($data['login']); // Substitua 'login' pelo nome correto do campo de login
        $loginModel->setSenha($data['senha']); // Substitua 'senha' pelo nome correto do campo de senha

        // Crie uma instância do DAO de login e verifique se o login é válido
        $loginDAO = new LoginDAO();
        $resultado = $loginDAO->getLogin($loginModel);

        if (is_array($resultado) && count($resultado) > 0) {
            $_SESSION['logged_in'] = true; 
            // Login válido, redirecione ou retorne uma resposta de sucesso
           return $response->withRedirect('http://localhost/react/sitecompletoestilo/');
        } else {
            $_SESSION['logged_in'] = false;
            // Login inválido, redirecione ou retorne uma resposta de erro
            return $response->withRedirect('http://localhost/react/sitecompletoestilo/erro');
        }
        
    }

    public function sair(Request $request, Response $response, array $args):Response{
        $_SESSION['logged_in'] = false;
        return $response->withRedirect('http://localhost/react/sitecompletoestilo/home');
    }


    
}
    



    
    


