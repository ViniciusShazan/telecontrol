<?php

require_once __DIR__ . '/../database/PDO_Connection.php';
require_once __DIR__ . '/../Models/Products.php';

use App\Models\Product;

class ProductsController 
{
    private $products;

    function __construct()
    {
        $this->products = new Product();
    }

    function index() {
        return $this->products->index();
    }

    function create($produto) {
        if ($this->products->verificarCadastrarProduto($produto) !== false) {
            return [
                'status' => true,
                'type' => 'success',
                'msg' => 'Produto cadastrado com sucesso!'
            ];
        }
        else {
            return [
                'status' => false,
                'type' => 'warning',
                'msg' => 'Produto ja existe!'
            ];
        }
    }

    //Lista um produto
    function show($id) {
        $products = new Product();
        return $products->show($id);
    }

    //Edita um produto
    function update($produto) {
        return $this->products->update($produto);
    }

    //Remover um produto
    function remove($id) {
        return $this->products->remove($id);
    }
}
