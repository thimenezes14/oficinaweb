-- COMANDOS DE CRIAÇÃO --
-- ESTES CHARACTER SET E COLLATE GARANTEM O CASE SENSITIVITY DO BANCO DE DADOS.

CREATE DATABASE IF NOT EXISTS oficina DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs ;
USE oficina;

CREATE USER IF NOT EXISTS 'gu3000265'@'localhost' IDENTIFIED BY 'senha123';
GRANT ALL PRIVILEGES ON * TO 'gu3000265'@'localhost';

CREATE TABLE IF NOT EXISTS tb_comandas(
	numero numeric(6) ZEROFILL NOT NULL,
    dt_cmd date NOT NULL,
    valor decimal(7,2) NOT NULL,
    descr varchar(50),
    status_cmd char(1) NOT NULL,
    dt_reg date NOT NULL,
    
    CONSTRAINT pk_comandas PRIMARY KEY(numero, dt_cmd),
    CONSTRAINT chk_status CHECK(status_cmd IN('P', 'C', 'B'))
    /* P - Pendente; C - Compensado; B - Pendente/Boleto */ 
);

DROP TABLE tb_comandas_hist;
CREATE TABLE IF NOT EXISTS tb_comandas_hist (
	seq int NOT NULL AUTO_INCREMENT,
    numero numeric(6) ZEROFILL NOT NULL,
    dt_cmd date NOT NULL,
    valor decimal(7,2) NOT NULL,
    descr varchar(50),
    status_cmd char(1) NOT NULL,
    dt_reg date NOT NULL,
    
    CONSTRAINT pk_comandas_hist PRIMARY KEY(seq)
);

CREATE TABLE IF NOT EXISTS tb_usuario(
	usuario_id int(4) NOT NULL AUTO_INCREMENT,
    usuario_login varchar(20) NOT NULL,
    usuario_nome varchar(50) NOT NULL,
    usuario_senha varchar(20) NOT NULL,
    usuario_status char(1) NOT NULL,
    
    CONSTRAINT pk_usuario PRIMARY KEY(usuario_id),
    CONSTRAINT uni_usuario UNIQUE(usuario_login),
    CONSTRAINT chk_usuario CHECK(usuario_status IN('A', 'I'))
    
    /*A - Administrador; I - Comum */
);

-- DROP TABLE tb_pagamentos;
CREATE TABLE IF NOT EXISTS tb_pagamentos(
	seq_pgto int NOT NULL AUTO_INCREMENT,
    pagador varchar(30) NOT NULL,
    valor decimal(7,2) NOT NULL,
    tipo_pgto char(1) NOT NULL,
    descr_pgto varchar(50),
    data_pgto date,
    
    CONSTRAINT pk_pgto PRIMARY KEY(seq_pgto),
    CONSTRAINT chk_pgto CHECK (tipo_pgto IN('A', 'B', 'C', 'D'))
    
    /* A - DINHEIRO | B - CARTÃO CRÉD/DÉB | C - CHEQUE | D - DEPÓSITO BANCÁRIO */
);

USE oficina;
CREATE TABLE IF NOT EXISTS tb_pagamentos_hist(
	seq_pgto_hist int NOT NULL AUTO_INCREMENT,
    seq_pgto int,
    pagador varchar(30) NOT NULL,
    valor decimal(7,2) NOT NULL,
    tipo_pgto char(1) NOT NULL,
    descr_pgto varchar(50),
    data_pgto date,
    
    CONSTRAINT pk_pgto_hist PRIMARY KEY(seq_pgto_hist),
    CONSTRAINT chk_pgto_hist CHECK (tipo_pgto IN('A', 'B', 'C', 'D'))
    
    /* A - DINHEIRO | B - CARTÃO CRÉD/DÉB | C - CHEQUE | D - DEPÓSITO BANCÁRIO */
);

SELECT * FROM tb_pagamentos;

USE oficina;
SELECT ROUND(SUM(valor), 2) AS valor FROM tb_pagamentos WHERE tipo_pgto = 'A';

INSERT INTO tb_usuario(usuario_login, usuario_nome, usuario_senha, usuario_status) VALUES('thiago', 'Thiago Menezes', 'tsm99', 'A');
INSERT INTO tb_usuario(usuario_login, usuario_nome, usuario_senha, usuario_status) VALUES('ratinho', 'Rosivaldo Menezes', 'rato76', 'A');
INSERT INTO tb_usuario(usuario_login, usuario_nome, usuario_senha, usuario_status) VALUES('ditynha', 'Edite Francelina', 'dity80', 'I');
INSERT INTO tb_usuario(usuario_login, usuario_nome, usuario_senha, usuario_status) VALUES('agatha', 'Agatha Menezes', 'nenem2014', 'I');

SELECT * FROM tb_usuario;
SELECT * FROM tb_usuario_hist;

SELECT * FROM tb_comandas;
SELECT * FROM tb_comandas_hist;

INSERT INTO tb_usuario_hist 
	SELECT * FROM tb_usuario;
    
/* INSERT INTO tb_comandas_hist(numero, dt_cmd, valor, descr, status_cmd, dt_reg)
	SELECT * FROM tb_comandas;
    
SELECT * FROM tb_comandas_hist; */
