<?php 
	session_start();
	ob_start();
	require_once("../classes/view/EntidadeUIView.php");
	$objEntidadeView = new EntidadeView();
	$objEntidadeView->iniciar();
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?=Constantes::SITE_TITULO?>
:: Cadastro de Entidades</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css">
<link rel="stylesheet" type="text/css" href="css/leilao.css">
<link rel="stylesheet" type="text/css" href="css/dialogo.css">
<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="../css/leilaoIE8.css"><![endif]-->
<script src="js/jquery.js"></script>
<script src="js/jqueryUI/js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.meio.mask.js"></script>
<script type="text/javascript"> (function($){ $(function(){ $('input:text').setMask(); }  ); })(jQuery);</script>
</head>
<body>
<!-- Página Início -->
<div class="page">
  <?php include "cabecalho.php"; ?>
  <!-- Conteúdo Início -->
  <div class="clear"></div>
  <div class="content">
    <div id="content-titulo">Obrigado por realizar o seu cadastro.</div>
    <div id="content-corpo">
      <!-- Miolo inicio -->
      <div class="bemVindo">
        <p>Agora você faz parte de um seleto grupo de corporações e entidades empresarias das quais poderão desfrutar das vantagens de venda e aquisição de créditos de carbono, através de um processo limpo e legalizado, conforme o acordo internacional pelo Protocolo do Kyoto.</p>
        <br />
        <br />
        <p>Este processo de compra e venda de créditos, ou RCE (<strong>Redução Certificada de Emissões</strong>) é homologado pela <a href="http://www.bmfbovespa.com.br/pt-br/mercados/mercado-de-carbono/leiloes-de-credito-de-carbono.aspx?idioma=pt-br" target="_blank">BM&amp;F Bovespa</a> e está de acordo com a legislação vigente no Brasil. Maiores informações pelo site da <a href="http://unfccc.int/2860.php" target="_blank">United Nations Framework Convention on Climate Change</a>.</p>
        <br />
        <br />
        <p>Para acessar, basta clicar no botão abaixo, realizando o seu login através do seu CNPJ e senha cadastrados. Bons negócios!</p>
      </div>
      <div class="formulario">
        <div id="botoes">
          <input type="button" name="salvar" id="salvar" class="botao ok" value="Realizar Acesso" onclick="window.location.href='index.php';" />
        </div>
      </div>
      <!-- Miolo fim -->
    </div>
  </div>
  <!-- Conteúdo Fim -->
  <?php include "rodape.php"; ?>
</div>
<!-- Página Fim -->
<script src="js/padrao.js"></script>
</body>
</html>
