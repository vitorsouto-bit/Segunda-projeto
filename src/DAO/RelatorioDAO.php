<?php
namespace DAO;

use Config\Database;
use PDO;

class RelatorioDAO {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function obterVendasPorPeriodo(string $dataInicio, string $dataFim): array {
        $sql = "SELECT v.id, c.nome AS cliente, v.total, v.data_venda 
                FROM vendas v 
                JOIN clientes c ON v.cliente_id = c.id 
                WHERE DATE(v.data_venda) BETWEEN :data_inicio AND :data_fim
                ORDER BY v.data_venda DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':data_inicio' => $dataInicio,
            ':data_fim'    => $dataFim
        ]);

        return $stmt->fetchAll();
    }
}
