<?php
    session_start();

    require_once '../../Controllers/OrdersController.php';
    require_once '../../../assets/token/csrf.php';    

    try {
        //carrega a classe cliente controller
        $orders = new OrdersController();

        //Carrega o cliente selecionado
        $ordem = $orders->show($_GET['id']);

        if ($ordem["status"] == false) {
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
    <title>Remover ordem</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>
    
    <form action="delete-order" method="POST">
        <h1>Tem certeza que deseja remover a ordem Nº<?= $ordem['ordens']['id']; ?> ?</h1>
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" name="remove-order-telecontrol" class="btn btn-success">Sim</button>
        <button type="button" class="btn btn-cancel"><a href="../orders">Não</a></button>
    </form>
</body>
</html>