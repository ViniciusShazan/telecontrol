<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';

    try {
        //carrega a classe cliente controller
        $products = new ProductsController();

        //Carrega o cliente selecionado
        $produtos = $products->show($_GET['id']);

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
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>
    <form action="edit-telecontrol" method="POST">
        <h1>Produto Nº<?php echo $_GET['id']; ?></h1>
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" value="<?= $produtos['produtos']['codigo'] ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?= $produtos['produtos']['descricao'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="1" <?= $produtos['produtos']['status'] == true ? 'selected' : '' ?>>Ativo</option>
                <option value="0" <?= $produtos['produtos']['status'] == false ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>
        <div class="form-group">
        <label for="tempo_garantia">Tempo de Garantia (Meses)</label>
        <input type="int" class="form-control" id="tempo_garantia" name="tempo_garantia" value="<?= $produtos['produtos']['tempo_garantia'] ?>" required>
        </div>
        
        
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" name="edit_product" class="btn btn-success">Salvar</button>
    </form>
</body>
</html>