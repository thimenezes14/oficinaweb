CREATE DATABASE IF NOT EXISTS oficina;
USE oficina;

CREATE USER IF NOT EXISTS 'gu3000265'@'localhost' IDENTIFIED BY 'senha123';
GRANT ALL PRIVILEGES ON * TO 'gu3000265'@'localhost';

CREATE TABLE IF NOT EXISTS tb_comandas(
	numero numeric(6) ZEROFILL NOT NULL,
    dt_cmd date NOT NULL,
    dt_reg date NOT NULL,
    valor decimal(7,2) NOT NULL,
    status_cmd char(1) NOT NULL,
    
    CONSTRAINT pk_comandas PRIMARY KEY(numero, dt_cmd),
    CONSTRAINT chk_status CHECK(status_cmd IN('P', 'C', 'B'))
    /* P - Pendente; C - Compensado; B - Pendente/Boleto */ 
);