CREATE DATABASE estoque;
USE estoque;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    cpf VARCHAR(20) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    permissao VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS gestao(
    idgestao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    unidade VARCHAR(100) NOT NULL,
    quantidade INT(100),
    minimo INT(100)
);

CREATE TABLE IF NOT EXISTS movimentacao(
    idmovimentacao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    status_produto VARCHAR(20),
    tipo VARCHAR(8) NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);