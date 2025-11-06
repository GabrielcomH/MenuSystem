<?php


session_start();


if (!empty($_SESSION['admin_logged'])) {
    header('Location: dashboard.php');
    exit;
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
}


$flash = '';
if (!empty($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once __DIR__ . '/../includes/db.php';

    
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $_SESSION['flash'] = 'Requisição inválida. Tente novamente.';
        header('Location: login.php');
        exit;
    }

    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    
    if ($username === '' || $password === '') {
        $flash = 'Preencha usuário e senha.';
    } else {
        
        $sql = "SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                
                if (password_verify($password, $row['password_hash'])) {
                    
                    session_regenerate_id(true);
                    $_SESSION['admin_logged'] = true;
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['admin_user'] = $row['username'];
                    
                    $_SESSION['last_activity'] = time();

                    header('Location: dashboard.php');
                    exit;
                } else {
                    $flash = 'Usuário ou senha inválidos.';
                }
            } else {
                $flash = 'Usuário ou senha inválidos.';
            }

            $stmt->close();
        } else {
            
            $flash = 'Erro no servidor. Tente novamente mais tarde.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Login - Painel Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f5f6f8; }
    .login-card { max-width:420px; margin:80px auto; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.08); }
    .brand { font-weight:700; letter-spacing: .5px; }
  </style>
</head>
<body>
  <div class="card login-card">
    <div class="card-body p-4">
      <h4 class="card-title mb-3 brand text-center">Painel Admin</h4>

      <?php if (!empty($flash)): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <form method="post" action="login.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
          <label for="username" class="form-label">Usuário</label>
          <input id="username" name="username" type="text" class="form-control" placeholder="Seu usuário" required maxlength="50" autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input id="password" name="password" type="password" class="form-control" placeholder="Sua senha" required>
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
        </div>

        <div class="mt-3 text-center">
          <a href="../index.php" class="link-secondary">Voltar ao site</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
