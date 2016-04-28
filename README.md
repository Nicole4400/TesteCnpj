# TesteCnpj
Sistema para obter informações de empresas do Espirito Santos feito para a empresa upLexis como teste técnico

Para o funcionamento do mesmo é necessário que um Banco Mysql local seja configurado no arquivo application/configs/application.ini.
Tal banco deve possuir:

Uma tabela user (id, login, password);
Uma tabela sintegra (id, id_usuario, cnpj, json);
