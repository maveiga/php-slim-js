<?php

namespace App\Models;

class ClienteModel{
    private $id;
    private $nome;
    private $idade;

    public function getId():int{
        return $this->id;
    }


    public function getNome():string{
        return $this->nome;

    }

    public function setNome(string $nome):ClienteModel{
        $this->nome=$nome;
        return $this;

    }

    public function getIdade():int{
        return $this->idade;
    }

    public function setIdade(int $idade):ClienteModel{
        $this->idade = $idade;
        return $this;
    }

   
}