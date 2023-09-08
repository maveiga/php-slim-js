<?php

namespace App\DAO;
use App\Models;
use App\Models\LoginModel;
use \PDO;

class LoginDao extends Conexao{
    public function __construct(){
        parent::__construct();

    }
    public function getLogin(LoginModel $loginModel)
    {
        // Recupera o login e senha do objeto $loginModel
        $login = $loginModel->getLogin();
        $senha = $loginModel->getSenha();

        $sql = 'SELECT * FROM usuarios WHERE email = :email and senha=:senha';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $login, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();
        $temlogin = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($temlogin !== false) {
            return $temlogin;
        }
    }
    
    
   
    
    
    
    
}