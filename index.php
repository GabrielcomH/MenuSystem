<?php
include 'includes/db.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Quiosque Barramares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">

  <div class="container py-5">
    <h1 class="mb-4">🍽️ Quiosque Barramares</h1>
    <p>Explore nosso cardápio digital e faça seus pedidos com facilidade!</p>
    <a href="menu.php" class="btn btn-primary btn-lg mt-3">Ver Cardápio</a>
  </div>

  <nav class="d-flex justify-content-end p-3">
    <a href="admin/login.php" class="btn btn-sm btn-outline-secondary" style="opacity: 0.6;">
        Admin
    </a>
</nav>


</body>
</html>