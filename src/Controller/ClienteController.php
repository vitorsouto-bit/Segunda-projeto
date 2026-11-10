<?php
namespace Controller;

use DAO\ClienteDAO;
use Model\Cliente;

class ClienteController {
    private ClienteDAO $dao;

    public function __construct() {
        $this->dao = new ClienteDAO();
    }

    public function salvar(array $dados): void {
        if (!empty($dados['id'])) {
            $cliente = new Cliente((int)$dados['id'], $dados['nome'], $dados['cpf'], $dados['telefone']);
            $this->dao->atualizar($cliente);
        } else {
            $cliente = new Cliente(null, $dados['nome'], $dados['cpf'], $dados['telefone']);
            $this->dao->criar($cliente);
        }
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function excluir(int $id): void {
        $this->dao->deletar($id);
    }
}
