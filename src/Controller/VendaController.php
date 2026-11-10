<?php
namespace Controller;

use DAO\VendaDAO;
use Model\ItemVenda;
use Model\Venda;

class VendaController {
    private VendaDAO $dao;

    public function __construct() {
        $this->dao = new VendaDAO();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = new Venda();
        }
    }

    public function adicionarItem(int $produtoId, string $nome, int $qtd, float $preco): void {
        $item = new ItemVenda($produtoId, $nome, $qtd, $preco);
        $_SESSION['carrinho']->adicionarItem($item);
    }

    public function removerItem(int $index): void {
        $_SESSION['carrinho']->removerItem($index);
    }

    public function vincularCliente(int $clienteId): void {
        $_SESSION['carrinho']->setClienteId($clienteId);
    }

    public function finalizar(): bool {
        /** @var Venda $venda */
        $venda = $_SESSION['carrinho'];
        if (empty($venda->getItens()) || $venda->getClienteId() === null) {
            return false;
        }
        $resultado = $this->dao->finalizarVenda($venda);
        if ($resultado) {
            $_SESSION['carrinho'] = new Venda();
        }
        return $resultado;
    }

    public function getVendaAtual(): Venda {
        return $_SESSION['carrinho'];
    }
}
