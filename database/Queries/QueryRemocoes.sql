USE oficina;

/* EXCLUIR CONSTRAINTS*/
ALTER TABLE tb_comandas
	DROP chk_status;
    
ALTER TABLE tb_comandas
	DROP pk_comandas;

/* EXCLUIR TABELA */
DROP TABLE tb_comandas;

/* EXCLUIR BASE DE DADOS */
DROP DATABASE oficina;