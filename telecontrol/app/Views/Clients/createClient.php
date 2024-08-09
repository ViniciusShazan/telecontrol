<?php
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ClientsController.php';
    require_once '../../../assets/token/csrf.php';
    require_once '../../../assets/menu/navbar.php';

?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar cliente</title>
</head>
<body>
    <form action="created/client" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereco</label>
            <input type="text" name="endereco" id="endereco" required>
        </div>
      
        <input type="hidden" name="csrf" value="<?php echo $csrf; ?>" required>
        <input type="hidden" name="_method" value="POST">
        <button type="submit" name="tele_create">Salvar</button>
    </form>
</body>
</html>

<!-- Nome, CPF e Endereço -->