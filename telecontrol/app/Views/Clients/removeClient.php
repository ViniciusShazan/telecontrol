<?php
    session_start();

    require_once '../../Controllers/ClientsController.php';
    require_once '../../../assets/token/csrf.php';

    try {
        $clients = new ClientsController();
        $cliente = $clients->show($_GET['id']);
        
        if ($cliente["status"] == false) {
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
    <title>Remover Cliente</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
    </div>
    
    <form action="delete/client" method="POST">
    <h1>Tem certeza que deseja remover o cliente : <?= $cliente['clientes']['nome']; ?> ?</h1>
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" name="tele_remove" class="btn btn-success">Sim</button>
        <button class="btn btn-cancel"><a href="../clients">Não</a></button>
    </form>
</body>
</html>