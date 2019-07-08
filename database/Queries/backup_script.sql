USE oficina;

-- Cópia para tabela de histórico --
INSERT INTO tb_comandas_hist(numero, dt_cmd, valor, descr, status_cmd, dt_reg)
	SELECT * FROM tb_comandas;
    
SELECT * FROM tb_comandas_hist;

SELECT SUM(valor) AS 'Total Gasto' FROM tb_comandas_hist;

ROLLBACK;
DELETE FROM tb_comandas;
DELETE FROM tb_pagamentos;


-- ALTER TABLE tb_comandas_hist AUTO_INCREMENT = 1;

INSERT INTO tb_pagamentos_hist(seq_pgto, pagador, valor, tipo_pgto, descr_pgto, data_pgto)
	SELECT * FROM tb_pagamentos;

SELECT * FROM tb_pagamentos_hist;