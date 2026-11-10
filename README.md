# Vitrine PDV — Sistema de Ponto de Venda

Projeto acadêmico desenvolvido em PHP 8+ e MySQL, utilizando arquitetura MVC e padrões de projeto.

## Funcionalidades
- Cadastro, listagem e exclusão lógica de produtos.
- Cadastro, listagem e exclusão de clientes.
- Carrinho de venda com múltiplos itens, seleção opcional de cliente e validação de estoque.
- Finalização de venda com pagamento Pix, dinheiro ou cartão.
- Relatório de vendas e faturamento do dia.
- Atualização de estoque dentro de transação MySQL.

## Tecnologias
PHP 8+, PDO, MySQL/MariaDB, HTML, CSS e JavaScript.

## Instalação local (XAMPP)
1. Copie a pasta `sistema-pdv` para `C:/xampp\htdocs\` (ou para o `htdocs` da sua instalação).
2. Abra o XAMPP Control Panel e inicie Apache e MySQL.
3. Acesse `http://localhost/phpmyadmin/`.
4. Na aba SQL, importe/execute o arquivo `database/schema.sql`.
5. Confira usuário e senha do MySQL em `config/database.php` (padrão XAMPP: root e senha vazia).
6. Abra `http://localhost/sistema-pdv/`.

## Arquitetura MVC
- **Model:** representa conceitos do domínio (`app/Models`).
- **View:** contém as telas HTML/PHP (`app/Views`).
- **Controller:** recebe requisições, valida entradas e coordena o fluxo (`app/Controllers`).
- **Repository:** concentra consultas e persistência no MySQL (`app/Repositories`), evitando SQL espalhado nas telas.

O `index.php` funciona como ponto de entrada/roteador simples e encaminha a requisição ao controller correspondente.

## Design Patterns utilizados
1. **Repository:** `ClienteRepository`, `ProdutoRepository` e `VendaRepository` isolam o acesso aos dados.
2. **Strategy:** `PaymentStrategy` define um contrato de cálculo; Pix, dinheiro e cartão implementam regras de pagamento diferentes.
3. **Factory:** `PaymentFactory` escolhe a estratégia de pagamento; `ReportFactory` centraliza a criação do formatador de relatório.

## Regras de negócio demonstradas
- Não permite concluir venda sem itens.
- Confere o estoque antes de registrar os itens.
- Registra venda, itens e baixa de estoque em uma transação; em caso de falha, faz rollback.
- Pix aplica 2% de desconto, dinheiro 3%, cartão não aplica desconto (regra demonstrativa e facilmente ajustável).

## Estrutura
```text
app/Controllers   app/Models   app/Repositories
app/Patterns      app/Views    config/database.php
database/schema.sql                public/assets/style.css
index.php                          README.md
POP.md
```

## Observações acadêmicas
Esta é uma base funcional para demonstração local e estudo. Antes de uso real, implemente autenticação/autorização, proteção CSRF, logs, testes automatizados, paginação, validações adicionais e configuração segura de credenciais. Não publique credenciais reais no GitHub.

