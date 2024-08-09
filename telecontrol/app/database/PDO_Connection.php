<?php

namespace App\Database;

use PDO;

class Conexao {

    public static $instance;

    private static $endereco = 'localhost';
    private static $banco = 'test';
    private static $usuario = 'root';
    private static $senha = '';


    public static function getInstance() {
        // Verifica se a instância já está setada
        if (!isset(self::$instance)) {
            // Cria uma nova instância do PDO se não estiver setada
            self::$instance = new PDO(
                "mysql:host=" . self::$endereco . ";port=3306;dbname=" . self::$banco, 
                self::$usuario, 
                self::$senha
            );
            // Define o modo de erro para exceções
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Define o tratamento de NULLs para strings vazias
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }
    
        // Retorna a instância do PDO
        return self::$instance;
    }
    
}

?>