Tabela de Erros

0x001 = Erro ao conectar com o banco de dados;
0x003 = Erro de CSRF token;
0x004 = Erro ao filtrar os dados para criar um registro
0x005 = Erro ao filtrar os dados para editar um registro
0x006 = Botao de submit não encontrado


Configurando banco de dados:
    CREATE DATABASE sistema_ordem_servico;

    USE sistema_ordem_servico;

    CREATE TABLE clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        cpf VARCHAR(14) NOT NULL,
        endereco TEXT 
    );

    CREATE TABLE produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        codigo VARCHAR(50) NOT NULL,
        descricao TEXT NOT NULL,
        status BOLEAN NOT NULL,
        tempo_garantia INT NOT NULL
    );

    CREATE TABLE ordens_servicos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        numero_ordem VARCHAR(50) NOT NULL,
        data_abertura DATE NOT NULL,
        cliente_id INT,
        produto_id INT,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id),
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    );
