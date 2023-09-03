<?php

namespace App\DAO;
use App\Models;
use App\Models\ClienteModel;
use \PDO;

class ClienteDAO extends Conexao{
    public function __construct(){
        parent::__construct();

    }

    public function getAllClientes(): array
    {
        $sql = 'SELECT * FROM cliente';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $cliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($cliente !== false && count($cliente) > 0) {
            return $cliente;
        } else {
            return ["message" => "Nenhum cliente encontrado"];
        }
    }

   
    public function getClienteId(int $id): array
    {
        $sql = 'SELECT * FROM cliente WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($cliente !== false) {
            return $cliente;
        } else {
            return ["message" => "Nenhum cliente encontrado"];
        }
    }
    

    

    
    public function cadastroClientes(ClienteModel $cliente): bool
    {
        try {
            $sql = 'INSERT INTO cliente (nome, idade) VALUES (:nome, :idade)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':idade', $cliente->getIdade());
    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function deletarCliente(int $id):void{
        $sql='DELETE FROM cliente Where id=:id';
        $stmt=$this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function atualizarCliente(int $id, ClienteModel $cliente): bool
    {
        $sql = 'UPDATE cliente SET nome = :nome, idade = :idade WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $cliente->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':idade', $cliente->getIdade(), PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    

    
    
    
    
    
    
}