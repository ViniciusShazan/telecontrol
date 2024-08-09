<?php
    session_start();

    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';    

    try {
        //carrega a classe cliente controller
        $products = new ProductsController();

        //Carrega o cliente selecionado
        $produtos = $products->show($_GET['id']);

        if ($produtos["status"] == false) {
            header('Location: home');
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
    <title>Remover produto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>

    <form action="delete/client" method="POST">
        <h1>Tem certeza que deseja remover o produto : <?= $produtos['produtos']['codigo']; ?> ?</h1>
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" name="remove_product" class="btn btn-success">Sim</button>
        <button type="button" class="btn btn-cancel"><a href="../products">Não</a></button>
    </form>
</body>
</html>