<?php
namespace DAO;

use Config\Database;
use Model\Cliente;
use PDO;

class ClienteDAO {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function criar(Cliente $cliente): bool {
        $stmt = $this->db->prepare("INSERT INTO clientes (nome, cpf, telefone) VALUES (:nome, :cpf, :telefone)");
        return $stmt->execute([
            ':nome' => $cliente->getNome(),
            ':cpf' => $cliente->getCpf(),
            ':telefone' => $cliente->getTelefone()
        ]);
    }

    public function listar(): array {
        $stmt = $this->db->query("SELECT * FROM clientes ORDER BY id DESC");
        $dados = $stmt->fetchAll();
        $clientes = [];
        foreach ($dados as $d) {
            $clientes[] = new Cliente($d['id'], $d['nome'], $d['cpf'], $d['telefone']);
        }
        return $clientes;
    }

    public function atualizar(Cliente $cliente): bool {
        $stmt = $this->db->prepare("UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone WHERE id = :id");
        return $stmt->execute([
            ':id' => $cliente->getId(),
            ':nome' => $cliente->getNome(),
            ':cpf' => $cliente->getCpf(),
            ':telefone' => $cliente->getTelefone()
        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
