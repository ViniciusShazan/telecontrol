<?php

require_once __DIR__ . '/../database/PDO_Connection.php';
require_once __DIR__ . '/../Models/Order.php';

use App\Models\Client;
use App\Models\Order;

class OrdersController 
{
    private $orders;

    function __construct(){
        $this->orders = new Order();
    }

    //Lista todos as ordens
    function index() {
        return $this->orders->index();
    }

    function create($orders) {
        //remover caracteres especiais e permanecer com os numeros
        $cpf = preg_replace('/\D/', '', $orders['cpf']);

        if (!Client::validar($cpf)) {
            return [
                'status' => false,
                'type' => 'warning',
                'msg' => 'CPF invalido!'
            ];
        }

        $create = $this->orders->verificarCadastrarOrdem($orders);

        if ($create !== false && isset($create['status']) && $create['status'] !== false) {
            return [
                'status' => true,
                'type' => 'success',
                'msg' => 'Ordem cadastrado com sucesso!'
            ];
        }
        elseif (isset($create['status']) && $create['status'] == false) {
            return $create;
        }
        elseif ($create > 0) {
            return [
                'status' => true,
                'type' => 'success',
                'msg' => 'Ordem cadastrado com sucesso, cliente criado com sucesso, por favor altere o endereco do usuario '. $create
            ];
        }
        else {
            return [
                'status' => false,
                'type' => 'warning',
                'msg' => 'Ordem ja existe!'
            ];
        }
    }

    //Lista uma ordem
    function show($id) {
        $orders = new Order();
        return $orders->show($id);
    }

    //Edita um ordem
    function update($ordem) {
        return $this->orders->update($ordem);
    }

    //Remover um ordem
    function remove($id) {
        return $this->orders->remove($id);
    }
}
