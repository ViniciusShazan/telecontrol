<?php

    session_start();
    
    require_once 'ClientsController.php';
    require_once 'ProductsController.php';
    require_once 'OrdersController.php';
    require_once '../../assets/menu/config.php';

    //Valida se o token CSRF é valido
    if (isset($_POST['csrf']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
            //Valida qual requisição é a pagina
            switch ($_POST['_method']) {
                // se for POST
                case 'POST':
                    if (isset($_POST['tele_create'])) {
                        try {
                            //Remove dados potencialmente prejudiciais
                            $dados = [
                                'nome' => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
                                'cpf' => filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW),
                                'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_UNSAFE_RAW)
                            ];

                            //Chama a classe
                            $cliente = new ClientsController();
                            
                            //Retorna se foi cadastrado ou não
                            $create = $cliente->create($dados);
                            
                            if ($create['status'] == true) {
                                $_SESSION['toast'] = $create;
                                header('Location: '.BASE_URL.'/clients');
                                die();
                            }
                            else {
                                
                                $_SESSION['toast'] = $create;
                                header('Location: '.BASE_URL.'/clients');
                                die();
                            }

                        } catch (\Throwable $th) {
                            error_log($th);
                            
                            $_SESSION['toast'] = [
                                'status' => false,
                                'type' => 'warning',
                                'msg' => 'Ops, algo inesperado aconteceu 0x004'
                            ];
                            header('Location: '.BASE_URL.'/clients');
                            die();
                        }
                    }
                    elseif (isset($_POST['create-product'])) {
                        try {
                            $dados = [
                                'codigo' => filter_input(INPUT_POST, 'codigo', FILTER_UNSAFE_RAW),
                                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW),
                                'status' => filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW),
                                'tempo_garantia' => filter_input(INPUT_POST, 'tempo_garantia', FILTER_UNSAFE_RAW)
                            ];

                            //Chama a classe
                            $products = new ProductsController();
                            
                            //Retorna se foi cadastrado ou não
                            $create = $products->create($dados);
                            
                            if ($create['status'] == true) {
                                $_SESSION['toast'] = $create;
                                header('Location: products');
                                die();
                            }
                            else {
                                $_SESSION['toast'] = $create;
                                header('Location: products');
                                die();
                            }
                        } catch (\Throwable $th) {
                            error_log($th);
                            
                            $_SESSION['toast'] = [
                                'status' => false,
                                'type' => 'warning',
                                'msg' => 'Ops, algo inesperado aconteceu 0x004'
                            ];
                            header('Location: '.BASE_URL.'/products');
                            die();
                        }
                        echo '<pre>'; var_dump($_POST, $dados); die();
                    }
                    elseif (isset($_POST['crate-order-telecontrol'])) {
                        
                        try {
                            $dados = [
                                "numero" => filter_input(INPUT_POST, 'numero_ordem', FILTER_UNSAFE_RAW),
                                "data" => filter_input(INPUT_POST, 'data_abertura', FILTER_UNSAFE_RAW),
                                "nome" => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
                                "cpf" => filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW),
                                "produto" => filter_input(INPUT_POST, 'produto_id', FILTER_UNSAFE_RAW)
                            ];

                            //Chama a classe
                            $order = new OrdersController();

                            //Retorna se foi cadastrado ou não
                            $create = $order->create($dados);

                            if ($create['status'] == true) {
                                $_SESSION['toast'] = $create;
                                header('Location: ./orders');
                                die();
                            }
                            else {
                                $_SESSION['toast'] = $create;
                                header('Location: ./orders');
                                die();
                            }
                        } catch (\Throwable $th) {
                            error_log($th);
                            var_dump($th); die();
                            $_SESSION['toast'] = [
                                'status' => false,
                                'type' => 'warning',
                                'msg' => 'Ops, algo inesperado aconteceu 0x004'
                            ];
                            header('Location: ./orders');
                            die();
                        }
                    }
                    else {
                        $_SESSION['toast'] = [
                            'status' => false,
                            'type' => 'warning',
                            'msg' => 'Ops, algo inesperado aconteceu 0x006'
                        ];
                        header('Location: '.BASE_URL.'/clients');
                        die();
                    }

                    header('Location: '.BASE_URL.'/home');
                    die();

                    break;
                //Se for PUT
                case 'PUT':
                    //Se o POST é de edição
                    if (isset($_POST['tele_edit'])) {
                        
                        try {
                            //Remove dados potencialmente prejudiciais
                            $dados = [
                                'id' => filter_input(INPUT_POST, 'id', FILTER_UNSAFE_RAW),
                                'nome' => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
                                'cpf' => filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW),
                                'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_UNSAFE_RAW)
                            ];

                            //Chama a classe
                            $cliente = new ClientsController();
                            
                            //Retorna se foi cadastrado ou não
                            $update = $cliente->update($dados);

                            if ($update['status'] == true) {
                                $_SESSION['toast'] = $update;
                                
                                header('Location: '.BASE_URL.'/clients');
                                die();
                            }
                            else {
                                $_SESSION['toast'] = $update;
                                header('Location: '.BASE_URL.'/clients');
                                die();
                            }

                        } catch (\Throwable $th) {
                            error_log($th);
                            $_SESSION['toast'] = [
                                'status' => false,
                                'type' => 'warning',
                                'msg' => 'Ops, algo inesperado aconteceu 0x005'
                            ];
                            header('Location: '.BASE_URL.'/clients');
                            die();
                        }
                    }
                    elseif (isset($_POST['edit_product'])) {
                        try {
                            //Remove dados potencialmente prejudiciais
                            $dados = [
                                'id' => filter_input(INPUT_POST, 'id', FILTER_UNSAFE_RAW),
                                'codigo' => filter_input(INPUT_POST, 'codigo', FILTER_UNSAFE_RAW),
                                'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW),
                                'status' => filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW),
                                'tempo_garantia' => filter_input(INPUT_POST, 'tempo_garantia', FILTER_UNSAFE_RAW),

                            ];

                            //Chama a classe
                            $produto = new ProductsController();
                            
                            //Retorna se foi cadastrado ou não
                            $update = $produto->update($dados);

                            if ($update['status'] == true) {
                                $_SESSION['toast'] = $update;
                                header('Location: '.BASE_URL.'/products');
                                die();
                            }
                            else {
                                $_SESSION['toast'] = $update;
                                header('Location: '.BASE_URL.'/products');
                                die();
                            }

                        } catch (\Throwable $th) {
                            error_log($th);
                            $_SESSION['toast'] = [
                                'status' => false,
                                'type' => 'warning',
                                'msg' => 'Ops, algo inesperado aconteceu 0x005'
                            ];
                            header('Location: products');
                            die();
                        }
                    }
                    elseif (isset($_POST['edit-order-telecontrol'])) {
                        //Remove dados potencialmente prejudiciais
                        $dados = [
                            'id' => filter_input(INPUT_POST, 'id', FILTER_UNSAFE_RAW),
                            'nome' => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
                            'produto_id' => filter_input(INPUT_POST, 'produto_id', FILTER_UNSAFE_RAW)
                        ];

                        //Chama a classe
                        $ordem = new OrdersController();
                            
                        //Retorna se foi cadastrado ou não
                        $update = $ordem->update($dados);

                        if ($update['status'] == true) {
                            $_SESSION['toast'] = $update;
                            header('Location: '.BASE_URL.'/orders');
                            die();
                        }
                        else {
                            $_SESSION['toast'] = $update;
                            header('Location: '.BASE_URL.'/orders');
                            die();
                        }
                    }
                    else {
                        $_SESSION['toast'] = [
                            'status' => false,
                            'type' => 'warning',
                            'msg' => 'Ops, algo inesperado aconteceu 0x006'
                        ];
                        header('Location: '.BASE_URL.'/clients');
                        die();
                    }
                    break;
                // se for DELETE
                case 'DELETE':
                    if (isset($_POST['tele_remove'])) {
                        $cliente = new ClientsController();
                        
                        $remove = $cliente->remove($_POST['id']);
                        if ($remove['status'] == true) {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/clients');
                            die();
                        }
                        else {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/clients');
                            die();
                        }
                    }
                    elseif (isset($_POST['remove_product'])) {
                        //Chama a classe
                        $produto = new ProductsController();
                        
                        //tenta remover o produto
                        $remove = $produto->remove($_POST['id']);
                        if ($remove['status'] == true) {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/'.BASE_URL.'/products');
                            die();
                        }
                        else {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/'.BASE_URL.'/products');
                            die();
                        }
                    }
                    elseif (isset($_POST['remove-order-telecontrol'])) {
                        //Chama a classe
                        $orders = new OrdersController();
                        
                        //tenta remover o produto
                        $remove = $orders->remove($_POST['id']);
                        if ($remove['status'] == true) {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/orders');
                            die();
                        }
                        else {
                            $_SESSION['toast'] = $remove;
                            header('Location: '.BASE_URL.'/orders');
                            die();
                        }
                    }
                    else {
                        $_SESSION['toast'] = [
                            'status' => false,
                            'type' => 'warning',
                            'msg' => 'Ops, algo inesperado aconteceu 0x006'
                        ];
                        header('Location: '.BASE_URL.'/clients');
                        die();
                    }
                    break;
                // se não for nenhum dos anteriores, retorna ao inicio
                default:
                    header('Location: '.BASE_URL.'/'.BASE_URL.'/home');
                    die();
                    break;
            }
        } else {
            $_SESSION['toast'] = [
                'status' => false,
                'type' => 'warning',
                'msg' => 'Ops, algo inesperado aconteceu 0x003'
            ];
            header('Location: ./home');
            die();
        }
        
        
    } else {
        $_SESSION['toast'] = [
            'status' => false,
            'type' => 'warning',
            'msg' => 'Ops, algo inesperado aconteceu 0x003'
        ];
        header('Location: ./home');
        die();
    }
        