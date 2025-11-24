<?php
require_once "auth_check.php"; 
include '../includes/db.php'; 


$result = $conn->query("SELECT * FROM pratos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Pratos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="dashboard.php">🍽️ Painel de Administrador</a>
    <div class="ms-auto">
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold">Gerenciar Pratos</h2>
        <a href="add.php" class="btn btn-primary">➕ Adicionar Novo Prato</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <img src="../img/<?= htmlspecialchars($row['imagem']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>" style="width: 100px; height: 60px; object-fit: cover;">
                        </td>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Tem certeza que deseja excluir este prato?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <a href="dashboard.php" class="btn btn-secondary mt-3">Voltar ao Painel</a>
</div>

</body>
</html>