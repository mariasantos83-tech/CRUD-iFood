<?php
require 'db.php';

// Busca Clientes e Restaurantes para alimentar os campos <select>
$clientes = $pdo->query("SELECT id, nome FROM clientes")->fetchAll();
$restaurantes = $pdo->query("SELECT id, nome FROM restaurantes")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $restaurante_id = $_POST['restaurante_id'];
    $valor = $_POST['valor'];
    $status = $_POST['status'];

    $sql = "INSERT INTO pedidos (cliente_id, restaurante_id, valor, status) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cliente_id, $restaurante_id, $valor, $status]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pedido</title>
</head>
<body>

    <h2>Criar Novo Pedido</h2>

    <form method="POST">
        <label>Cliente:</label><br>
        <select name="cliente_id" required>
            <option value="">Selecione um cliente...</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Restaurante:</label><br>
        <select name="restaurante_id" required>
            <option value="">Selecione um restaurante...</option>
            <?php foreach ($restaurantes as $r): ?>
                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nome']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Valor (R$):</label><br>
        <input type="number" step="0.01" name="valor" required><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="Recebido">Recebido</option>
            <option value="Em preparo">Em preparo</option>
            <option value="Saiu para Entrega">Saiu para Entrega</option>
            <option value="Entregue">Entregue</option>
        </select><br><br>

        <button type="submit">Cadastrar Pedido</button>
        <a href="index.php">Voltar</a>
    </form>

</body>
</html>