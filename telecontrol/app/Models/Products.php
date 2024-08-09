<?php

namespace App\Models;

use App\Database\Conexao;
use PDO;

class Product
{
    //listagem de produtos
    function index() {
        try {
            return $this->getProducts();
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    //Retorna a lista de produtos cadastrados
    function getProducts() {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT * FROM produtos");
            $con->execute();

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'produtos' => $con->fetchAll(PDO::FETCH_ASSOC)
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

    // Função para verificar e cadastrar produto automaticamente
    static function verificarCadastrarProduto($produto) {
        $stmt = Conexao::getInstance()->prepare("SELECT id FROM produtos WHERE codigo = ?");;
        $stmt->execute([$produto['codigo']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        //Se produto existe
        if ($product) {
            return $product['id'];
        } else {
            try {
                //Cria o produto que não existe
                $stmt = Conexao::getInstance()->prepare("INSERT INTO produtos (codigo, descricao, status, tempo_garantia) VALUES (?, ?, ?, ?)");
                $stmt->execute([$produto['codigo'], $produto['descricao'], $produto['status'], $produto['tempo_garantia']]);
                return Conexao::getInstance()->lastInsertId();
            } catch (\Throwable $th) {
                error_log($th);

                return false;
            }
            
        }
    }

    //listagem de produto
    function show($codigo) {
        try {
            return $this->getProduto($codigo);
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    //Retorna um produto
    private function getProduto($codigo) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT * FROM produtos WHERE id = ?");
            $con->execute([$codigo]);

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'produtos' => $con->fetch(PDO::FETCH_ASSOC)
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

    //funcao para editar produto
    function update($produto) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("UPDATE produtos SET codigo = ?, descricao = ?, status = ?, tempo_garantia = ? WHERE id = ?");
            $con->execute([$produto['codigo'], $produto['descricao'], $produto['status'], $produto['tempo_garantia'], $produto['id']]);


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

    //Funcao para remover produto
    function remove($id) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("DELETE FROM produtos WHERE id = ?");
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
                    'msg' => 'Esse produto não pode ser removido!'
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
