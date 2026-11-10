<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/Model/Cliente.php';
require_once __DIR__ . '/../src/DAO/ClienteDAO.php';
require_once __DIR__ . '/../src/Controller/ClienteController.php';

use Controller\ClienteController;

$controller = new ClienteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir') {
        $controller->excluir((int)$_POST['id']);
    } else {
        $controller->salvar($_POST);
    }
    header('Location: index.php');
    exit;
}

$clientes = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes - PDV</title>
</head>
<body>
    <h1>Gerenciamento de Clientes</h1>
    
    <form method="POST">
        <input type="hidden" name="id" id="cliente_id">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>CPF: <input type="text" name="cpf" required></label><br>
        <label>Telefone: <input type="text" name="telefone" required></label><br>
        <button type="submit">Salvar Cliente</button>
    </form>

    <h2>Lista de Clientes</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Nome</th><th>CPF</th><th>Telefone</th><th>Ações</th>
        </tr>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= $c->getId() ?></td>
            <td><?= htmlspecialchars($c->getNome()) ?></td>
            <td><?= htmlspecialchars($c->getCpf()) ?></td>
            <td><?= htmlspecialchars($c->getTelefone()) ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="excluir">
                    <input type="hidden" name="id" value="<?= $c->getId() ?>">
                    <button type="submit">Excluir</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
