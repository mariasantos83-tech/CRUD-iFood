<?php
require 'db.php';

$query = "SELECT 
            p.id AS pedido_id,
            c.nome AS cliente_nome,
            r.nome AS restaurante_nome,
            p.valor,
            p.status,
            p.data_pedido
          FROM pedidos p
          INNER JOIN clientes c ON p.cliente_id = c.id
          INNER JOIN restaurantes r ON p.restaurante_id = r.id
          ORDER BY p.id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute();
$pedidos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Pedidos - Delivery</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 8px 12px; text-decoration: none; background: #28a745; color: #fff; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Gerenciamento de Pedidos</h1>
    <a href="cadastrar_pedido.php" class="btn">+ Novo Pedido</a>

    <table>
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Restaurante</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pedidos) > 0): ?>
                <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td><?= $p['pedido_id'] ?></td>
                        <td><?= htmlspecialchars($p['cliente_nome']) ?></td>
                        <td><?= htmlspecialchars($p['restaurante_nome']) ?></td>
                        <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['status']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['data_pedido'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum pedido encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>