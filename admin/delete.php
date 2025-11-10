<?php
require_once "auth_check.php";
include '../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: pratos_listar.php');
    exit;
}

$stmt_select = $conn->prepare("SELECT imagem FROM pratos WHERE id = ?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$prato = $result->fetch_assoc();

if ($prato) {
    $caminho_imagem = '../img/' . $prato['imagem'];

    $stmt_delete = $conn->prepare("DELETE FROM pratos WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        if (file_exists($caminho_imagem)) {
            unlink($caminho_imagem);
        }
        $_SESSION['flash'] = 'Prato excluído com sucesso!';
    } else {
        $_SESSION['flash'] = 'Erro ao excluir o prato.';
    }
} else {
    $_SESSION['flash'] = 'Prato não encontrado.';
}

header('Location: pratos_listar.php');
exit;
?>