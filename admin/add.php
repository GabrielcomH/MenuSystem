<?php

require_once "auth_check.php";


require_once "../includes/db.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];

    if ($nome === '' || $descricao === '' || $preco === '' || !isset($_FILES['imagem'])) {
        echo "<script>alert('Preencha todos os campos!');</script>";
    } else {

        $imagemNome = $_FILES['imagem']['name'];         
        $imagemTmp = $_FILES['imagem']['tmp_name'];      

        $destino = "../img/" . $imagemNome;              

        move_uploaded_file($imagemTmp, $destino);        

        
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagemNome);
        $stmt->execute();

        header("Location: pratos_listar.php?msg=add_ok");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Prato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .card { border-radius: 12px; padding: 25px; }
        .titulo { font-weight: 600; color: #333; }
        .img-preview {
            width: 100%;
            max-height: 260px;
            object-fit: cover;
            margin-top: 12px;
            border-radius: 8px;
            display: none;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">🍽 Painel Admin</span>
    <a href="dashboard.php" class="btn btn-light">Voltar</a>
</nav>

<div class="container py-5">
    <div class="card shadow col-lg-6 mx-auto">

        <h3 class="titulo text-center mb-4">➕ Adicionar novo prato</h3>

        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="mb-3">
                <label class="form-label">Nome do prato*</label>
                <input type="text" name="nome" class="form-control" placeholder="Ex: Peixe Frito" required>
                <div class="invalid-feedback">Digite o nome do prato</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição*</label>
                <textarea name="descricao" class="form-control" rows="3" placeholder="Ex: Peixe frito com arroz e batata" required></textarea>
                <div class="invalid-feedback">Digite uma descrição</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Preço (R$)*</label>
                <input type="number" name="preco" step="0.01" class="form-control" placeholder="Ex: 49.90" required>
                <div class="invalid-feedback">Informe o preço</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem*</label>
                <input type="file" name="imagem" accept="image/*" id="imagemInput" class="form-control" required>
                <img id="preview" class="img-preview">
                <div class="invalid-feedback">Selecione uma imagem</div>
            </div>

            <button class="btn btn-success w-100 btn-lg">Salvar prato</button>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.getElementById("imagemInput").addEventListener("change", function (event) {
    const imgPreview = document.getElementById("preview");
    imgPreview.src = URL.createObjectURL(event.target.files[0]);
    imgPreview.style.display = "block";
});


(() => {
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
})();
</script>

</body>
</html>
