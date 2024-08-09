<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ClientsController.php';
    require_once '../../../assets/token/csrf.php';

    try {
        //carrega a classe cliente controller
        $clients = new ClientsController();

        //Carrega o cliente selecionado
        $clientes = $clients->show($_GET['id']);

        if ($clientes["status"] == false) {
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
    <form action="edit/client" method="POST">
        <h1>Cliente Nº<?php echo $_GET['id']; ?></h1>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= $clientes['clientes']['nome'] ?>" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $clientes['clientes']['cpf'] ?>" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereco</label>
            <input type="text" class="form-control" name="endereco" id="endereco" value="<?= $clientes['clientes']['endereco'] ?>" required> 
        </div>      
        
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" name="tele_edit" class="btn btn-success">Salvar</button>
    </form>
</body>
</html>