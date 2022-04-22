DROP DATABASE IF EXISTS suplementos;

CREATE DATABASE IF NOT EXISTS suplementos;

USE suplementos;


CREATE TABLE clientes(
    id_cliente INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(300) NOT NULL,
    senha VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nascimento DATE,
    endereco VARCHAR(300),
    imagem TEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE administradores(
    id_administrador INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(300) NOT NULL,
    senha VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nascimento DATE,
    imagem TEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE suplementos(
    id_suplemento INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_administrador INTEGER NOT NULL,
    promocao BOOLEAN,
    data DATE,
    porcentagem INTEGER,
    tipo VARCHAR(30) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    preco INTEGER NOT NULL,
    quantidade INTEGER NOT NULL,
    lancamento BOOLEAN,
    imagem TEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE pedidos(
    id_pedido INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_suplemento INTEGER NOT NULL,
    id_cliente INTEGER NOT NULL,
    status VARCHAR(35) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    preco INTEGER NOT NULL,
    quantidade INTEGER NOT NULL,
    imagem TEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;


ALTER TABLE pedidos ADD
CONSTRAINT id_cliente_fk foreign key (id_cliente)
REFERENCES clientes (id_cliente);

ALTER TABLE pedidos ADD
CONSTRAINT id_suplemento_fk foreign key (id_suplemento)
REFERENCES suplementos (id_suplemento);

ALTER TABLE suplementos ADD
CONSTRAINT id_administrador_fk foreign key (id_administrador)
REFERENCES administradores (id_administrador);

INSERT INTO clientes(id_cliente,nome,senha,email) VALUE (DEFAULT,"michael","123","michael@gmail.com");

select * from suplementos LIMIT 0, 3;

/*
CREATE TABLE promocoes(
    id_promocao INTEGER NOT NULL PRIMARY KEY,
    porcentagem VARCHAR(300) NOT NULL,
    dias INTEGER NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;




ALTER TABLE promocoes ADD
CONSTRAINT id_suplementos_fk foreign key (id_promocao)
REFERENCES suplementos (id_suplemento);
*/