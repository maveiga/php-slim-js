<?php

namespace App\Models;

class LoginModel{
    private $id;
    private $login;
    private $senha;

    // Método para obter o valor da propriedade $id
    public function getId() {
        return $this->id;
    }

    // Método para definir o valor da propriedade $id
    public function setId($id) {
        $this->id = $id;
    }

    // Método para obter o valor da propriedade $login
    public function getLogin() {
        return $this->login;
    }

    // Método para definir o valor da propriedade $login
    public function setLogin($login) {
        $this->login = $login;
    }

    // Método para obter o valor da propriedade $senha
    public function getSenha() {
        return $this->senha;
    }

    // Método para definir o valor da propriedade $senha
    public function setSenha($senha) {
        $this->senha = $senha;
    }
}
