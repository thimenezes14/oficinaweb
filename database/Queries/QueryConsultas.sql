USE oficina;

/* SELEÇÃO COMPLETA */
SELECT * from tb_comandas;

/* SELEÇÃO DE VALORES COM 10% DE DESCONTO E ARREDONDAMENTO DE 2 CASAS DECIMAIS*/
SELECT ROUND(SUM(valor) * 0.9, 2) AS ValorTotaldePecas FROM tb_comandas;

/* SELEÇÃO DE MAIOR E MENOR VALOR, RESPECTIVAMENTE*/
SELECT ROUND(MAX(valor) * 0.9, 2) AS MaiorValor FROM tb_comandas;
SELECT ROUND(MIN(valor) * 0.9, 2) AS MenorValor FROM tb_comandas;