<?php

require_once __DIR__ . '/../database/PDO_Connection.php';
require_once __DIR__ . '/../Models/Client.php';

use App\Models\Client;

class ClientsController 
{
    private $clients;

    function __construct()
    {
        $this->clients = new Client();
    }

    //Lista todos os clientes
    function index() {
        return $this->clients->index();
    }

    //Cria um cliente
    function create($cliente) {
        $clients = $this->clients;
        //Valida se o cpf é valido
        if ($clients->validar($cliente['cpf'])) {
            //Valida se o cliente ja existe
            if ($clients->verificarCadastrarCliente($cliente) !== false) {
                return [
                    'status' => true,
                    'type' => 'success',
                    'msg' => 'Cliente cadastrado com sucesso!'
                ];
            }
            else {
                return [
                    'status' => false,
                    'type' => 'warning',
                    'msg' => 'Cliente ja existe!'
                ];
            }
        }else {
            return [
                'status' => false,
                'type' => 'warning',
                'msg' => 'CPF não é valido!'
            ];
        }
    }

    //Edita um cliente
    function update($cliente) {
        return $this->clients->update($cliente);
    }

    //Lista um cliente
    function show($id) {
        $clients = new Client();
        return $clients->show($id);
    }

    function remove($id) {
        return $this->clients->remove($id);
    }
}
