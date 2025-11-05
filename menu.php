<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Quiosque Barramares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">🍽️ Quiosque Barramares</a>

      <button class="btn btn-sucess" type="button" data-bs-toggle="modal" data-bs-target="#carModal">
        Carrinho <span class="badge bg-light text-dark" id="cart-count">0</span>
      </button>
    </div>
  </nav>

  
  <div class="container py-5">
    <h1 class="text-center mb-5 fw-bold text-dark">Nosso Cardápio</h1>

    <div class="row g-4">
      <?php
      $result = $conn->query("SELECT * FROM pratos");
      while ($row = $result->fetch_assoc()) {
        echo "
          <div class='col-md-4 col-sm-6'>
            <div class='card card-modern h-100 border-0 shadow-sm'>
              <img src='img/{$row['imagem']}' class='card-img-top' alt='{$row['nome']}'>
              <div class='card-body d-flex flex-column justify-content-between'>
                <div>
                  <h5 class='card-title text-dark fw-semibold'>{$row['nome']}</h5>
                  <p class='card-text text-muted'>{$row['descricao']}</p>
                </div>
                <div class='d-flex justify-content-between align-items-center mt-3'>
                  <span class='fw-bold text-success fs-5'>R$ " . number_format($row['preco'], 2, ',', '.') . "</span>
                  <button class='btn btn-outline-success btn-sm btn-adicionar' 
                    data-nome='{$row['nome']}' 
                    data-preco='{$row['preco']}'
                  >Adicionar</button>
                </div>
              </div>
            </div>
          </div>
        ";
      }
      ?>  
    </div>

    <div class="text-center mt-5">
      <a href="index.php" class="btn btn-secondary px-4 py-2">Voltar</a>
    </div>
  </div>

  <footer class="text-center py-4 text-muted small">
    © 2025 Quiosque Barramares— Todos os direitos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Meu Pedido</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="cart-items">
            <p>Seu carrinho está vazio.</p>
          </div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="d-flex justify-content-between">
              <span class="fw-bold">Subtotal:</span>
              <span id="cart-subtotal">R$ 0,00</span>
            </div>
            <div class="d-flex justify-content-between text-muted">
              <span>Taxa de Serviço (10%):</span>
              <span id="cart-tax">R$ 0,00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fs-5 fw-bold">
              <span>TOTAL:</span>
              <span id="cart-total">R$ 0,00</span>
            </div>
          </div>
          <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Continuar Pedindo</button>
          <button type="button" class="btn btn-danger mt-3" id="clear-cart">Limpar Carrinho</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/script.js"></script>

</body>
</html>
