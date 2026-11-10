<?php
namespace Model;

class ItemVenda {
    public function __construct(
        private int $produtoId,
        private string $nomeProduto,
        private int $quantidade,
        private float $precoUnitario
    ) {}

    public function getProdutoId(): int { return $this->produtoId; }
    public function getNomeProduto(): string { return $this->nomeProduto; }
    public function getQuantidade(): int { return $this->quantidade; }
    public function getPrecoUnitario(): float { return $this->precoUnitario; }
    public function getSubtotal(): float { return $this->quantidade * $this->precoUnitario; }
}

class Venda {
    private array $itens = [];

    public function __construct(private ?int $clienteId = null) {}

    public function setClienteId(int $clienteId): void { $this->clienteId = $clienteId; }
    public function getClienteId(): ?int { return $this->clienteId; }

    public function adicionarItem(ItemVenda $item): void {
        $this->itens[] = $item;
    }

    public function removerItem(int $index): void {
        if (isset($this->itens[$index])) {
            unset($this->itens[$index]);
            $this->itens = array_values($this->itens);
        }
    }

    public function getItens(): array { return $this->itens; }

    public function getTotal(): float {
        $total = 0;
        foreach ($this->itens as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }
}
