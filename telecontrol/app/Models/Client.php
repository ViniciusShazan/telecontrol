<?php

namespace App\Models;

use App\Database\Conexao;
use PDO;

class Client 
{
    //listagem de clientes
    function index() {
        try {
            return $this->getClients();
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    //listagem de clientes
    function show($id) {
        try {
            return $this->getCliente($id);
        } catch (\Throwable $th) {
            error_log($th);
            
            return [
                'status' => false, 
                'type' => 'warning', 
                'msg' => 'Ops, ocorreu algum erro, código: 0x001'
            ];
        }
        
    }

    // Veirifica se o CPF é valido
    static function validar($cpf) {
        //remover caracteres especiais e permanecer com os numeros
        $cpf = preg_replace('/\D/', '', $cpf);

        //Verificar a quantidade de numeros
        if (strlen($cpf) != 11) {
            return false;
        }

        //Validar digitos
        $validar = substr($cpf, 0, 9);
        $validar .= self::calcularDigitoVerificador($validar);

        //Compara o cpf com o cpf validado
        return $validar = $cpf;
    }

    //Calcula um digito verificador com base em uma sequencia numerica
    static function calcularDigitoVerificador($base) {
         $tamanho = strlen($base);
         $multiplicador = $tamanho + 1;

         $soma = 0;

         //Itera os numeros do CPF
         for ($i=0; $i < $tamanho; $i++) { 
            $soma += $base[$i] * $multiplicador;
            $multiplicador --;
         }

         //Resto da divisao
          $resto = $soma % 11;

          //Retorna digito verificador
          return $resto > 1 ? 11 - $resto : 0;
    }

    //Retorna a lista de clientes cadastrados
    private function getClients() {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT * FROM clientes");
            $con->execute();

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'clientes' => $con->fetchAll(PDO::FETCH_ASSOC)
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

    //Retorna um cliente
    private function getCliente($id) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("SELECT * FROM clientes WHERE id = ?");
            $con->execute([$id]);

            //Se existe resultado (Linha de retorno for maior que 0)
            if ($con->rowCount() > 0) {
                return [
                    'status' => true,
                    'clientes' => $con->fetch(PDO::FETCH_ASSOC)
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
    

    // Função para verificar e cadastrar cliente automaticamente
    static function verificarCadastrarCliente($cliente) {
        $stmt = Conexao::getInstance()->prepare("SELECT id FROM clientes WHERE cpf = ?");;
        $stmt->execute([$cliente['cpf']]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        //Se cliente existe
        if ($client) {
            return $client['id'];
        } else {
            try {
                //Cria o cliente que não existe
                $stmt = Conexao::getInstance()->prepare("INSERT INTO clientes (nome, cpf, endereco) VALUES (?, ?, ?)");
                $stmt->execute([$cliente['nome'], $cliente['cpf'], $cliente['endereco']]);
                return Conexao::getInstance()->lastInsertId();
            } catch (\Throwable $th) {
                error_log($th);

                return false;
            }
            
        }
    }

    //funcao para editar cliente
    function update($cliente) {
        try {
            $cpf = preg_replace('/\D/', '', $cliente['cpf']);
            //VAlida se o CPF é valido
            if(self::validar($cpf) == false) {
                return [
                    'status' => false, 
                    'type' => 'warning', 
                    'msg' => 'CPF Invalido!'
                ];
            }

            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("UPDATE clientes SET nome = ?, cpf = ?, endereco = ? WHERE id = ?");
            $con->execute([$cliente['nome'], $cpf, $cliente['endereco'], $cliente['id']]);

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

    //Funcao para remover cliente
    function remove($id) {
        try {
            //Tentando a conexao com o banco
            $con = Conexao::getInstance()->prepare("DELETE FROM clientes WHERE id = ?");
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
                    'msg' => 'Esse cliente não pode ser removido!'
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
