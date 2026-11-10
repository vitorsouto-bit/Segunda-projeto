<?php
namespace DAO;

use Config\Database;
use Model\Venda;
use PDO;
use Exception;

class VendaDAO {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function finalizarVenda(Venda $venda): bool {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO vendas (cliente_id, total) VALUES (:cliente_id, :total)");
            $stmt->execute([
                ':cliente_id' => $venda->getClienteId(),
                ':total' => $venda->getTotal()
            ]);
            $vendaId = (int)$this->db->lastInsertId();

            $stmtItem = $this->db->prepare("INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco_unitario) VALUES (:venda_id, :produto_id, :quantidade, :preco)");

            foreach ($venda->getItens() as $item) {
                $stmtItem->execute([
                    ':venda_id' => $vendaId,
                    ':produto_id' => $item->getProdutoId(),
                    ':quantidade' => $item->getQuantidade(),
                    ':preco' => $item->getPrecoUnitario()
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
