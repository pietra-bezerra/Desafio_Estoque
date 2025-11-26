CREATE DATABASE "desafio_estoque"
USE desafio_estoque

CREATE TABLE gestao(
    idgestao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    unidade VARCHAR(100) NOT NULL,
    quantidade INT(100),
    minimo INT(100)
)

CREATE TABLE usuarios(

)
