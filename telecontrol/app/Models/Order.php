<?php

namespace App\Models;

use App\Database\Conexao;
use PDO;

class Order
{
    //listagem de ordens
    function index() {
        try {
            return $this->getOrders();
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    //Retorna a lista de ordens cadastrados
    private function getOrders() {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT os.*, clientes.nome, clientes.cpf, produtos.codigo, produtos.descricao  FROM ordens_servicos AS os LEFT JOIN clientes ON clientes.id = os.cliente_id LEFT JOIN produtos ON produtos.id = os.produto_id");
            $con->execute();

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'ordens' => $con->fetchAll(PDO::FETCH_ASSOC)
                ];
                    
            }
            return [
                'status' => false, 
                'type' => 'nullable', 
                'msg' => 'Não existe nenhum registro'
            ];
        } catch (\Throwable $th) {
            // caso aconteca algo na consulta 
            error_log($th);

            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
    }

    function create($ordem) {
        if (isset($ordem['cpf'])) {
            $cpf = preg_replace('/\D/', '', $ordem['cpf']);
            $valida = Client::validar($cpf);

            if ($valida == false) {
                return [
                    'status' => false, 
                    'type' => 'warning', 
                    'msg' => 'Cpf invalido!'
                ];
            }
            else {
                # code...
            }
        }
        else {
            return [
                'status' => false, 
                'type' => 'danger', 
                'msg' => 'Cpf não informado!'
            ];
        }
        
    }

    // Função para verificar e cadastrar produto automaticamente
    static function verificarCadastrarOrdem($ordem) {
        $stmt = Conexao::getInstance()->prepare("SELECT id FROM ordens_servicos WHERE numero_ordem  = ?");;
        $stmt->execute([$ordem['numero']]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Se ordem nao existe
        if (!$order) {
            $dados = [
                "nome" => $ordem['nome'],
                "cpf" => $ordem['cpf'],
                "endereco" => ''
            ];
            //Verica se existe o cliente, caso nao cadastra
            $cliente = Client::verificarCadastrarCliente($dados);

            if ($cliente !== false) {
                //Cria a ordem
                $stmt = Conexao::getInstance()->prepare("INSERT INTO ordens_servicos (numero_ordem, data_abertura, cliente_id, produto_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$ordem['numero'], $ordem['data'], $cliente, $ordem['produto']]);
                return $cliente;
            }
            
        } else {
            return [
                "status" => false,
                "type" => 'warning',
                "msg" => 'Existe uma ordem com o mesmo numero '.$ordem['numero']
            ];
            
        }
    }

    //listagem de produto
    function show($id) {
        try {
            return $this->getOrdem($id);
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    //Retorna a lista de ordens cadastrados
    private function getOrdem($id) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT os.*, clientes.nome, clientes.cpf, produtos.codigo, produtos.descricao  FROM ordens_servicos AS os LEFT JOIN clientes ON clientes.id = os.cliente_id LEFT JOIN produtos ON produtos.id = os.produto_id WHERE os.id = ?");
            $con->execute([$id]);

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'ordens' => $con->fetch(PDO::FETCH_ASSOC)
                ];
                    
            }
            return [
                'status' => false, 
                'type' => 'nullable', 
                'msg' => 'Não existe nenhum registro'
            ];
        } catch (\Throwable $th) {
            // caso aconteca algo na consulta 
            error_log($th);

            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
    }

    //funcao para editar ordem
    function update($ordem) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("UPDATE ordens_servicos SET produto_id = ? WHERE id = ?");
            $con->execute([$ordem['produto_id'], $ordem['id']]);


            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'type' => 'success', 
                    'msg' => 'Editado com sucesso!'
                ];
                    
            }
            return [
                'status' => false, 
                'type' => 'nullable', 
                'msg' => 'Não existe alteração a ser feito!'
            ];
        } catch (\Throwable $th) {
            // caso aconteca algo na consulta 
            error_log($th);

            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }  
    }

    //Funcao para remover ordem
    function remove($id) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("DELETE FROM ordens_servicos WHERE id = ?");
            $con->execute([$id]);

            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'type' => 'success', 
                    'msg' => 'Removido com sucesso!'
                ];
            }
            else {
                return [
                    'status' => false, 
                    'type' => 'nullable', 
                    'msg' => 'Essa ordem não pode ser removido!'
                ];
            }

        
        } catch (\Throwable $th) {
            error_log($th);

            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
    }
}
