<?php
namespace Controller;

use DAO\RelatorioDAO;

class RelatorioController {
    private RelatorioDAO $dao;

    public function __construct() {
        $this->dao = new RelatorioDAO();
    }

    public function gerarRelatorioPeriodo(?string $inicio, ?string $fim): array {
        if (!$inicio || !$fim) {
            return [];
        }
        return $this->dao->obterVendasPorPeriodo($inicio, $fim);
    }
}
