<?php

include 'includes/db.php';

header('Content-Type: application/json');

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson);
$resposta = ['success' => false, 'message' => 'Erro desconhecido.'];

if ($dados && isset($dados->carrinho) && isset($dados->total)) {
    
    $subtotal = floatval(str_replace(['R$ ', '.', ','], ['', '', '.'], $dados->subtotal));
    $taxa = floatval(str_replace(['R$ ', '.', ','], ['', '', '.'], $dados->taxa));
    $total = floatval(str_replace(['R$ ', '.', ','], ['', '', '.'], $dados->total));

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO pedidos (valor_subtotal, valor_taxa, valor_total) VALUES (?, ?, ?)");
        $stmt->bind_param("ddd", $subtotal, $taxa, $total);
        $stmt->execute();
        
        $id_pedido = $conn->insert_id;

        $stmt_item = $conn->prepare("INSERT INTO pedido_itens (id_pedido, nome_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        
        foreach ($dados->carrinho as $item) {
            $stmt_item->bind_param("isid", $id_pedido, $item->nome, $item->quantidade, $item->preco);
            $stmt_item->execute();
        }

        $conn->commit();
        $resposta = ['success' => true, 'message' => 'Pedido salvo!'];

    } catch (Exception $e) {
        $conn->rollback();
        $resposta = ['success' => false, 'message' => $e->getMessage()];
    }

} else {
    $resposta = ['success' => false, 'message' => 'Dados do pedido incompletos.'];
}

echo json_encode($resposta);
?>