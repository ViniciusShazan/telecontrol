<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/OrdersController.php';
    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';

    //carrega a classe produto controller
    $products = new ProductsController();

    //Busca todos os produtos cadastrados
    $produtos = $products->index();

    if ($produtos["status"] == false) {
        $_SESSION['toast'] = [
            "status" => false,
            "type" => "warning",
            "msg" => "Não existe produto cadastrado"
        ];

        header('Location: ./home');
    }

?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar uma Orden de Servico</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>
    
    <form action="created-order" method="post">
        <h1>Criar Ordem</h1>
        <div class="form-group">
            <label for="numero_ordem">Numero da Ordem</label>
            <input type="number" class="form-control" name="numero_ordem" id="numero_ordem" required>
        </div>
        <div class="form-group">
            <label for="data_abertura">Data Abertura</label>
            <input type="date" class="form-control" name="data_abertura" id="data_abertura" required>
        </div>
        <div class="form-group">
            <label for="nome">Nome do Consumidor</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF do Consumidor</label>
            <input type="text" class="form-control" name="cpf" id="cpf" required>
        </div>
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select class="form-control" id="produto_id" name="produto_id" required>
                <?php foreach ($produtos["produtos"] as $produto): ?>
                    <option value="<?php echo $produto['id']; ?>"><?php echo $produto['codigo'] .' - '.$produto['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="_method" value="POST">
        <button type="submit" name="crate-order-telecontrol" class="btn btn-success">Salvar</button>
    </form>
</body>
</html>