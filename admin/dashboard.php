<?php

require_once "auth_check.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .card-hover {
            transition: transform .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .card-hover:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 18px rgba(0,0,0,.25);
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="#">🍽️ Painel de Administrador</a>
    <div class="ms-auto">
        <span class="text-white me-3">Olá, <strong><?= $_SESSION['admin_user'] ?></strong></span>
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>
</nav>

<div class="container py-5">
    <h2 class="fw-semibold text-center mb-4">Gerenciamento do Cardápio</h2>

    <div class="row g-4 justify-content-center">

        
        <div class="col-md-4">
            <a href="add.php" class="text-decoration-none text-dark">
                <div class="card card-hover shadow border-0">
                    <div class="card-body text-center py-4">
                        <h3 class="fw-bold">➕ Adicionar Prato</h3>
                        <p>Cadastrar novo item no cardápio</p>
                    </div>
                </div>
            </a>
        </div>

        
        <div class="col-md-4">
            <a href="pratos_listar.php" class="text-decoration-none text-dark">
                <div class="card card-hover shadow border-0">
                    <div class="card-body text-center py-4">
                        <h3 class="fw-bold">📋 Listar / Editar Pratos</h3>
                        <p>Gerenciar itens já cadastrados</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

</body>
</html>
