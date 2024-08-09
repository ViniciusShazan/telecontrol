<?php  
    //inicia sessao
    session_start();

    //carrega as dependencias, como controladores, e codigos globais
    require_once '../../Controllers/ProductsController.php';
    require_once '../../../assets/token/csrf.php';
    
    //carrega a classe produto controller
    $products = new ProductsController();

    //Busca todos os produtos cadastrados
    $produtos = $products->index();
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo</title>
    <link rel="stylesheet" href="assets/css/tables.css">
    <link rel="stylesheet" href="assets/css/toast.css">
</head>
<body>
    <div class="center">
        <?php require_once '../../../assets/menu/navbar.php'; ?>
        <a href="createProduct">Novo produto</a>
    </div>
    
    <?php
        //instancia os alarmes
        require_once '../../../assets/toast/toast.php';

        //Valida se nao existe registro
        if ($produtos['status'] == false && $produtos['type'] == 'nullable') {
            echo '<h1>'.$produtos['msg'].'</h1>';
        }
        else {
    ?>
    <h1>Produtos</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Tempo de Garantia</th>
                <th>Editar</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos["produtos"] as $produto): ?>
                <tr>
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo $produto['codigo']; ?></td>
                    <td><?php echo $produto['descricao']; ?></td>
                    <td><?php echo $produto['status'] == true ? 'Ativo' : 'Inativo'; ?></td>
                    <td><?php echo $produto['tempo_garantia']; ?> Meses</td>
                    <td><a href="./update-produto/<?php echo $produto['id'] ?>">Editar</a></td>
                    <td><a href="./remove-produto/<?php echo $produto['id'] ?>">Remover</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
        }
    ?>   
</body>
</html>