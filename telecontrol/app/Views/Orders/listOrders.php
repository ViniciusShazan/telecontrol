<?php  
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/OrdersController.php';
    require_once '../../../assets/token/csrf.php';

    //carrega a classe orders controller
    $orders = new OrdersController();

    //Busca todos as ordens cadastrados
    $ordens = $orders->index();
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordens de Servico</title>
    <link rel="stylesheet" href="assets/css/tables.css">
    <link rel="stylesheet" href="assets/css/toast.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
        <a href="createOrder">Nova ordem de servico</a>
    </div>

    <?php
        //instancia os alarmes
        require_once '../../../assets/toast/toast.php';

        if ($ordens['status'] == false && $ordens['type'] == 'nullable') {
            echo '<h1>'.$ordens['msg'].'</h1>';
        }
        else {
    ?>
            <h1>Ordens</h1>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número Ordem</th>
                        <th>Data Abertura</th>
                        <th>Nome do Cliente</th>
                        <th>Produto</th>
                        <th>Cod. Produto</th>
                        <th>Editar</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordens["ordens"] as $orden): ?>
                        <tr>
                            <td><?php echo $orden['id']; ?></td>
                            <td><?php echo $orden['numero_ordem']; ?></td>
                            <td><?php echo $orden['data_abertura']; ?></td>
                            <td><?php echo $orden['nome']; ?></td>
                            <td><?php echo $orden['descricao']; ?></td>
                            <td><?php echo $orden['codigo']; ?></td>
                            <td><a href="./update-orden/<?php echo $orden['id'] ?>">Editar</a></td>
                            <td><a href="./remove-orden/<?php echo $orden['id'] ?>">Remover</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php
        }
    ?>    
</body>
</html>