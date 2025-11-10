<?php
require_once "auth_check.php";
include '../includes/db.php';

$mensagem = '';
$id = $_GET['id'] ?? null;

// Se não tem ID, não tem o que editar
if (!$id) {
    header('Location: pratos_listar.php');
    exit;
}

// Busca o prato atual no banco
$stmt = $conn->prepare("SELECT * FROM pratos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$prato = $result->fetch_assoc();

if (!$prato) {
    echo "Prato não encontrado.";
    exit;
}

// Se o formulário for enviado (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $nome_imagem_antiga = $prato['imagem']; // Salva o nome da imagem atual

    // Por padrão, usa a imagem antiga
    $nome_imagem = $nome_imagem_antiga;

    // Verifica se uma NOVA imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = $_FILES['imagem'];
        $upload_dir = '../img/';
        $nome_imagem = uniqid() . '_' . basename($imagem['name']);
        $caminho_imagem = $upload_dir . $nome_imagem;

        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            // Se o upload da nova imagem deu certo, apaga a antiga
            if ($nome_imagem_antiga && file_exists($upload_dir . $nome_imagem_antiga)) {
                unlink($upload_dir . $nome_imagem_antiga);
            }
        } else {
            $nome_imagem = $nome_imagem_antiga; // Falhou o upload, mantém a antiga
            $mensagem = "Erro no upload da nova imagem. A imagem anterior foi mantida.";
        }
    }

    // Atualiza o banco de dados
    $stmt_update = $conn->prepare("UPDATE pratos SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?");
    $stmt_update->bind_param("ssdsi", $nome, $descricao, $preco, $nome_imagem, $id);
    
    if ($stmt_update->execute()) {
        $_SESSION['flash'] = 'Prato atualizado com sucesso!';
        header('Location: pratos_listar.php');
        exit;
    } else {
        $mensagem = "Erro ao atualizar o prato: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="dashboard.php">🍽️ Painel de Administrador</a>
</nav>

<div class="container py-5">
    <h2 class="fw-semibold mb-4">Editar Prato: <?= htmlspecialchars($prato['nome']) ?></h2>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-danger"><?= $mensagem ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?= $prato['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Prato</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($prato['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($prato['descricao']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço (ex: 49.90)</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= htmlspecialchars($prato['preco']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Imagem Atual</label><br>
            <img src="../img/<?= htmlspecialchars($prato['imagem']) ?>" style="width: 200px; height: auto; border-radius: 8px;">
        </div>

        <div class="mb-3">
            <label for="imagem" class="form-label">Trocar Imagem (opcional)</label>
            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
            <small class="form-text text-muted">Selecione um novo arquivo apenas se quiser substituir o atual.</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="pratos_listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>