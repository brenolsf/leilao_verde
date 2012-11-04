<?php 
	class Constantes {
		const SESSAO_USUARIO = "sessaousuario";
		const SESSAO_MENU = "sessaomenu";
		const SESSAO_SEGURANCA = "sessaoseguranca";
		const SESSAO_TELA = "sessaotela";
		const SESSAO_INTERNAUTA = "sessaointernauta";
		const SESSAO_DE_OLHO = "sessaodeolho";
		const LINKS_POR_PAGINA = 10;
		const TAMANHO_PAGINA = 10;
		const USA_TRILHA_AUDITORIA = false;

		const USA_CACHE = false;
		const FAZ_LOG = false;
		const ENVIA_EMAIL_ERRO = false;

		//################ CONEXAO COM O BANCO #################//
		const SERVIDOR_BANCO_PRODUCAO =  "localhost";
		const NOME_BANCO_PRODUCAO = "leilao";
		const LOGIN_BANCO_PRODUCAO = "root";
		const SENHA_BANCO_PRODUCAO = "123456";
		
		const IMAGEM_LARGURA = 800;
		const IMAGEM_ALTURA = 600;		
		const THUMB_LARGURA = 68;
		const THUMB_ALTURA = 68;
		
		const NOME_REMETENTE = "Leilão Verde";
		const EMAIL_REMETENTE = "lucky.world@gmail.com";
		
		const NOME_DESTINATARIO_ADMINISTRACAO = "Leilão Verde";
		const EMAIL_DESTINATARIO_ADMINISTRACAO = "lucky.world@gmail.com";
		const SITE_BASE = "http://localhost/NOMEDOSITE";
		const SITE_TITULO = "Leilão Verde";		
		
		const ERRO01_NAO_SALVA = "Não foi possível salvar. Tente novamente.";
		const ERRO01_NAO_EXCLUI = "Não foi possível excluir. Tente novamente."; 
		const ERRO03_OPERACAO_INVALIDA = "Desculpe-nos, você está tentando executar uma operação inválida. Tente novamente.";
		const ERRO04_USUARIO_NAO_ENCONTRADO = "Desculpe-nos, não foi possível acessar o sistema. O login ou senha não conferem.";
		const ERRO05_CSRF = "Desculpe-nos, não conseguimos processar sua requisição. Por favor, tente acessar novamente esta página em instantes.";
		const ERRO06_SOMENTE_LEITURA = "Desculpe-nos, estes dados não podem ser modificados.";
		const ERRO07_NAO_VER = "Desculpe-nos, os dados solicitados não podem ser visualizados.";
		const ERRO08_NAO_EXCLUIR = "Desculpe-nos, os dados solicitados não podem ser excluídos.";
		const ERRO09_NAO_INCLUIR = "Desculpe-nos, os dados informados não podem ser incluídos.";
		const ERRO10_NAO_ALTERAR = "Desculpe-nos, os dados solicitados não podem ser alterados.";
		const ERRO11_SENHA_NAO_CONFERE = 'A senha digitada no campo "Senha" não confere com o campo "Confirmar".';
		const ERRO12_CREDITO_INSUFICIENTE = 'A quantidade de "Créditos Ofertados" é superior ao saldo disponível de créditos válidos.';
		
		const LOGDEBUG = 1;
		const LOGINFO = 2;
		const LOGWARN = 3;
		const LOGERROR = 4;
		const LOGFATAL = 5;		

		const OID_PERFIL_ENTIDADE = 2;		
		
		const REGEXP_CPF = '/^([0-9]{2,3}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2})|(\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2})$/';
		const REGEXP_CNPJ = '/^([0-9]{2,3}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2})\$/';
		const REGEXP_TELEFONE = '/^(\d{2,3}|\(\d{2,3}\))?[ ]?\d{3,4}[-]?\d{3,4}$/';
		const REGEXP_CEP = '/^\d{5}(-\d{3})?$/';
		const REGEXP_DATA = '/^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/';
		const REGEXP_DATA_HORA = '/^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2})$|^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[2][0]\d{2}\s([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d)$/'; 
		
		//NEWSLETTER
		const CAMINHO_ABSOLUTO_IMAGEM_TEMPLATE = "http://localhost/newsletter/sistema/upload/diversas";
		const CAMINHO_ABSOLUTO_IMAGEM_IBROWSER = "/newsletter/sistema/upload/diversas/";
		const LINK_CONTA_INBOX = '<img src="http://localhost/newsletter/sistema/site/imagemNewsletter.php?id=#LINKCONTAINBOX#" border="0" width="1" height="1" />';
		const QUANTIDADE_EMAIL = 2;
		const MENSAGEM_RETORNO_SITE = 'Caso você não consiga visualizar esta newsletter <a href="#DESCRICAOLINKSITE#">clique aqui</a>';
		const LINK_RETORNO_SITE = 'http://localhost/newsletter/sistema/site/visualizarNewsletter.php?id=';
		const MENSAGEM_RETORNO_DESCADASTRO = 'Caso não você não deseje receber nossas newsletters, <a href="#DESCRICAOLINKDESCADASTRO#">clique aqui</a>.';
		const LINK_RETORNO_DESCADASTRO = "http://localhost/newsletter/sistema/site/descadastrarNewsletter.php?id=";
		
		
	}
?>