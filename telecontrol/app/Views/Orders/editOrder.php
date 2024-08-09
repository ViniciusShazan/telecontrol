<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/OrdersController.php';
    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';

    try {
        //carrega a classe cliente controller
        $order = new OrdersController();

        //Carrega o cliente selecionado
        $ordem = $order->show($_GET['id']);

        $product = new ProductsController();

        $produtos = $product->index();

        if ($ordem["status"] == false) {
            header('Location: ../home');
        }
        if ($produtos["status"] == false) {
            header('Location: ../home');
        }
    } catch (\Throwable $th) {
        error_log($th);
        header('Location: ../home');
    }
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>

    <form action="edit-order" method="POST">
        <h1>Editar Ordem Nº<?= $_GET['id']; ?></h1>
        <div class="form-group">
            <label for="numero_ordem">Numero da ordem</label>
            <input type="number" class="form-control" name="numero_ordem" id="numero_ordem" value="<?= $ordem['ordens']['numero_ordem'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="data_abertura">Data de abertura</label>
            <input type="date" class="form-control"name="data_abertura" id="data_abertura" value="<?= $ordem['ordens']['data_abertura'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="nome">Nome do cliente</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= $ordem['ordens']['nome'] ?>" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF do cliente</label>
            <input type="text" class="form-control"name="cpf" id="cpf" value="<?= $ordem['ordens']['cpf'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select class="form-control" id="produto_id" name="produto_id" required>
                <?php foreach ($produtos["produtos"] as $produto): ?>
                    <option value="<?= $produto['id']; ?>" <?= $produto['id'] == $ordem['ordens']['produto_id'] ? 'selected' : ''; ?> ><?= $produto['codigo'] .' - '.$produto['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="csrf" value="<?= $csrf; ?>" required>
        <input type="hidden" name="id" value="<?= $_GET['id']; ?>" required>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" name="edit-order-telecontrol" class="btn btn-success">Salvar</button>
    </form>
</body>
</html>