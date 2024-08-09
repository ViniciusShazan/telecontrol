<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';

?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar produto</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>

    <h1>Produtos</h1>
    <form action="created-product" method="POST">
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tempo_garantia">Tempo de Garantia (Meses)</label>
            <input type="int" class="form-control" id="tempo_garantia" name="tempo_garantia" required>
        </div>
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="_method" value="POST">
        <button type="submit" name="create-product" class="btn btn-success">Cadastrar</button>
    </form>
</body>
</html>