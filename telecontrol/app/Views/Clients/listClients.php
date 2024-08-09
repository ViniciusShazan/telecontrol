<?php  
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ClientsController.php';
    require_once '../../../assets/token/csrf.php';

    //carrega a classe cliente controller
    $clients = new ClientsController();

    //Busca todos os clientes cadastrados
    $clientes = $clients->index();

?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="assets/css/tables.css">
    <link rel="stylesheet" href="assets/css/toast.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
        <a href="createClient">Novo cliente</a>
    </div>
    
    <?php
        //instancia os alarmes
        require_once '../../../assets/toast/toast.php';

        if ($clientes['status'] == false && $clientes['type'] == 'nullable') {
            echo '<h1>'.$clientes['msg'].'</h1>';
        }
        else {
    ?>
            <h1>Clientes</h1>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Endenreco</th>
                        <th>Editar</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($clientes["clientes"] as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['cpf']; ?></td>
                        <td><?php echo $cliente['endereco']; ?></td>
                        <td><a href="./update-cliente/<?php echo $cliente['id'] ?>">Editar</a></td>
                        <td><a href="./remove-cliente/<?php echo $cliente['id'] ?>">Remover</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

    <?php
        }
    ?>    
</body>
</html>